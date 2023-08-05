<?php

namespace App\Http\Controllers\Api;

use App\Models\HistoryScan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryScanResource;
use App\Http\Resources\HistoryScanCollection;
use App\Http\Requests\HistoryScanStoreRequest;
use App\Http\Requests\HistoryScanUpdateRequest;

class HistoryScanController extends Controller
{
    public function index(Request $request): HistoryScanCollection
    {
        $this->authorize('view-any', HistoryScan::class);

        $search = $request->get('search', '');

        $historyScans = HistoryScan::search($search)
            ->latest()
            ->paginate();

        return new HistoryScanCollection($historyScans);
    }

    public function store(HistoryScanStoreRequest $request): HistoryScanResource
    {
        $this->authorize('create', HistoryScan::class);

        $validated = $request->validated();

        $historyScan = HistoryScan::create($validated);

        return new HistoryScanResource($historyScan);
    }

    public function show(
        Request $request,
        HistoryScan $historyScan
    ): HistoryScanResource {
        $this->authorize('view', $historyScan);

        return new HistoryScanResource($historyScan);
    }

    public function update(
        HistoryScanUpdateRequest $request,
        HistoryScan $historyScan
    ): HistoryScanResource {
        $this->authorize('update', $historyScan);

        $validated = $request->validated();

        $historyScan->update($validated);

        return new HistoryScanResource($historyScan);
    }

    public function destroy(
        Request $request,
        HistoryScan $historyScan
    ): Response {
        $this->authorize('delete', $historyScan);

        $historyScan->delete();

        return response()->noContent();
    }
}
