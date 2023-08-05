<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Homeroom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherHomeroomsTest extends TestCase
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
    public function it_gets_teacher_homerooms(): void
    {
        $teacher = Teacher::factory()->create();
        $homerooms = Homeroom::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.homerooms.index', $teacher)
        );

        $response->assertOk()->assertSee($homerooms[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_homerooms(): void
    {
        $teacher = Teacher::factory()->create();
        $data = Homeroom::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.homerooms.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('homerooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $homeroom = Homeroom::latest('id')->first();

        $this->assertEquals($teacher->id, $homeroom->teacher_id);
    }
}
