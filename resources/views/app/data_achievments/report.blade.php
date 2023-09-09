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
                            <select class="form-control" name="class" id="class">
                                <option value="empty" disabled selected>Filter Laporan</option>
                                <option value="all">Semua Kelas</option>
                                @foreach ($classes as $value => $item)
                                    <option value="{{ $value }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-success btn-export">
                        <i class="fas fa-download d-inline-block mr-1"></i>Download Laporan</button>
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
                                    Nama Siswa
                                </th>
                                <th class="text-center">
                                    Jumlah Prestasi
                                </th>
                                <th class="text-center">
                                    Total Poin Prestasi
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="body-table">
                            @forelse($reports as $data)
                                <tr>
                                    <td>
                                        {{ $data['name'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data['achievmentsCount'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data['totalPoint'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('data.achievments.show.report', $data['student_id']) }}">
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
    <form action="{{ route('data.achievment.export') }}" method="get" class="form-export">
        <input type="hidden" name="class_student" id="input_class_student">
    </form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const objectString = JSON.stringify(@json($reports))
            const dataReport = JSON.parse(objectString)

            $("#class").on("input", (event) => {
                let value = $("#class").val()

                $("#input_class_student").val(value)

                let students = value !== 'all' ? dataReport.filter(item => item.class == value) : dataReport

                let markup = ``

                students.forEach(item => {
                    markup += `  <tr>
                                    <td>
                                        ${item.name}
                                    </td>
                                    <td class="text-center">
                                        ${item.achievmentsCount}
                                    </td>
                                    <td class="text-center">
                                        ${item.totalPoint}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('show/data-achievments-report') }}/${item.student_id}">
                                            <button type="button" class="btn btn-light">
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>`
                })
                $(".body-table").html(markup)
            })

            $(".btn-export").on("click", () => {
                $(`.form-export`).submit()
            })
        })
    </script>
@endpush
