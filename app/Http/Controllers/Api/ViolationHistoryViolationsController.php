<?php

namespace App\Http\Controllers\Api;

use App\Models\Violation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryViolationResource;
use App\Http\Resources\HistoryViolationCollection;

class ViolationHistoryViolationsController extends Controller
{
    public function index(
        Request $request,
        Violation $violation
    ): HistoryViolationCollection {
        $this->authorize('view', $violation);

        $search = $request->get('search', '');

        $historyViolations = $violation
            ->historyViolations()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryViolationCollection($historyViolations);
    }

    public function store(
        Request $request,
        Violation $violation
    ): HistoryViolationResource {
        $this->authorize('create', HistoryViolation::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
        ]);

        $historyViolation = $violation->historyViolations()->create($validated);

        return new HistoryViolationResource($historyViolation);
    }
}
