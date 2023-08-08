<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\HistoryAchievment;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Achievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryAchievmentTest extends TestCase
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
    public function it_gets_history_achievments_list(): void
    {
        $historyAchievments = HistoryAchievment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.history-achievments.index'));

        $response->assertOk()->assertSee($historyAchievments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_history_achievment(): void
    {
        $data = HistoryAchievment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.history-achievments.store'),
            $data
        );

        $this->assertDatabaseHas('history_achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_history_achievment(): void
    {
        $historyAchievment = HistoryAchievment::factory()->create();

        $student = Student::factory()->create();
        $teacher = Teacher::factory()->create();
        $achievment = Achievment::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'achievment_id' => $achievment->id,
        ];

        $response = $this->putJson(
            route('api.history-achievments.update', $historyAchievment),
            $data
        );

        $data['id'] = $historyAchievment->id;

        $this->assertDatabaseHas('history_achievments', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_history_achievment(): void
    {
        $historyAchievment = HistoryAchievment::factory()->create();

        $response = $this->deleteJson(
            route('api.history-achievments.destroy', $historyAchievment)
        );

        $this->assertModelMissing($historyAchievment);

        $response->assertNoContent();
    }
}
