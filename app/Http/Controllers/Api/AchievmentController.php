<?php

namespace App\Http\Controllers\Api;

use App\Models\Achievment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AchievmentResource;
use App\Http\Resources\AchievmentCollection;
use App\Http\Requests\AchievmentStoreRequest;
use App\Http\Requests\AchievmentUpdateRequest;

class AchievmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index(Request $request)
    {
        $this->authorize('student-view-any', Achievment::class);

        $achievments = Achievment::latest()->get();

        return AchievmentResource::collection($achievments);
    }

    public function store(AchievmentStoreRequest $request): AchievmentResource
    {
        $this->authorize('create', Achievment::class);

        $validated = $request->validated();

        $achievment = Achievment::create($validated);

        return new AchievmentResource($achievment);
    }

    public function show(
        Request $request,
        Achievment $achievment
    ): AchievmentResource {
        $this->authorize('view', $achievment);

        return new AchievmentResource($achievment);
    }

    public function update(
        AchievmentUpdateRequest $request,
        Achievment $achievment
    ): AchievmentResource {
        $this->authorize('update', $achievment);

        $validated = $request->validated();

        $achievment->update($validated);

        return new AchievmentResource($achievment);
    }

    public function destroy(Request $request, Achievment $achievment): Response
    {
        $this->authorize('delete', $achievment);

        $achievment->delete();

        return response()->noContent();
    }
}
