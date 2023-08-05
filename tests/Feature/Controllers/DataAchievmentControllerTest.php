<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DataAchievment;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Achievment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataAchievmentControllerTest extends TestCase
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
    public function it_displays_index_view_with_data_achievments(): void
    {
        $dataAchievments = DataAchievment::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('data-achievments.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.data_achievments.index')
            ->assertViewHas('dataAchievments');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_data_achievment(): void
    {
        $response = $this->get(route('data-achievments.create'));

        $response->assertOk()->assertViewIs('app.data_achievments.create');
    }

    /**
     * @test
     */
    public function it_stores_the_data_achievment(): void
    {
        $data = DataAchievment::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('data-achievments.store'), $data);

        $this->assertDatabaseHas('data_achievments', $data);

        $dataAchievment = DataAchievment::latest('id')->first();

        $response->assertRedirect(
            route('data-achievments.edit', $dataAchievment)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_data_achievment(): void
    {
        $dataAchievment = DataAchievment::factory()->create();

        $response = $this->get(route('data-achievments.show', $dataAchievment));

        $response
            ->assertOk()
            ->assertViewIs('app.data_achievments.show')
            ->assertViewHas('dataAchievment');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_data_achievment(): void
    {
        $dataAchievment = DataAchievment::factory()->create();

        $response = $this->get(route('data-achievments.edit', $dataAchievment));

        $response
            ->assertOk()
            ->assertViewIs('app.data_achievments.edit')
            ->assertViewHas('dataAchievment');
    }

    /**
     * @test
     */
    public function it_updates_the_data_achievment(): void
    {
        $dataAchievment = DataAchievment::factory()->create();

        $achievment = Achievment::factory()->create();
        $student = Student::factory()->create();
        $teacher = Teacher::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(15),
            'achievment_id' => $achievment->id,
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
        ];

        $response = $this->put(
            route('data-achievments.update', $dataAchievment),
            $data
        );

        $data['id'] = $dataAchievment->id;

        $this->assertDatabaseHas('data_achievments', $data);

        $response->assertRedirect(
            route('data-achievments.edit', $dataAchievment)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_data_achievment(): void
    {
        $dataAchievment = DataAchievment::factory()->create();

        $response = $this->delete(
            route('data-achievments.destroy', $dataAchievment)
        );

        $response->assertRedirect(route('data-achievments.index'));

        $this->assertModelMissing($dataAchievment);
    }
}
