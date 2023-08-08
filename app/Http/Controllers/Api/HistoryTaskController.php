<?php

namespace App\Http\Controllers\Api;

use App\Models\HistoryTask;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryTaskResource;
use App\Http\Resources\HistoryTaskCollection;
use App\Http\Requests\HistoryTaskStoreRequest;
use App\Http\Requests\HistoryTaskUpdateRequest;

class HistoryTaskController extends Controller
{
    public function index(Request $request): HistoryTaskCollection
    {
        $this->authorize('view-any', HistoryTask::class);

        $search = $request->get('search', '');

        $historyTasks = HistoryTask::search($search)
            ->latest()
            ->paginate();

        return new HistoryTaskCollection($historyTasks);
    }

    public function store(HistoryTaskStoreRequest $request): HistoryTaskResource
    {
        $this->authorize('create', HistoryTask::class);

        $validated = $request->validated();

        $historyTask = HistoryTask::create($validated);

        return new HistoryTaskResource($historyTask);
    }

    public function show(
        Request $request,
        HistoryTask $historyTask
    ): HistoryTaskResource {
        $this->authorize('view', $historyTask);

        return new HistoryTaskResource($historyTask);
    }

    public function update(
        HistoryTaskUpdateRequest $request,
        HistoryTask $historyTask
    ): HistoryTaskResource {
        $this->authorize('update', $historyTask);

        $validated = $request->validated();

        $historyTask->update($validated);

        return new HistoryTaskResource($historyTask);
    }

    public function destroy(
        Request $request,
        HistoryTask $historyTask
    ): Response {
        $this->authorize('delete', $historyTask);

        $historyTask->delete();

        return response()->noContent();
    }
}
