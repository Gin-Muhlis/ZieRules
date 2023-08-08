<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryViolationResource;
use App\Http\Resources\HistoryViolationCollection;

class StudentHistoryViolationsController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): HistoryViolationCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $historyViolations = $student
            ->historyViolations()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryViolationCollection($historyViolations);
    }

    public function store(
        Request $request,
        Student $student
    ): HistoryViolationResource {
        $this->authorize('create', HistoryViolation::class);

        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'violation_id' => ['required', 'exists:violations,id'],
            'date' => ['required', 'date'],
        ]);

        $historyViolation = $student->historyViolations()->create($validated);

        return new HistoryViolationResource($historyViolation);
    }
}
