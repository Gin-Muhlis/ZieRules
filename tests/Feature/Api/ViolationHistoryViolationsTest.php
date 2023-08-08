<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Violation;
use App\Models\HistoryViolation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViolationHistoryViolationsTest extends TestCase
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
    public function it_gets_violation_history_violations(): void
    {
        $violation = Violation::factory()->create();
        $historyViolations = HistoryViolation::factory()
            ->count(2)
            ->create([
                'violation_id' => $violation->id,
            ]);

        $response = $this->getJson(
            route('api.violations.history-violations.index', $violation)
        );

        $response->assertOk()->assertSee($historyViolations[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_violation_history_violations(): void
    {
        $violation = Violation::factory()->create();
        $data = HistoryViolation::factory()
            ->make([
                'violation_id' => $violation->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.violations.history-violations.store', $violation),
            $data
        );

        $this->assertDatabaseHas('history_violations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyViolation = HistoryViolation::latest('id')->first();

        $this->assertEquals($violation->id, $historyViolation->violation_id);
    }
}
