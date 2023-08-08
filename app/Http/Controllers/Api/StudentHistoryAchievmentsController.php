<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryAchievmentResource;
use App\Http\Resources\HistoryAchievmentCollection;

class StudentHistoryAchievmentsController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): HistoryAchievmentCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $historyAchievments = $student
            ->historyAchievments()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryAchievmentCollection($historyAchievments);
    }

    public function store(
        Request $request,
        Student $student
    ): HistoryAchievmentResource {
        $this->authorize('create', HistoryAchievment::class);

        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'achievment_id' => ['required', 'exists:achievments,id'],
            'date' => ['required', 'date'],
        ]);

        $historyAchievment = $student->historyAchievments()->create($validated);

        return new HistoryAchievmentResource($historyAchievment);
    }
}
