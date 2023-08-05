<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\HistoryScan;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherHistoryScansTest extends TestCase
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
    public function it_gets_teacher_history_scans(): void
    {
        $teacher = Teacher::factory()->create();
        $historyScans = HistoryScan::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.history-scans.index', $teacher)
        );

        $response->assertOk()->assertSee($historyScans[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_history_scans(): void
    {
        $teacher = Teacher::factory()->create();
        $data = HistoryScan::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.history-scans.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('history_scans', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyScan = HistoryScan::latest('id')->first();

        $this->assertEquals($teacher->id, $historyScan->teacher_id);
    }
}
