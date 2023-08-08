<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\HistoryAchievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentHistoryAchievmentsTest extends TestCase
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
    public function it_gets_student_history_achievments(): void
    {
        $student = Student::factory()->create();
        $historyAchievments = HistoryAchievment::factory()
            ->count(2)
            ->create([
                'student_id' => $student->id,
            ]);

        $response = $this->getJson(
            route('api.students.history-achievments.index', $student)
        );

        $response->assertOk()->assertSee($historyAchievments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_student_history_achievments(): void
    {
        $student = Student::factory()->create();
        $data = HistoryAchievment::factory()
            ->make([
                'student_id' => $student->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.students.history-achievments.store', $student),
            $data
        );

        $this->assertDatabaseHas('history_achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyAchievment = HistoryAchievment::latest('id')->first();

        $this->assertEquals($student->id, $historyAchievment->student_id);
    }
}
