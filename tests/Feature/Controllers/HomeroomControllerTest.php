<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Homeroom;

use App\Models\Teacher;
use App\Models\ClassStudent;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeroomControllerTest extends TestCase
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
    public function it_displays_index_view_with_homerooms(): void
    {
        $homerooms = Homeroom::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('homerooms.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.homerooms.index')
            ->assertViewHas('homerooms');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_homeroom(): void
    {
        $response = $this->get(route('homerooms.create'));

        $response->assertOk()->assertViewIs('app.homerooms.create');
    }

    /**
     * @test
     */
    public function it_stores_the_homeroom(): void
    {
        $data = Homeroom::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('homerooms.store'), $data);

        $this->assertDatabaseHas('homerooms', $data);

        $homeroom = Homeroom::latest('id')->first();

        $response->assertRedirect(route('homerooms.edit', $homeroom));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_homeroom(): void
    {
        $homeroom = Homeroom::factory()->create();

        $response = $this->get(route('homerooms.show', $homeroom));

        $response
            ->assertOk()
            ->assertViewIs('app.homerooms.show')
            ->assertViewHas('homeroom');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_homeroom(): void
    {
        $homeroom = Homeroom::factory()->create();

        $response = $this->get(route('homerooms.edit', $homeroom));

        $response
            ->assertOk()
            ->assertViewIs('app.homerooms.edit')
            ->assertViewHas('homeroom');
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

        $response = $this->put(route('homerooms.update', $homeroom), $data);

        $data['id'] = $homeroom->id;

        $this->assertDatabaseHas('homerooms', $data);

        $response->assertRedirect(route('homerooms.edit', $homeroom));
    }

    /**
     * @test
     */
    public function it_deletes_the_homeroom(): void
    {
        $homeroom = Homeroom::factory()->create();

        $response = $this->delete(route('homerooms.destroy', $homeroom));

        $response->assertRedirect(route('homerooms.index'));

        $this->assertModelMissing($homeroom);
    }
}
