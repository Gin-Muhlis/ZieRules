<?php

namespace App\Http\Controllers\Api;

use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ViolationResource;
use App\Http\Resources\ViolationCollection;
use App\Http\Requests\ViolationStoreRequest;
use App\Http\Requests\ViolationUpdateRequest;

class ViolationController extends Controller
{
    public function index(Request $request): ViolationCollection
    {
        $this->authorize('view-any', Violation::class);

        $search = $request->get('search', '');

        $violations = Violation::search($search)
            ->latest()
            ->paginate();

        return new ViolationCollection($violations);
    }

    public function store(ViolationStoreRequest $request): ViolationResource
    {
        $this->authorize('create', Violation::class);

        $validated = $request->validated();

        $violation = Violation::create($validated);

        return new ViolationResource($violation);
    }

    public function show(
        Request $request,
        Violation $violation
    ): ViolationResource {
        $this->authorize('view', $violation);

        return new ViolationResource($violation);
    }

    public function update(
        ViolationUpdateRequest $request,
        Violation $violation
    ): ViolationResource {
        $this->authorize('update', $violation);

        $validated = $request->validated();

        $violation->update($validated);

        return new ViolationResource($violation);
    }

    public function destroy(Request $request, Violation $violation): Response
    {
        $this->authorize('delete', $violation);

        $violation->delete();

        return response()->noContent();
    }
}
