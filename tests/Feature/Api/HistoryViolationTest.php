<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\HistoryViolation;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Violation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryViolationTest extends TestCase
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
    public function it_gets_history_violations_list(): void
    {
        $historyViolations = HistoryViolation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.history-violations.index'));

        $response->assertOk()->assertSee($historyViolations[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_history_violation(): void
    {
        $data = HistoryViolation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.history-violations.store'),
            $data
        );

        $this->assertDatabaseHas('history_violations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_history_violation(): void
    {
        $historyViolation = HistoryViolation::factory()->create();

        $student = Student::factory()->create();
        $teacher = Teacher::factory()->create();
        $violation = Violation::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'violation_id' => $violation->id,
        ];

        $response = $this->putJson(
            route('api.history-violations.update', $historyViolation),
            $data
        );

        $data['id'] = $historyViolation->id;

        $this->assertDatabaseHas('history_violations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_history_violation(): void
    {
        $historyViolation = HistoryViolation::factory()->create();

        $response = $this->deleteJson(
            route('api.history-violations.destroy', $historyViolation)
        );

        $this->assertModelMissing($historyViolation);

        $response->assertNoContent();
    }
}
