<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\DataViolation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentDataViolationsTest extends TestCase
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
    public function it_gets_student_data_violations(): void
    {
        $student = Student::factory()->create();
        $dataViolations = DataViolation::factory()
            ->count(2)
            ->create([
                'student_id' => $student->id,
            ]);

        $response = $this->getJson(
            route('api.students.data-violations.index', $student)
        );

        $response->assertOk()->assertSee($dataViolations[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_student_data_violations(): void
    {
        $student = Student::factory()->create();
        $data = DataViolation::factory()
            ->make([
                'student_id' => $student->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.students.data-violations.store', $student),
            $data
        );

        $this->assertDatabaseHas('data_violations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dataViolation = DataViolation::latest('id')->first();

        $this->assertEquals($student->id, $dataViolation->student_id);
    }
}
