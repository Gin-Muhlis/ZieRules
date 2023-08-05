<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomeroomResource;
use App\Http\Resources\HomeroomCollection;

class TeacherHomeroomsController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): HomeroomCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $homerooms = $teacher
            ->homerooms()
            ->search($search)
            ->latest()
            ->paginate();

        return new HomeroomCollection($homerooms);
    }

    public function store(Request $request, Teacher $teacher): HomeroomResource
    {
        $this->authorize('create', Homeroom::class);

        $validated = $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        $homeroom = $teacher->homerooms()->create($validated);

        return new HomeroomResource($homeroom);
    }
}
