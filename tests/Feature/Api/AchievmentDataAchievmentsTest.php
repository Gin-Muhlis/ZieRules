<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Achievment;
use App\Models\DataAchievment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AchievmentDataAchievmentsTest extends TestCase
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
    public function it_gets_achievment_data_achievments(): void
    {
        $achievment = Achievment::factory()->create();
        $dataAchievments = DataAchievment::factory()
            ->count(2)
            ->create([
                'achievment_id' => $achievment->id,
            ]);

        $response = $this->getJson(
            route('api.achievments.data-achievments.index', $achievment)
        );

        $response->assertOk()->assertSee($dataAchievments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_achievment_data_achievments(): void
    {
        $achievment = Achievment::factory()->create();
        $data = DataAchievment::factory()
            ->make([
                'achievment_id' => $achievment->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.achievments.data-achievments.store', $achievment),
            $data
        );

        $this->assertDatabaseHas('data_achievments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $dataAchievment = DataAchievment::latest('id')->first();

        $this->assertEquals($achievment->id, $dataAchievment->achievment_id);
    }
}
