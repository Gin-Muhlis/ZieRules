<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\HistoryTask;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherHistoryTasksTest extends TestCase
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
    public function it_gets_teacher_history_tasks(): void
    {
        $teacher = Teacher::factory()->create();
        $historyTasks = HistoryTask::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.history-tasks.index', $teacher)
        );

        $response->assertOk()->assertSee($historyTasks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_history_tasks(): void
    {
        $teacher = Teacher::factory()->create();
        $data = HistoryTask::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.history-tasks.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('history_tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyTask = HistoryTask::latest('id')->first();

        $this->assertEquals($teacher->id, $historyTask->teacher_id);
    }
}
