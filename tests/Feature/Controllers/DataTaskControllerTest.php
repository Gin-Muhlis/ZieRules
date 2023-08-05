<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DataTask;

use App\Models\Task;
use App\Models\Student;
use App\Models\Teacher;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataTaskControllerTest extends TestCase
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
    public function it_displays_index_view_with_data_tasks(): void
    {
        $dataTasks = DataTask::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('data-tasks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.data_tasks.index')
            ->assertViewHas('dataTasks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_data_task(): void
    {
        $response = $this->get(route('data-tasks.create'));

        $response->assertOk()->assertViewIs('app.data_tasks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_data_task(): void
    {
        $data = DataTask::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('data-tasks.store'), $data);

        $this->assertDatabaseHas('data_tasks', $data);

        $dataTask = DataTask::latest('id')->first();

        $response->assertRedirect(route('data-tasks.edit', $dataTask));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_data_task(): void
    {
        $dataTask = DataTask::factory()->create();

        $response = $this->get(route('data-tasks.show', $dataTask));

        $response
            ->assertOk()
            ->assertViewIs('app.data_tasks.show')
            ->assertViewHas('dataTask');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_data_task(): void
    {
        $dataTask = DataTask::factory()->create();

        $response = $this->get(route('data-tasks.edit', $dataTask));

        $response
            ->assertOk()
            ->assertViewIs('app.data_tasks.edit')
            ->assertViewHas('dataTask');
    }

    /**
     * @test
     */
    public function it_updates_the_data_task(): void
    {
        $dataTask = DataTask::factory()->create();

        $task = Task::factory()->create();
        $student = Student::factory()->create();
        $teacher = Teacher::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(15),
            'task_id' => $task->id,
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
        ];

        $response = $this->put(route('data-tasks.update', $dataTask), $data);

        $data['id'] = $dataTask->id;

        $this->assertDatabaseHas('data_tasks', $data);

        $response->assertRedirect(route('data-tasks.edit', $dataTask));
    }

    /**
     * @test
     */
    public function it_deletes_the_data_task(): void
    {
        $dataTask = DataTask::factory()->create();

        $response = $this->delete(route('data-tasks.destroy', $dataTask));

        $response->assertRedirect(route('data-tasks.index'));

        $this->assertModelMissing($dataTask);
    }
}
