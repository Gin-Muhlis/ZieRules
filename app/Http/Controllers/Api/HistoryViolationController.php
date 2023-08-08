<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\HistoryViolation;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryViolationResource;
use App\Http\Resources\HistoryViolationCollection;
use App\Http\Requests\HistoryViolationStoreRequest;
use App\Http\Requests\HistoryViolationUpdateRequest;

class HistoryViolationController extends Controller
{
    public function index(Request $request): HistoryViolationCollection
    {
        $this->authorize('view-any', HistoryViolation::class);

        $search = $request->get('search', '');

        $historyViolations = HistoryViolation::search($search)
            ->latest()
            ->paginate();

        return new HistoryViolationCollection($historyViolations);
    }

    public function store(
        HistoryViolationStoreRequest $request
    ): HistoryViolationResource {
        $this->authorize('create', HistoryViolation::class);

        $validated = $request->validated();

        $historyViolation = HistoryViolation::create($validated);

        return new HistoryViolationResource($historyViolation);
    }

    public function show(
        Request $request,
        HistoryViolation $historyViolation
    ): HistoryViolationResource {
        $this->authorize('view', $historyViolation);

        return new HistoryViolationResource($historyViolation);
    }

    public function update(
        HistoryViolationUpdateRequest $request,
        HistoryViolation $historyViolation
    ): HistoryViolationResource {
        $this->authorize('update', $historyViolation);

        $validated = $request->validated();

        $historyViolation->update($validated);

        return new HistoryViolationResource($historyViolation);
    }

    public function destroy(
        Request $request,
        HistoryViolation $historyViolation
    ): Response {
        $this->authorize('delete', $historyViolation);

        $historyViolation->delete();

        return response()->noContent();
    }
}
