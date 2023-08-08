<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\HistoryTask;

use App\Models\Task;
use App\Models\Student;
use App\Models\Teacher;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryTaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_history_tasks(): void
    {
        $historyTasks = HistoryTask::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('history-tasks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.history_tasks.index')
            ->assertViewHas('historyTasks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_history_task(): void
    {
        $response = $this->get(route('history-tasks.create'));

        $response->assertOk()->assertViewIs('app.history_tasks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_history_task(): void
    {
        $data = HistoryTask::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('history-tasks.store'), $data);

        $this->assertDatabaseHas('history_tasks', $data);

        $historyTask = HistoryTask::latest('id')->first();

        $response->assertRedirect(route('history-tasks.edit', $historyTask));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_history_task(): void
    {
        $historyTask = HistoryTask::factory()->create();

        $response = $this->get(route('history-tasks.show', $historyTask));

        $response
            ->assertOk()
            ->assertViewIs('app.history_tasks.show')
            ->assertViewHas('historyTask');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_history_task(): void
    {
        $historyTask = HistoryTask::factory()->create();

        $response = $this->get(route('history-tasks.edit', $historyTask));

        $response
            ->assertOk()
            ->assertViewIs('app.history_tasks.edit')
            ->assertViewHas('historyTask');
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

        $response = $this->put(
            route('history-tasks.update', $historyTask),
            $data
        );

        $data['id'] = $historyTask->id;

        $this->assertDatabaseHas('history_tasks', $data);

        $response->assertRedirect(route('history-tasks.edit', $historyTask));
    }

    /**
     * @test
     */
    public function it_deletes_the_history_task(): void
    {
        $historyTask = HistoryTask::factory()->create();

        $response = $this->delete(route('history-tasks.destroy', $historyTask));

        $response->assertRedirect(route('history-tasks.index'));

        $this->assertModelMissing($historyTask);
    }
}
