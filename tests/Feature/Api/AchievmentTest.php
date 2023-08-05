<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Achievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AchievmentTest extends TestCase
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
    public function it_gets_achievments_list(): void
    {
        $achievments = Achievment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.achievments.index'));

        $response->assertOk()->assertSee($achievments[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_achievment(): void
    {
        $data = Achievment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.achievments.store'), $data);

        $this->assertDatabaseHas('achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_achievment(): void
    {
        $achievment = Achievment::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'point' => $this->faker->randomNumber(0),
        ];

        $response = $this->putJson(
            route('api.achievments.update', $achievment),
            $data
        );

        $data['id'] = $achievment->id;

        $this->assertDatabaseHas('achievments', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_achievment(): void
    {
        $achievment = Achievment::factory()->create();

        $response = $this->deleteJson(
            route('api.achievments.destroy', $achievment)
        );

        $this->assertModelMissing($achievment);

        $response->assertNoContent();
    }
}
