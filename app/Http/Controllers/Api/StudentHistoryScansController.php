<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryScanResource;
use App\Http\Resources\HistoryScanCollection;

class StudentHistoryScansController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): HistoryScanCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $historyScans = $student
            ->historyScans()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryScanCollection($historyScans);
    }

    public function store(
        Request $request,
        Student $student
    ): HistoryScanResource {
        $this->authorize('create', HistoryScan::class);

        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
        ]);

        $historyScan = $student->historyScans()->create($validated);

        return new HistoryScanResource($historyScan);
    }
}
