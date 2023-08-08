<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\HistoryAchievment;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Achievment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryAchievmentControllerTest extends TestCase
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
    public function it_displays_index_view_with_history_achievments(): void
    {
        $historyAchievments = HistoryAchievment::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('history-achievments.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.history_achievments.index')
            ->assertViewHas('historyAchievments');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_history_achievment(): void
    {
        $response = $this->get(route('history-achievments.create'));

        $response->assertOk()->assertViewIs('app.history_achievments.create');
    }

    /**
     * @test
     */
    public function it_stores_the_history_achievment(): void
    {
        $data = HistoryAchievment::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('history-achievments.store'), $data);

        $this->assertDatabaseHas('history_achievments', $data);

        $historyAchievment = HistoryAchievment::latest('id')->first();

        $response->assertRedirect(
            route('history-achievments.edit', $historyAchievment)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_history_achievment(): void
    {
        $historyAchievment = HistoryAchievment::factory()->create();

        $response = $this->get(
            route('history-achievments.show', $historyAchievment)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.history_achievments.show')
            ->assertViewHas('historyAchievment');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_history_achievment(): void
    {
        $historyAchievment = HistoryAchievment::factory()->create();

        $response = $this->get(
            route('history-achievments.edit', $historyAchievment)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.history_achievments.edit')
            ->assertViewHas('historyAchievment');
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

        $response = $this->put(
            route('history-achievments.update', $historyAchievment),
            $data
        );

        $data['id'] = $historyAchievment->id;

        $this->assertDatabaseHas('history_achievments', $data);

        $response->assertRedirect(
            route('history-achievments.edit', $historyAchievment)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_history_achievment(): void
    {
        $historyAchievment = HistoryAchievment::factory()->create();

        $response = $this->delete(
            route('history-achievments.destroy', $historyAchievment)
        );

        $response->assertRedirect(route('history-achievments.index'));

        $this->assertModelMissing($historyAchievment);
    }
}
