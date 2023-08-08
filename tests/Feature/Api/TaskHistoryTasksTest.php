<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;
use App\Models\HistoryTask;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskHistoryTasksTest extends TestCase
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
    public function it_gets_task_history_tasks(): void
    {
        $task = Task::factory()->create();
        $historyTasks = HistoryTask::factory()
            ->count(2)
            ->create([
                'task_id' => $task->id,
            ]);

        $response = $this->getJson(
            route('api.tasks.history-tasks.index', $task)
        );

        $response->assertOk()->assertSee($historyTasks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_task_history_tasks(): void
    {
        $task = Task::factory()->create();
        $data = HistoryTask::factory()
            ->make([
                'task_id' => $task->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tasks.history-tasks.store', $task),
            $data
        );

        $this->assertDatabaseHas('history_tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyTask = HistoryTask::latest('id')->first();

        $this->assertEquals($task->id, $historyTask->task_id);
    }
}
