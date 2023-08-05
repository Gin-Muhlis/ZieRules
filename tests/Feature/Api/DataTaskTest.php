<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DataTask;

use App\Models\Task;
use App\Models\Student;
use App\Models\Teacher;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataTaskTest extends TestCase
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
    public function it_gets_data_tasks_list(): void
    {
        $dataTasks = DataTask::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.data-tasks.index'));

        $response->assertOk()->assertSee($dataTasks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_data_task(): void
    {
        $data = DataTask::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.data-tasks.store'), $data);

        $this->assertDatabaseHas('data_tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.data-tasks.update', $dataTask),
            $data
        );

        $data['id'] = $dataTask->id;

        $this->assertDatabaseHas('data_tasks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_data_task(): void
    {
        $dataTask = DataTask::factory()->create();

        $response = $this->deleteJson(
            route('api.data-tasks.destroy', $dataTask)
        );

        $this->assertModelMissing($dataTask);

        $response->assertNoContent();
    }
}
