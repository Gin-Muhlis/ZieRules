@php
    require_once app_path() . '/helpers/helpers.php';
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
           <div class="row">
                <div class="col-md-6">
                    <h2>Laporan Pelanggaran {{ $student_name }}</h2>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('data.violation.export.detail', $student_id) }}" class="btn btn-success btn-export">
                        <i class="fas fa-download d-inline-block mr-1"></i>Download Laporan
                        </a>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center">
                                    No
                                 </th>
                                <th class="text-left">
                                    Nama Siswa
                                 </th>
                                <th class="text-left">
                                    Tanggal
                                </th>
                                
                                <th class="text-left">
                                    Pelanggaran
                                </th>
                                <th class="text-center">
                                    Poin
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        {{ $data['student'] ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $data['date'] ? generateDate($data['date']) : '-' }}
                                    </td>
                                  
                                    <td>
                                        {{ $data['violation'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data['point'] ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="4" class="text-center">
                                    Total                
                                </td>
                                <td class="text-center">
                                    {{ $total_point }}
                                </td>
                    
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
