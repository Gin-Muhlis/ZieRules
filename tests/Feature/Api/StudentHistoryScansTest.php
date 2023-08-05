<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\HistoryScan;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentHistoryScansTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_student_history_scans(): void
    {
        $student = Student::factory()->create();
        $historyScans = HistoryScan::factory()
            ->count(2)
            ->create([
                'student_id' => $student->id,
            ]);

        $response = $this->getJson(
            route('api.students.history-scans.index', $student)
        );

        $response->assertOk()->assertSee($historyScans[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_student_history_scans(): void
    {
        $student = Student::factory()->create();
        $data = HistoryScan::factory()
            ->make([
                'student_id' => $student->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.students.history-scans.store', $student),
            $data
        );

        $this->assertDatabaseHas('history_scans', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyScan = HistoryScan::latest('id')->first();

        $this->assertEquals($student->id, $historyScan->student_id);
    }
}
