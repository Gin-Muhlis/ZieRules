<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Achievment;
use App\Models\HistoryAchievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AchievmentHistoryAchievmentsTest extends TestCase
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
    public function it_gets_achievment_history_achievments(): void
    {
        $achievment = Achievment::factory()->create();
        $historyAchievments = HistoryAchievment::factory()
            ->count(2)
            ->create([
                'achievment_id' => $achievment->id,
            ]);

        $response = $this->getJson(
            route('api.achievments.history-achievments.index', $achievment)
        );

        $response->assertOk()->assertSee($historyAchievments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_achievment_history_achievments(): void
    {
        $achievment = Achievment::factory()->create();
        $data = HistoryAchievment::factory()
            ->make([
                'achievment_id' => $achievment->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.achievments.history-achievments.store', $achievment),
            $data
        );

        $this->assertDatabaseHas('history_achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historyAchievment = HistoryAchievment::latest('id')->first();

        $this->assertEquals($achievment->id, $historyAchievment->achievment_id);
    }
}
