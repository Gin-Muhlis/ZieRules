<?php

namespace App\Http\Controllers\Api;

use App\Models\Violation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataViolationResource;
use App\Http\Resources\DataViolationCollection;

class ViolationDataViolationsController extends Controller
{
    public function index(
        Request $request,
        Violation $violation
    ): DataViolationCollection {
        $this->authorize('view', $violation);

        $search = $request->get('search', '');

        $dataViolations = $violation
            ->dataViolations()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataViolationCollection($dataViolations);
    }

    public function store(
        Request $request,
        Violation $violation
    ): DataViolationResource {
        $this->authorize('create', DataViolation::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataViolation = $violation->dataViolations()->create($validated);

        return new DataViolationResource($dataViolation);
    }
}
