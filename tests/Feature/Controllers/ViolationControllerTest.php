<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Violation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViolationControllerTest extends TestCase
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
    public function it_displays_index_view_with_violations(): void
    {
        $violations = Violation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('violations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.violations.index')
            ->assertViewHas('violations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_violation(): void
    {
        $response = $this->get(route('violations.create'));

        $response->assertOk()->assertViewIs('app.violations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_violation(): void
    {
        $data = Violation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('violations.store'), $data);

        $this->assertDatabaseHas('violations', $data);

        $violation = Violation::latest('id')->first();

        $response->assertRedirect(route('violations.edit', $violation));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_violation(): void
    {
        $violation = Violation::factory()->create();

        $response = $this->get(route('violations.show', $violation));

        $response
            ->assertOk()
            ->assertViewIs('app.violations.show')
            ->assertViewHas('violation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_violation(): void
    {
        $violation = Violation::factory()->create();

        $response = $this->get(route('violations.edit', $violation));

        $response
            ->assertOk()
            ->assertViewIs('app.violations.edit')
            ->assertViewHas('violation');
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

        $response = $this->put(route('violations.update', $violation), $data);

        $data['id'] = $violation->id;

        $this->assertDatabaseHas('violations', $data);

        $response->assertRedirect(route('violations.edit', $violation));
    }

    /**
     * @test
     */
    public function it_deletes_the_violation(): void
    {
        $violation = Violation::factory()->create();

        $response = $this->delete(route('violations.destroy', $violation));

        $response->assertRedirect(route('violations.index'));

        $this->assertModelMissing($violation);
    }
}
