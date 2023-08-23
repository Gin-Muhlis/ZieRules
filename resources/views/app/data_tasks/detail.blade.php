@php
    require_once app_path() . '/helpers/helpers.php';
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
               
                <div class="col-md-12 text-left">
                    <a href="{{ route('data.task.export.detail', $student_id) }}" class="btn btn-primary export-btn">Export Data</a>
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
                                    Tanggal
                                </th>
                                
                                <th class="text-left">
                                    Tugas
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $data)
                                <tr>
                                    <td>
                                        {{ $data['student'] ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $data['date'] ? generateDate($data['date']) : '-' }}
                                    </td>
                                    <td>
                                        {{ $data['task'] ?? '-' }}
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
