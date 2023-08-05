<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataAchievmentResource;
use App\Http\Resources\DataAchievmentCollection;

class StudentDataAchievmentsController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): DataAchievmentCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $dataAchievments = $student
            ->dataAchievments()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataAchievmentCollection($dataAchievments);
    }

    public function store(
        Request $request,
        Student $student
    ): DataAchievmentResource {
        $this->authorize('create', DataAchievment::class);

        $validated = $request->validate([
            'achievment_id' => ['required', 'exists:achievments,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataAchievment = $student->dataAchievments()->create($validated);

        return new DataAchievmentResource($dataAchievment);
    }
}
