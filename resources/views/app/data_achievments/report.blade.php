@php
    require_once app_path() . '/helpers/helpers.php';
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-12">
                    <form style="display: flex; justify-content: space-between; align-items: end; gap: 20px">
                        <div class="w-100">
                            <label for="dateStart">Tanggal Awal</label>
                            <input id="dateStart" type="date" name="date-start" value="{{ $date_start ?? '' }}"
                                class="form-control" autocomplete="off" />
                        </div>
                        <div class="w-100">
                            <label for="dateEnd">Tanggal Akhir</label>
                            <input id="dateEnd" type="date" name="date-end" value="{{ $date_end ?? '' }}"
                                class="form-control" autocomplete="off" />
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" style="width: 100px;">Cari Data</button>
                        </div>
                    </form>
                </div>
                @if ($errors->any())
                    <p class="text-danger my-3">{{ $errors->first() }}</p>
                @endif
                <div class="col-md-12 mt-4">
                    <button class="btn btn-primary export-btn">Export Data</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">
                        @lang('crud.data_prestasi.index_title')
                    </h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    @lang('crud.data_prestasi.inputs.achievment_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_prestasi.inputs.student_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_prestasi.inputs.teacher_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_prestasi.inputs.date')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_prestasi.inputs.description')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataAchievments as $dataAchievment)
                                <tr>
                                    <td>
                                        {{ optional($dataAchievment->achievment)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($dataAchievment->student)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($dataAchievment->teacher)->name ?? '-' }}
                                    </td>
                                    <td>{{ $dataAchievment->date ? generateDate($dataAchievment->date->toDateString()) : '-' }}
                                    </td>
                                    <td>{{ $dataAchievment->description ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $dataAchievment)
                                                <a href="{{ route('data-achievments.edit', $dataAchievment) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $dataAchievment)
                                                <a href="{{ route('data-achievments.show', $dataAchievment) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $dataAchievment)
                                                <form action="{{ route('data-achievments.destroy', $dataAchievment) }}"
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
    <form action="{{ route('data.achievment.export') }}" class="export-form">
        <input type="hidden" name="date-start" id="hidden-date-start">
        <input type="hidden" name="date-end" id="hidden-date-end">
    </form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#hidden-date-start").val($("#dateStart").val())
            $("#hidden-date-end").val($("#dateEnd").val())

            $("#dateStart").on("change", function() {
                $("#hidden-date-start").val($(this).val())
            })
            $("#dateEnd").on("change", function() {
                $("#hidden-date-end").val($(this).val())
            })
            $(".export-btn").on("click", function() {
                $(".export-form").submit()
            })
        })
    </script>
@endpush
