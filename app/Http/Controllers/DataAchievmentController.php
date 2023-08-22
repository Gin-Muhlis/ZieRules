<?php

namespace App\Http\Controllers;

use App\Exports\DataAchievmentExport;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\Achievment;
use Illuminate\Http\Request;
use App\Models\DataAchievment;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DataAchievmentStoreRequest;
use App\Http\Requests\DataAchievmentUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

class DataAchievmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', DataAchievment::class);

        $search = $request->get('search', '');

        $dataAchievments = DataAchievment::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.data_achievments.index',
            compact('dataAchievments', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', DataAchievment::class);

        $achievments = Achievment::pluck('name', 'id');
        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view(
            'app.data_achievments.create',
            compact('achievments', 'students', 'teachers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataAchievmentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', DataAchievment::class);

        $validated = $request->validated();

        $dataAchievment = DataAchievment::create($validated);

        return redirect()
            ->route('data-achievments.edit', $dataAchievment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, DataAchievment $dataAchievment): View
    {
        $this->authorize('view', $dataAchievment);

        return view('app.data_achievments.show', compact('dataAchievment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, DataAchievment $dataAchievment): View
    {
        $this->authorize('update', $dataAchievment);

        $achievments = Achievment::pluck('name', 'id');
        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view(
            'app.data_achievments.edit',
            compact('dataAchievment', 'achievments', 'students', 'teachers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DataAchievmentUpdateRequest $request,
        DataAchievment $dataAchievment
    ): RedirectResponse {
        $this->authorize('update', $dataAchievment);

        $validated = $request->validated();

        $dataAchievment->update($validated);

        return redirect()
            ->route('data-achievments.edit', $dataAchievment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        DataAchievment $dataAchievment
    ): RedirectResponse {
        $this->authorize('delete', $dataAchievment);

        $dataAchievment->delete();

        return redirect()
            ->route('data-achievments.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function report(Request $request)
    {
        $this->authorize('view-any', DataAchievment::class);

        $date_start = $request->input('date-start') ?? null;
        $date_end = $request->input('date-end') ?? null;

        $dataAchievments = DataAchievment::with(['achievment', 'teacher', 'student'])->get();

        if (!is_null($date_start) && !is_null($date_end)) {
            // dd($date_end);
            $dataAchievments = DataAchievment::with(['achievment', 'teacher', 'student'])->whereBetween('date', [$date_start, $date_end], 'and')->latest()->get();
        }

        return view(
            'app.data_achievments.report',
            compact('dataAchievments', 'date_start', 'date_end')
        );

    }

    public function exportData(Request $request)
    {
        $date_start = $request->input('date-start') ?? null;
        $date_end = $request->input('date-end') ?? null;

        if (!is_null($date_start) && !is_null($date_end)) {
          
            return Excel::download(new DataAchievmentExport($date_start, $date_end), 'data_prestasi.xlsx');
        }

        return Excel::download(new DataAchievmentExport, 'data_prestasi.xlsx');
    }
}
