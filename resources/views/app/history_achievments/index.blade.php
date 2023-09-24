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
                    @can('create', App\Models\HistoryAchievment::class)
                        <a href="{{ route('history-achievments.create') }}" class="btn btn-primary">
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
                                    @lang('crud.catatan_scan_prestasi.inputs.student_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.catatan_scan_prestasi.inputs.teacher_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.catatan_scan_prestasi.inputs.achievment_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.catatan_scan_prestasi.inputs.date')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historyAchievments as $historyAchievment)
                                <tr>
                                    <td>
                                        {{ optional($historyAchievment->student)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($historyAchievment->teacher)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($historyAchievment->achievment)->name ?? '-' }}
                                    </td>
                                    <td>{{ $historyAchievment->date ? generateDate($historyAchievment->date->toDateString()) : '-' }}
                                    </td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $historyAchievment)
                                                <a href="{{ route('history-achievments.edit', $historyAchievment) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $historyAchievment)
                                                <a href="{{ route('history-achievments.show', $historyAchievment) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $historyAchievment)
                                                <form action="{{ route('history-achievments.destroy', $historyAchievment) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-light text-danger">
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
