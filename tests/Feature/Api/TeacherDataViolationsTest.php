<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\DataViolation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherDataViolationsTest extends TestCase
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
    public function it_gets_teacher_data_violations(): void
    {
        $teacher = Teacher::factory()->create();
        $dataViolations = DataViolation::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.data-violations.index', $teacher)
        );

        $response->assertOk()->assertSee($dataViolations[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_data_violations(): void
    {
        $teacher = Teacher::factory()->create();
        $data = DataViolation::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.data-violations.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('data_violations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dataViolation = DataViolation::latest('id')->first();

        $this->assertEquals($teacher->id, $dataViolation->teacher_id);
    }
}
