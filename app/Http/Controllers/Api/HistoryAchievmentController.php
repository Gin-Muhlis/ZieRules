<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\HistoryAchievment;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryAchievmentResource;
use App\Http\Resources\HistoryAchievmentCollection;
use App\Http\Requests\HistoryAchievmentStoreRequest;
use App\Http\Requests\HistoryAchievmentUpdateRequest;

class HistoryAchievmentController extends Controller
{
    public function index(Request $request): HistoryAchievmentCollection
    {
        $this->authorize('view-any', HistoryAchievment::class);

        $search = $request->get('search', '');

        $historyAchievments = HistoryAchievment::search($search)
            ->latest()
            ->paginate();

        return new HistoryAchievmentCollection($historyAchievments);
    }

    public function store(
        HistoryAchievmentStoreRequest $request
    ): HistoryAchievmentResource {
        $this->authorize('create', HistoryAchievment::class);

        $validated = $request->validated();

        $historyAchievment = HistoryAchievment::create($validated);

        return new HistoryAchievmentResource($historyAchievment);
    }

    public function show(
        Request $request,
        HistoryAchievment $historyAchievment
    ): HistoryAchievmentResource {
        $this->authorize('view', $historyAchievment);

        return new HistoryAchievmentResource($historyAchievment);
    }

    public function update(
        HistoryAchievmentUpdateRequest $request,
        HistoryAchievment $historyAchievment
    ): HistoryAchievmentResource {
        $this->authorize('update', $historyAchievment);

        $validated = $request->validated();

        $historyAchievment->update($validated);

        return new HistoryAchievmentResource($historyAchievment);
    }

    public function destroy(
        Request $request,
        HistoryAchievment $historyAchievment
    ): Response {
        $this->authorize('delete', $historyAchievment);

        $historyAchievment->delete();

        return response()->noContent();
    }
}
