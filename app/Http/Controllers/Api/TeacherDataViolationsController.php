<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataViolationResource;
use App\Http\Resources\DataViolationCollection;

class TeacherDataViolationsController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): DataViolationCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $dataViolations = $teacher
            ->dataViolations()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataViolationCollection($dataViolations);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): DataViolationResource {
        $this->authorize('create', DataViolation::class);

        $validated = $request->validate([
            'violation_id' => ['required', 'exists:violations,id'],
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataViolation = $teacher->dataViolations()->create($validated);

        return new DataViolationResource($dataViolation);
    }
}
