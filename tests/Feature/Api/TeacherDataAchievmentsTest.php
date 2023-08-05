<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\DataAchievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherDataAchievmentsTest extends TestCase
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
    public function it_gets_teacher_data_achievments(): void
    {
        $teacher = Teacher::factory()->create();
        $dataAchievments = DataAchievment::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.data-achievments.index', $teacher)
        );

        $response->assertOk()->assertSee($dataAchievments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_data_achievments(): void
    {
        $teacher = Teacher::factory()->create();
        $data = DataAchievment::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.data-achievments.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('data_achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dataAchievment = DataAchievment::latest('id')->first();

        $this->assertEquals($teacher->id, $dataAchievment->teacher_id);
    }
}
