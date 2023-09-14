<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Quote;

use App\Models\Teacher;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuoteControllerTest extends TestCase
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
    public function it_displays_index_view_with_quotes(): void
    {
        $quotes = Quote::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('quotes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.quotes.index')
            ->assertViewHas('quotes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_quote(): void
    {
        $response = $this->get(route('quotes.create'));

        $response->assertOk()->assertViewIs('app.quotes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_quote(): void
    {
        $data = Quote::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('quotes.store'), $data);

        $this->assertDatabaseHas('quotes', $data);

        $quote = Quote::latest('id')->first();

        $response->assertRedirect(route('quotes.edit', $quote));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_quote(): void
    {
        $quote = Quote::factory()->create();

        $response = $this->get(route('quotes.show', $quote));

        $response
            ->assertOk()
            ->assertViewIs('app.quotes.show')
            ->assertViewHas('quote');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_quote(): void
    {
        $quote = Quote::factory()->create();

        $response = $this->get(route('quotes.edit', $quote));

        $response
            ->assertOk()
            ->assertViewIs('app.quotes.edit')
            ->assertViewHas('quote');
    }

    /**
     * @test
     */
    public function it_updates_the_quote(): void
    {
        $quote = Quote::factory()->create();

        $teacher = Teacher::factory()->create();

        $data = [
            'quote' => $this->faker->text(),
            'date' => $this->faker->date(),
            'teacher_id' => $teacher->id,
        ];

        $response = $this->put(route('quotes.update', $quote), $data);

        $data['id'] = $quote->id;

        $this->assertDatabaseHas('quotes', $data);

        $response->assertRedirect(route('quotes.edit', $quote));
    }

    /**
     * @test
     */
    public function it_deletes_the_quote(): void
    {
        $quote = Quote::factory()->create();

        $response = $this->delete(route('quotes.destroy', $quote));

        $response->assertRedirect(route('quotes.index'));

        $this->assertModelMissing($quote);
    }
}
