<?php

namespace App\Http\Controllers;

use App\Imports\AchievmentImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Models\Achievment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AchievmentStoreRequest;
use App\Http\Requests\AchievmentUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;

class AchievmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Achievment::class);

        $achievments = Achievment::all();

        return view('app.achievments.index', compact('achievments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Achievment::class);

        return view('app.achievments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AchievmentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Achievment::class);

        $validated = $request->validated();

        $achievment = Achievment::create($validated);

        return redirect()
            ->route('achievments.edit', $achievment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Achievment $achievment): View
    {
        $this->authorize('view', $achievment);

        return view('app.achievments.show', compact('achievment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Achievment $achievment): View
    {
        $this->authorize('update', $achievment);

        return view('app.achievments.edit', compact('achievment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        AchievmentUpdateRequest $request,
        Achievment $achievment
    ): RedirectResponse {
        $this->authorize('update', $achievment);

        $validated = $request->validated();

        $achievment->update($validated);

        return redirect()
            ->route('achievments.edit', $achievment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Achievment $achievment
    ): RedirectResponse {
        $this->authorize('delete', $achievment);

        $achievment->delete();

        return redirect()
            ->route('achievments.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function import(Request $request) {
        $this->authorize('create', Achievment::class);

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,csv'
        ], [
            'file.mimes' => 'File harus ber ekstensi .xlsx atau .csv'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        Excel::import(new AchievmentImport, $validated['file']);

        return redirect()->back()->with('success', 'Import data berhasil');

    }
}
