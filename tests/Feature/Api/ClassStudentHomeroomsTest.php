<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Homeroom;
use App\Models\ClassStudent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassStudentHomeroomsTest extends TestCase
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
    public function it_gets_class_student_homerooms(): void
    {
        $classStudent = ClassStudent::factory()->create();
        $homerooms = Homeroom::factory()
            ->count(2)
            ->create([
                'class_id' => $classStudent->id,
            ]);

        $response = $this->getJson(
            route('api.class-students.homerooms.index', $classStudent)
        );

        $response->assertOk()->assertSee($homerooms[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_class_student_homerooms(): void
    {
        $classStudent = ClassStudent::factory()->create();
        $data = Homeroom::factory()
            ->make([
                'class_id' => $classStudent->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.class-students.homerooms.store', $classStudent),
            $data
        );

        $this->assertDatabaseHas('homerooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $homeroom = Homeroom::latest('id')->first();

        $this->assertEquals($classStudent->id, $homeroom->class_id);
    }
}
