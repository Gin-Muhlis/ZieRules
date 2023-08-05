<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;
use App\Models\DataTask;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskDataTasksTest extends TestCase
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
    public function it_gets_task_data_tasks(): void
    {
        $task = Task::factory()->create();
        $dataTasks = DataTask::factory()
            ->count(2)
            ->create([
                'task_id' => $task->id,
            ]);

        $response = $this->getJson(route('api.tasks.data-tasks.index', $task));

        $response->assertOk()->assertSee($dataTasks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_task_data_tasks(): void
    {
        $task = Task::factory()->create();
        $data = DataTask::factory()
            ->make([
                'task_id' => $task->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tasks.data-tasks.store', $task),
            $data
        );

        $this->assertDatabaseHas('data_tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dataTask = DataTask::latest('id')->first();

        $this->assertEquals($task->id, $dataTask->task_id);
    }
}
