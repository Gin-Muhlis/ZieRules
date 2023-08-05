<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DataAchievment;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Achievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataAchievmentTest extends TestCase
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
    public function it_gets_data_achievments_list(): void
    {
        $dataAchievments = DataAchievment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.data-achievments.index'));

        $response->assertOk()->assertSee($dataAchievments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_data_achievment(): void
    {
        $data = DataAchievment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.data-achievments.store'), $data);

        $this->assertDatabaseHas('data_achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.data-achievments.update', $dataAchievment),
            $data
        );

        $data['id'] = $dataAchievment->id;

        $this->assertDatabaseHas('data_achievments', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_data_achievment(): void
    {
        $dataAchievment = DataAchievment::factory()->create();

        $response = $this->deleteJson(
            route('api.data-achievments.destroy', $dataAchievment)
        );

        $this->assertModelMissing($dataAchievment);

        $response->assertNoContent();
    }
}
