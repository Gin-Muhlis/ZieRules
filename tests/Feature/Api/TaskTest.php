<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
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
    public function it_gets_tasks_list(): void
    {
        $tasks = Task::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tasks.index'));

        $response->assertOk()->assertSee($tasks[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_task(): void
    {
        $data = Task::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tasks.store'), $data);

        $this->assertDatabaseHas('tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_task(): void
    {
        $task = Task::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->putJson(route('api.tasks.update', $task), $data);

        $data['id'] = $task->id;

        $this->assertDatabaseHas('tasks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson(route('api.tasks.destroy', $task));

        $this->assertModelMissing($task);

        $response->assertNoContent();
    }
}
