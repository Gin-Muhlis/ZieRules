<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataAchievmentResource;
use App\Http\Resources\DataAchievmentCollection;

class TeacherDataAchievmentsController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): DataAchievmentCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $dataAchievments = $teacher
            ->dataAchievments()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataAchievmentCollection($dataAchievments);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): DataAchievmentResource {
        $this->authorize('create', DataAchievment::class);

        $validated = $request->validate([
            'achievment_id' => ['required', 'exists:achievments,id'],
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataAchievment = $teacher->dataAchievments()->create($validated);

        return new DataAchievmentResource($dataAchievment);
    }
}
