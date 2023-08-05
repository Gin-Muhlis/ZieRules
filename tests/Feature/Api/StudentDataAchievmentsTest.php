<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\DataAchievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentDataAchievmentsTest extends TestCase
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
    public function it_gets_student_data_achievments(): void
    {
        $student = Student::factory()->create();
        $dataAchievments = DataAchievment::factory()
            ->count(2)
            ->create([
                'student_id' => $student->id,
            ]);

        $response = $this->getJson(
            route('api.students.data-achievments.index', $student)
        );

        $response->assertOk()->assertSee($dataAchievments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_student_data_achievments(): void
    {
        $student = Student::factory()->create();
        $data = DataAchievment::factory()
            ->make([
                'student_id' => $student->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.students.data-achievments.store', $student),
            $data
        );

        $this->assertDatabaseHas('data_achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dataAchievment = DataAchievment::latest('id')->first();

        $this->assertEquals($student->id, $dataAchievment->student_id);
    }
}
