<?php

namespace App\Http\Controllers\Api;

use App\Models\DataTask;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataTaskResource;
use App\Http\Resources\DataTaskCollection;
use App\Http\Requests\DataTaskStoreRequest;
use App\Http\Requests\DataTaskUpdateRequest;

class DataTaskController extends Controller
{
    public function index(Request $request): DataTaskCollection
    {
        $this->authorize('view-any', DataTask::class);

        $search = $request->get('search', '');

        $dataTasks = DataTask::search($search)
            ->latest()
            ->paginate();

        return new DataTaskCollection($dataTasks);
    }

    public function store(DataTaskStoreRequest $request): DataTaskResource
    {
        $this->authorize('create', DataTask::class);

        $validated = $request->validated();

        $dataTask = DataTask::create($validated);

        return new DataTaskResource($dataTask);
    }

    public function show(Request $request, DataTask $dataTask): DataTaskResource
    {
        $this->authorize('view', $dataTask);

        return new DataTaskResource($dataTask);
    }

    public function update(
        DataTaskUpdateRequest $request,
        DataTask $dataTask
    ): DataTaskResource {
        $this->authorize('update', $dataTask);

        $validated = $request->validated();

        $dataTask->update($validated);

        return new DataTaskResource($dataTask);
    }

    public function destroy(Request $request, DataTask $dataTask): Response
    {
        $this->authorize('delete', $dataTask);

        $dataTask->delete();

        return response()->noContent();
    }
}
