<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\HistoryTask;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentHistoryTasksTest extends TestCase
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
    public function it_gets_student_history_tasks(): void
    {
        $student = Student::factory()->create();
        $historyTasks = HistoryTask::factory()
            ->count(2)
            ->create([
                'student_id' => $student->id,
            ]);

        $response = $this->getJson(
            route('api.students.history-tasks.index', $student)
        );

        $response->assertOk()->assertSee($historyTasks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_student_history_tasks(): void
    {
        $student = Student::factory()->create();
        $data = HistoryTask::factory()
            ->make([
                'student_id' => $student->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.students.history-tasks.store', $student),
            $data
        );

        $this->assertDatabaseHas('history_tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyTask = HistoryTask::latest('id')->first();

        $this->assertEquals($student->id, $historyTask->student_id);
    }
}
