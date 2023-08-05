<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DataAchievment;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataAchievmentResource;
use App\Http\Resources\DataAchievmentCollection;
use App\Http\Requests\DataAchievmentStoreRequest;
use App\Http\Requests\DataAchievmentUpdateRequest;

class DataAchievmentController extends Controller
{
    public function index(Request $request): DataAchievmentCollection
    {
        $this->authorize('view-any', DataAchievment::class);

        $search = $request->get('search', '');

        $dataAchievments = DataAchievment::search($search)
            ->latest()
            ->paginate();

        return new DataAchievmentCollection($dataAchievments);
    }

    public function store(
        DataAchievmentStoreRequest $request
    ): DataAchievmentResource {
        $this->authorize('create', DataAchievment::class);

        $validated = $request->validated();

        $dataAchievment = DataAchievment::create($validated);

        return new DataAchievmentResource($dataAchievment);
    }

    public function show(
        Request $request,
        DataAchievment $dataAchievment
    ): DataAchievmentResource {
        $this->authorize('view', $dataAchievment);

        return new DataAchievmentResource($dataAchievment);
    }

    public function update(
        DataAchievmentUpdateRequest $request,
        DataAchievment $dataAchievment
    ): DataAchievmentResource {
        $this->authorize('update', $dataAchievment);

        $validated = $request->validated();

        $dataAchievment->update($validated);

        return new DataAchievmentResource($dataAchievment);
    }

    public function destroy(
        Request $request,
        DataAchievment $dataAchievment
    ): Response {
        $this->authorize('delete', $dataAchievment);

        $dataAchievment->delete();

        return response()->noContent();
    }
}
