<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\HistoryAchievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherHistoryAchievmentsTest extends TestCase
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
    public function it_gets_teacher_history_achievments(): void
    {
        $teacher = Teacher::factory()->create();
        $historyAchievments = HistoryAchievment::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.history-achievments.index', $teacher)
        );

        $response->assertOk()->assertSee($historyAchievments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_history_achievments(): void
    {
        $teacher = Teacher::factory()->create();
        $data = HistoryAchievment::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.history-achievments.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('history_achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyAchievment = HistoryAchievment::latest('id')->first();

        $this->assertEquals($teacher->id, $historyAchievment->teacher_id);
    }
}
