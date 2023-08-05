<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataViolationResource;
use App\Http\Resources\DataViolationCollection;

class StudentDataViolationsController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): DataViolationCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $dataViolations = $student
            ->dataViolations()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataViolationCollection($dataViolations);
    }

    public function store(
        Request $request,
        Student $student
    ): DataViolationResource {
        $this->authorize('create', DataViolation::class);

        $validated = $request->validate([
            'violation_id' => ['required', 'exists:violations,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataViolation = $student->dataViolations()->create($validated);

        return new DataViolationResource($dataViolation);
    }
}
