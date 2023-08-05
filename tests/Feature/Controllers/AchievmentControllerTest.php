<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Achievment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AchievmentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_achievments(): void
    {
        $achievments = Achievment::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('achievments.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.achievments.index')
            ->assertViewHas('achievments');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_achievment(): void
    {
        $response = $this->get(route('achievments.create'));

        $response->assertOk()->assertViewIs('app.achievments.create');
    }

    /**
     * @test
     */
    public function it_stores_the_achievment(): void
    {
        $data = Achievment::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('achievments.store'), $data);

        $this->assertDatabaseHas('achievments', $data);

        $achievment = Achievment::latest('id')->first();

        $response->assertRedirect(route('achievments.edit', $achievment));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_achievment(): void
    {
        $achievment = Achievment::factory()->create();

        $response = $this->get(route('achievments.show', $achievment));

        $response
            ->assertOk()
            ->assertViewIs('app.achievments.show')
            ->assertViewHas('achievment');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_achievment(): void
    {
        $achievment = Achievment::factory()->create();

        $response = $this->get(route('achievments.edit', $achievment));

        $response
            ->assertOk()
            ->assertViewIs('app.achievments.edit')
            ->assertViewHas('achievment');
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

        $response = $this->put(route('achievments.update', $achievment), $data);

        $data['id'] = $achievment->id;

        $this->assertDatabaseHas('achievments', $data);

        $response->assertRedirect(route('achievments.edit', $achievment));
    }

    /**
     * @test
     */
    public function it_deletes_the_achievment(): void
    {
        $achievment = Achievment::factory()->create();

        $response = $this->delete(route('achievments.destroy', $achievment));

        $response->assertRedirect(route('achievments.index'));

        $this->assertModelMissing($achievment);
    }
}
