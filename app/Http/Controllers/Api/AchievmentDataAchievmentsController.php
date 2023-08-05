<?php

namespace App\Http\Controllers\Api;

use App\Models\Achievment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataAchievmentResource;
use App\Http\Resources\DataAchievmentCollection;

class AchievmentDataAchievmentsController extends Controller
{
    public function index(
        Request $request,
        Achievment $achievment
    ): DataAchievmentCollection {
        $this->authorize('view', $achievment);

        $search = $request->get('search', '');

        $dataAchievments = $achievment
            ->dataAchievments()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataAchievmentCollection($dataAchievments);
    }

    public function store(
        Request $request,
        Achievment $achievment
    ): DataAchievmentResource {
        $this->authorize('create', DataAchievment::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataAchievment = $achievment->dataAchievments()->create($validated);

        return new DataAchievmentResource($dataAchievment);
    }
}
