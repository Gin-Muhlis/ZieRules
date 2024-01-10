@php
    require_once app_path() . '/helpers/helpers.php';
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <h3>
                   Catatan Scan Pelanggaran
               </h3>
           </div>
            <div class="col-md-6 text-right">
                @can('create', App\Models\HistoryViolation::class)
                <a
                    href="{{ route('history-violations.create') }}"
                    class="btn btn-primary"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.catatan_scan_pelanggaran.inputs.student_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.catatan_scan_pelanggaran.inputs.teacher_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.catatan_scan_pelanggaran.inputs.violation_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.catatan_scan_pelanggaran.inputs.date')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historyViolations as $historyViolation)
                        <tr>
                            <td>
                                {{ optional($historyViolation->student)->name ??
                                '-' }}
                            </td>
                            <td>
                                {{ optional($historyViolation->teacher)->name ??
                                '-' }}
                            </td>
                            <td>
                                {{ optional($historyViolation->violation)->name
                                ?? '-' }}
                            </td>
                            <td>{{ $historyViolation->date ? generateDate($historyViolation->date->toDateString()) : '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $historyViolation)
                                    <a
                                        href="{{ route('history-violations.edit', $historyViolation) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $historyViolation)
                                    <a
                                        href="{{ route('history-violations.show', $historyViolation) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $historyViolation)
                                    <form
                                        action="{{ route('history-violations.destroy', $historyViolation) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
