<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\HistoryScan;

use App\Models\Teacher;
use App\Models\Student;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistoryScanControllerTest extends TestCase
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
    public function it_displays_index_view_with_history_scans(): void
    {
        $historyScans = HistoryScan::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('history-scans.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.history_scans.index')
            ->assertViewHas('historyScans');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_history_scan(): void
    {
        $response = $this->get(route('history-scans.create'));

        $response->assertOk()->assertViewIs('app.history_scans.create');
    }

    /**
     * @test
     */
    public function it_stores_the_history_scan(): void
    {
        $data = HistoryScan::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('history-scans.store'), $data);

        $this->assertDatabaseHas('history_scans', $data);

        $historyScan = HistoryScan::latest('id')->first();

        $response->assertRedirect(route('history-scans.edit', $historyScan));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_history_scan(): void
    {
        $historyScan = HistoryScan::factory()->create();

        $response = $this->get(route('history-scans.show', $historyScan));

        $response
            ->assertOk()
            ->assertViewIs('app.history_scans.show')
            ->assertViewHas('historyScan');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_history_scan(): void
    {
        $historyScan = HistoryScan::factory()->create();

        $response = $this->get(route('history-scans.edit', $historyScan));

        $response
            ->assertOk()
            ->assertViewIs('app.history_scans.edit')
            ->assertViewHas('historyScan');
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

        $response = $this->put(
            route('history-scans.update', $historyScan),
            $data
        );

        $data['id'] = $historyScan->id;

        $this->assertDatabaseHas('history_scans', $data);

        $response->assertRedirect(route('history-scans.edit', $historyScan));
    }

    /**
     * @test
     */
    public function it_deletes_the_history_scan(): void
    {
        $historyScan = HistoryScan::factory()->create();

        $response = $this->delete(route('history-scans.destroy', $historyScan));

        $response->assertRedirect(route('history-scans.index'));

        $this->assertModelMissing($historyScan);
    }
}
