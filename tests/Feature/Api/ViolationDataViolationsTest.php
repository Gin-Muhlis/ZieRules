<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Violation;
use App\Models\DataViolation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViolationDataViolationsTest extends TestCase
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
    public function it_gets_violation_data_violations(): void
    {
        $violation = Violation::factory()->create();
        $dataViolations = DataViolation::factory()
            ->count(2)
            ->create([
                'violation_id' => $violation->id,
            ]);

        $response = $this->getJson(
            route('api.violations.data-violations.index', $violation)
        );

        $response->assertOk()->assertSee($dataViolations[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_violation_data_violations(): void
    {
        $violation = Violation::factory()->create();
        $data = DataViolation::factory()
            ->make([
                'violation_id' => $violation->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.violations.data-violations.store', $violation),
            $data
        );

        $this->assertDatabaseHas('data_violations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dataViolation = DataViolation::latest('id')->first();

        $this->assertEquals($violation->id, $dataViolation->violation_id);
    }
}
