<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Homeroom;

use App\Models\Teacher;
use App\Models\ClassStudent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeroomTest extends TestCase
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
    public function it_gets_homerooms_list(): void
    {
        $homerooms = Homeroom::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.homerooms.index'));

        $response->assertOk()->assertSee($homerooms[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_homeroom(): void
    {
        $data = Homeroom::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.homerooms.store'), $data);

        $this->assertDatabaseHas('homerooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_homeroom(): void
    {
        $homeroom = Homeroom::factory()->create();

        $teacher = Teacher::factory()->create();
        $classStudent = ClassStudent::factory()->create();

        $data = [
            'teacher_id' => $teacher->id,
            'class_id' => $classStudent->id,
        ];

        $response = $this->putJson(
            route('api.homerooms.update', $homeroom),
            $data
        );

        $data['id'] = $homeroom->id;

        $this->assertDatabaseHas('homerooms', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_homeroom(): void
    {
        $homeroom = Homeroom::factory()->create();

        $response = $this->deleteJson(
            route('api.homerooms.destroy', $homeroom)
        );

        $this->assertModelMissing($homeroom);

        $response->assertNoContent();
    }
}
