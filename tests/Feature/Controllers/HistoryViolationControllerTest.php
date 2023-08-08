<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\HistoryViolation;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Violation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryViolationControllerTest extends TestCase
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
    public function it_displays_index_view_with_history_violations(): void
    {
        $historyViolations = HistoryViolation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('history-violations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.history_violations.index')
            ->assertViewHas('historyViolations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_history_violation(): void
    {
        $response = $this->get(route('history-violations.create'));

        $response->assertOk()->assertViewIs('app.history_violations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_history_violation(): void
    {
        $data = HistoryViolation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('history-violations.store'), $data);

        $this->assertDatabaseHas('history_violations', $data);

        $historyViolation = HistoryViolation::latest('id')->first();

        $response->assertRedirect(
            route('history-violations.edit', $historyViolation)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_history_violation(): void
    {
        $historyViolation = HistoryViolation::factory()->create();

        $response = $this->get(
            route('history-violations.show', $historyViolation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.history_violations.show')
            ->assertViewHas('historyViolation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_history_violation(): void
    {
        $historyViolation = HistoryViolation::factory()->create();

        $response = $this->get(
            route('history-violations.edit', $historyViolation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.history_violations.edit')
            ->assertViewHas('historyViolation');
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

        $response = $this->put(
            route('history-violations.update', $historyViolation),
            $data
        );

        $data['id'] = $historyViolation->id;

        $this->assertDatabaseHas('history_violations', $data);

        $response->assertRedirect(
            route('history-violations.edit', $historyViolation)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_history_violation(): void
    {
        $historyViolation = HistoryViolation::factory()->create();

        $response = $this->delete(
            route('history-violations.destroy', $historyViolation)
        );

        $response->assertRedirect(route('history-violations.index'));

        $this->assertModelMissing($historyViolation);
    }
}
