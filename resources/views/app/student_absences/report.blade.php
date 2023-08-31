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
                        <a href="" class="btn btn-primary export-btn">Export Data</a>
    
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
                                   Kelas
                                </th>
                                <th class="text-left">
                                    Hadir
                                </th>
                                <th class="text-left">
                                    Izin
                                </th>
                                <th class="text-left">
                                    Sakit
                                </th>
                                <th class="text-left">
                                    Tanpa Keterangan
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
                                        {{ $data['student'] ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $data['class'] ?? '-' }}
                                    </td>
                                    <td class="trext-center">
                                        {{ $data['hadir'] ?? '-' }}
                                    </td>
                                    <td class="trext-center">
                                        {{ $data['izin'] ?? '-' }}
                                    </td>
                                    <td class="trext-center">
                                        {{ $data['sakit'] ?? '-' }}
                                    </td>
                                    <td class="trext-center">
                                        {{ $data['tanpa_keterangan'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="">
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
