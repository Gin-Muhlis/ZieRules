<?php

namespace App\Http\Controllers\Api;

use App\Models\Achievment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryAchievmentResource;
use App\Http\Resources\HistoryAchievmentCollection;

class AchievmentHistoryAchievmentsController extends Controller
{
    public function index(
        Request $request,
        Achievment $achievment
    ): HistoryAchievmentCollection {
        $this->authorize('view', $achievment);

        $search = $request->get('search', '');

        $historyAchievments = $achievment
            ->historyAchievments()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryAchievmentCollection($historyAchievments);
    }

    public function store(
        Request $request,
        Achievment $achievment
    ): HistoryAchievmentResource {
        $this->authorize('create', HistoryAchievment::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
        ]);

        $historyAchievment = $achievment
            ->historyAchievments()
            ->create($validated);

        return new HistoryAchievmentResource($historyAchievment);
    }
}
