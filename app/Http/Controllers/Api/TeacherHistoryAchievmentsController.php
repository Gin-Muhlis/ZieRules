<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryAchievmentResource;
use App\Http\Resources\HistoryAchievmentCollection;

class TeacherHistoryAchievmentsController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): HistoryAchievmentCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $historyAchievments = $teacher
            ->historyAchievments()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryAchievmentCollection($historyAchievments);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): HistoryAchievmentResource {
        $this->authorize('create', HistoryAchievment::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'achievment_id' => ['required', 'exists:achievments,id'],
            'date' => ['required', 'date'],
        ]);

        $historyAchievment = $teacher->historyAchievments()->create($validated);

        return new HistoryAchievmentResource($historyAchievment);
    }
}
