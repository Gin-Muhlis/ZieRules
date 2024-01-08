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
                       Data Pelanggaran Siswa
                   </h3>
               </div>
                <div class="col-md-6 text-right">
                    @can('create', App\Models\DataViolation::class)
                        <a href="{{ route('data-violations.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    @lang('crud.data_pelanggaran.inputs.violation_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_pelanggaran.inputs.student_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_pelanggaran.inputs.teacher_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_pelanggaran.inputs.date')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_pelanggaran.inputs.description')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataViolations as $dataViolation)
                                <tr>
                                    <td>
                                        {{ optional($dataViolation->violation)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($dataViolation->student)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($dataViolation->teacher)->name ?? '-' }}
                                    </td>
                                    <td>{{ $dataViolation->date ? generateDate($dataViolation->date->toDateString()) : '-' }}
                                    </td>
                                    <td>{{ $dataViolation->description ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $dataViolation)
                                                <a href="{{ route('data-violations.edit', $dataViolation) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $dataViolation)
                                                <a href="{{ route('data-violations.show', $dataViolation) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $dataViolation)
                                                <form action="{{ route('data-violations.destroy', $dataViolation) }}"
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
                                    <td colspan="6">
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
