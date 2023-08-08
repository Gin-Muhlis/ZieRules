<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryViolationResource;
use App\Http\Resources\HistoryViolationCollection;

class TeacherHistoryViolationsController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): HistoryViolationCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $historyViolations = $teacher
            ->historyViolations()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryViolationCollection($historyViolations);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): HistoryViolationResource {
        $this->authorize('create', HistoryViolation::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'violation_id' => ['required', 'exists:violations,id'],
            'date' => ['required', 'date'],
        ]);

        $historyViolation = $teacher->historyViolations()->create($validated);

        return new HistoryViolationResource($historyViolation);
    }
}
