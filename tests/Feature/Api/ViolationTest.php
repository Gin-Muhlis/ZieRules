<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Violation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViolationTest extends TestCase
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
    public function it_gets_violations_list(): void
    {
        $violations = Violation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.violations.index'));

        $response->assertOk()->assertSee($violations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_violation(): void
    {
        $data = Violation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.violations.store'), $data);

        $this->assertDatabaseHas('violations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_violation(): void
    {
        $violation = Violation::factory()->create();

        $data = [
            'name' => $this->faker->text(255),
            'point' => $this->faker->randomNumber(0),
        ];

        $response = $this->putJson(
            route('api.violations.update', $violation),
            $data
        );

        $data['id'] = $violation->id;

        $this->assertDatabaseHas('violations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_violation(): void
    {
        $violation = Violation::factory()->create();

        $response = $this->deleteJson(
            route('api.violations.destroy', $violation)
        );

        $this->assertModelMissing($violation);

        $response->assertNoContent();
    }
}
