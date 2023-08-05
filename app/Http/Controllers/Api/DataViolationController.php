<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DataViolation;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataViolationResource;
use App\Http\Resources\DataViolationCollection;
use App\Http\Requests\DataViolationStoreRequest;
use App\Http\Requests\DataViolationUpdateRequest;

class DataViolationController extends Controller
{
    public function index(Request $request): DataViolationCollection
    {
        $this->authorize('view-any', DataViolation::class);

        $search = $request->get('search', '');

        $dataViolations = DataViolation::search($search)
            ->latest()
            ->paginate();

        return new DataViolationCollection($dataViolations);
    }

    public function store(
        DataViolationStoreRequest $request
    ): DataViolationResource {
        $this->authorize('create', DataViolation::class);

        $validated = $request->validated();

        $dataViolation = DataViolation::create($validated);

        return new DataViolationResource($dataViolation);
    }

    public function show(
        Request $request,
        DataViolation $dataViolation
    ): DataViolationResource {
        $this->authorize('view', $dataViolation);

        return new DataViolationResource($dataViolation);
    }

    public function update(
        DataViolationUpdateRequest $request,
        DataViolation $dataViolation
    ): DataViolationResource {
        $this->authorize('update', $dataViolation);

        $validated = $request->validated();

        $dataViolation->update($validated);

        return new DataViolationResource($dataViolation);
    }

    public function destroy(
        Request $request,
        DataViolation $dataViolation
    ): Response {
        $this->authorize('delete', $dataViolation);

        $dataViolation->delete();

        return response()->noContent();
    }
}
