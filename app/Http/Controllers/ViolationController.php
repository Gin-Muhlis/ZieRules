<?php

namespace App\Http\Controllers;

use App\Imports\ViolationImport;
use App\Models\Violation;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ViolationStoreRequest;
use App\Http\Requests\ViolationUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Violation::class);

        $violations = Violation::all();

        return view('app.violations.index', compact('violations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Violation::class);

        return view('app.violations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ViolationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Violation::class);

        $validated = $request->validated();

        $violation = Violation::create($validated);

        return redirect()
            ->route('violations.edit', $violation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Violation $violation): View
    {
        $this->authorize('view', $violation);

        return view('app.violations.show', compact('violation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Violation $violation): View
    {
        $this->authorize('update', $violation);

        return view('app.violations.edit', compact('violation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ViolationUpdateRequest $request,
        Violation $violation
    ): RedirectResponse {
        $this->authorize('update', $violation);

        $validated = $request->validated();

        $violation->update($validated);

        return redirect()
            ->route('violations.edit', $violation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Violation $violation
    ): RedirectResponse {
        $this->authorize('delete', $violation);

        $violation->delete();

        return redirect()
            ->route('violations.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function import(Request $request) {
        $this->authorize('create', Violation::class);

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,csv'
        ], [
            'file.mimes' => 'File harus ber ekstensi .xlsx atau .csv'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        Excel::import(new ViolationImport, $validated['file']);

        return redirect()->back()->with('success', 'Import data berhasil');

    }
}
