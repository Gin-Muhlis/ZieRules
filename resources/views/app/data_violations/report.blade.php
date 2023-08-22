@php
    require_once app_path() . '/helpers/helpers.php';
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="indexSearch" type="text" name="search" placeholder="{{ __('crud.common.search') }}"
                                value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                        <a href="{{ route('data.violation.export') }}" class="btn btn-primary export-btn">Export Data</a>
    
                </div>
                
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">
                        @lang('crud.data_pelanggaran.index_title')
                    </h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Nama Siswa
                                </th>
                                <th class="text-left">
                                   Jumlah pelanggaran
                                </th>
                                <th class="text-left">
                                    Total Poin Pelanggaran
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $data)
                                <tr>
                                    <td>
                                        {{ $data['name'] ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $data['violationsCount'] ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $data['totalPoint'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('data.violations.show.report', $data['student_id']) }}">
                                            <button type="button" class="btn btn-light">
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
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
