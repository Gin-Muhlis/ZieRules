<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quote;
use App\Models\Teacher;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherQuotesTest extends TestCase
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
    public function it_gets_teacher_quotes(): void
    {
        $teacher = Teacher::factory()->create();
        $quotes = Quote::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.quotes.index', $teacher)
        );

        $response->assertOk()->assertSee($quotes[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_quotes(): void
    {
        $teacher = Teacher::factory()->create();
        $data = Quote::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.quotes.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('quotes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $quote = Quote::latest('id')->first();

        $this->assertEquals($teacher->id, $quote->teacher_id);
    }
}
