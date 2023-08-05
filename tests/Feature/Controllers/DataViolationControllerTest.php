<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DataViolation;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Violation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataViolationControllerTest extends TestCase
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
    public function it_displays_index_view_with_data_violations(): void
    {
        $dataViolations = DataViolation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('data-violations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.data_violations.index')
            ->assertViewHas('dataViolations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_data_violation(): void
    {
        $response = $this->get(route('data-violations.create'));

        $response->assertOk()->assertViewIs('app.data_violations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_data_violation(): void
    {
        $data = DataViolation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('data-violations.store'), $data);

        $this->assertDatabaseHas('data_violations', $data);

        $dataViolation = DataViolation::latest('id')->first();

        $response->assertRedirect(
            route('data-violations.edit', $dataViolation)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_data_violation(): void
    {
        $dataViolation = DataViolation::factory()->create();

        $response = $this->get(route('data-violations.show', $dataViolation));

        $response
            ->assertOk()
            ->assertViewIs('app.data_violations.show')
            ->assertViewHas('dataViolation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_data_violation(): void
    {
        $dataViolation = DataViolation::factory()->create();

        $response = $this->get(route('data-violations.edit', $dataViolation));

        $response
            ->assertOk()
            ->assertViewIs('app.data_violations.edit')
            ->assertViewHas('dataViolation');
    }

    /**
     * @test
     */
    public function it_updates_the_data_violation(): void
    {
        $dataViolation = DataViolation::factory()->create();

        $student = Student::factory()->create();
        $violation = Violation::factory()->create();
        $teacher = Teacher::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(15),
            'student_id' => $student->id,
            'violation_id' => $violation->id,
            'teacher_id' => $teacher->id,
        ];

        $response = $this->put(
            route('data-violations.update', $dataViolation),
            $data
        );

        $data['id'] = $dataViolation->id;

        $this->assertDatabaseHas('data_violations', $data);

        $response->assertRedirect(
            route('data-violations.edit', $dataViolation)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_data_violation(): void
    {
        $dataViolation = DataViolation::factory()->create();

        $response = $this->delete(
            route('data-violations.destroy', $dataViolation)
        );

        $response->assertRedirect(route('data-violations.index'));

        $this->assertModelMissing($dataViolation);
    }
}
