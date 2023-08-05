<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryScanResource;
use App\Http\Resources\HistoryScanCollection;

class TeacherHistoryScansController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): HistoryScanCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $historyScans = $teacher
            ->historyScans()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryScanCollection($historyScans);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): HistoryScanResource {
        $this->authorize('create', HistoryScan::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
        ]);

        $historyScan = $teacher->historyScans()->create($validated);

        return new HistoryScanResource($historyScan);
    }
}
