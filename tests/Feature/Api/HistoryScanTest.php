<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\HistoryScan;

use App\Models\Teacher;
use App\Models\Student;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryScanTest extends TestCase
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
    public function it_gets_history_scans_list(): void
    {
        $historyScans = HistoryScan::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.history-scans.index'));

        $response->assertOk()->assertSee($historyScans[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_history_scan(): void
    {
        $data = HistoryScan::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.history-scans.store'), $data);

        $this->assertDatabaseHas('history_scans', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_history_scan(): void
    {
        $historyScan = HistoryScan::factory()->create();

        $teacher = Teacher::factory()->create();
        $student = Student::factory()->create();

        $data = [
            'teacher_id' => $teacher->id,
            'student_id' => $student->id,
        ];

        $response = $this->putJson(
            route('api.history-scans.update', $historyScan),
            $data
        );

        $data['id'] = $historyScan->id;

        $this->assertDatabaseHas('history_scans', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_history_scan(): void
    {
        $historyScan = HistoryScan::factory()->create();

        $response = $this->deleteJson(
            route('api.history-scans.destroy', $historyScan)
        );

        $this->assertModelMissing($historyScan);

        $response->assertNoContent();
    }
}
