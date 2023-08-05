<?php

namespace App\Http\Controllers\Api;

use App\Models\ClassStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomeroomResource;
use App\Http\Resources\HomeroomCollection;

class ClassStudentHomeroomsController extends Controller
{
    public function index(
        Request $request,
        ClassStudent $classStudent
    ): HomeroomCollection {
        $this->authorize('view', $classStudent);

        $search = $request->get('search', '');

        $homerooms = $classStudent
            ->homerooms()
            ->search($search)
            ->latest()
            ->paginate();

        return new HomeroomCollection($homerooms);
    }

    public function store(
        Request $request,
        ClassStudent $classStudent
    ): HomeroomResource {
        $this->authorize('create', Homeroom::class);

        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
        ]);

        $homeroom = $classStudent->homerooms()->create($validated);

        return new HomeroomResource($homeroom);
    }
}
