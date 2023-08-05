<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\DataTask;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherDataTasksTest extends TestCase
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
    public function it_gets_teacher_data_tasks(): void
    {
        $teacher = Teacher::factory()->create();
        $dataTasks = DataTask::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.data-tasks.index', $teacher)
        );

        $response->assertOk()->assertSee($dataTasks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_data_tasks(): void
    {
        $teacher = Teacher::factory()->create();
        $data = DataTask::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.data-tasks.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('data_tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dataTask = DataTask::latest('id')->first();

        $this->assertEquals($teacher->id, $dataTask->teacher_id);
    }
}
