<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\HistoryTask;

use App\Models\Task;
use App\Models\Student;
use App\Models\Teacher;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryTaskTest extends TestCase
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
    public function it_gets_history_tasks_list(): void
    {
        $historyTasks = HistoryTask::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.history-tasks.index'));

        $response->assertOk()->assertSee($historyTasks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_history_task(): void
    {
        $data = HistoryTask::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.history-tasks.store'), $data);

        $this->assertDatabaseHas('history_tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_history_task(): void
    {
        $historyTask = HistoryTask::factory()->create();

        $student = Student::factory()->create();
        $teacher = Teacher::factory()->create();
        $task = Task::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'task_id' => $task->id,
        ];

        $response = $this->putJson(
            route('api.history-tasks.update', $historyTask),
            $data
        );

        $data['id'] = $historyTask->id;

        $this->assertDatabaseHas('history_tasks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_history_task(): void
    {
        $historyTask = HistoryTask::factory()->create();

        $response = $this->deleteJson(
            route('api.history-tasks.destroy', $historyTask)
        );

        $this->assertModelMissing($historyTask);

        $response->assertNoContent();
    }
}
