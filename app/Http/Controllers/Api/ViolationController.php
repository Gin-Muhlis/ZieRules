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
    /**
     * inisialisasi middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * get all violation
     * @return ViolationCollection
     */
    public function index()
    {
        $this->authorize('student-view-any', Violation::class);

        $violations = Violation::latest()->get();

        return ViolationResource::collection($violations);
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
