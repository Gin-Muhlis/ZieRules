<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DataViolation;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Violation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataViolationTest extends TestCase
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
    public function it_gets_data_violations_list(): void
    {
        $dataViolations = DataViolation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.data-violations.index'));

        $response->assertOk()->assertSee($dataViolations[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_data_violation(): void
    {
        $data = DataViolation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.data-violations.store'), $data);

        $this->assertDatabaseHas('data_violations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.data-violations.update', $dataViolation),
            $data
        );

        $data['id'] = $dataViolation->id;

        $this->assertDatabaseHas('data_violations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_data_violation(): void
    {
        $dataViolation = DataViolation::factory()->create();

        $response = $this->deleteJson(
            route('api.data-violations.destroy', $dataViolation)
        );

        $this->assertModelMissing($dataViolation);

        $response->assertNoContent();
    }
}
