<?php

namespace App\Http\Controllers\Api;

use App\Models\Homeroom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomeroomResource;
use App\Http\Resources\HomeroomCollection;
use App\Http\Requests\HomeroomStoreRequest;
use App\Http\Requests\HomeroomUpdateRequest;

class HomeroomController extends Controller
{
    public function index(Request $request): HomeroomCollection
    {
        $this->authorize('view-any', Homeroom::class);

        $search = $request->get('search', '');

        $homerooms = Homeroom::search($search)
            ->latest()
            ->paginate();

        return new HomeroomCollection($homerooms);
    }

    public function store(HomeroomStoreRequest $request): HomeroomResource
    {
        $this->authorize('create', Homeroom::class);

        $validated = $request->validated();

        $homeroom = Homeroom::create($validated);

        return new HomeroomResource($homeroom);
    }

    public function show(Request $request, Homeroom $homeroom): HomeroomResource
    {
        $this->authorize('view', $homeroom);

        return new HomeroomResource($homeroom);
    }

    public function update(
        HomeroomUpdateRequest $request,
        Homeroom $homeroom
    ): HomeroomResource {
        $this->authorize('update', $homeroom);

        $validated = $request->validated();

        $homeroom->update($validated);

        return new HomeroomResource($homeroom);
    }

    public function destroy(Request $request, Homeroom $homeroom): Response
    {
        $this->authorize('delete', $homeroom);

        $homeroom->delete();

        return response()->noContent();
    }
}
