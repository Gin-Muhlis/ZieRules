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
                                @foreach ($classes as $value => $item)
                                    <option value="{{ $value }}" {{ $value === $firstClass->id ? 'selected' : '' }}>{{ $item }}</option>
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
                        @lang('crud.data_pelanggaran.index_title')
                    </h4>
                </div>

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
                                <th class="text-center">
                                    Hadir
                                </th>
                                <th class="text-center">
                                    Izin
                                </th>
                                <th class="text-center">
                                    Sakit
                                </th>
                                <th class="text-center">
                                    Tanpa Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="body-table">
                            @forelse($reports as $data)
                                <tr>
                                    <td class="text-center">
                                        {{$loop->index + 1}}
                                    </td>
                                    <td>
                                        {{ $data['name'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data['presences'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data['permissions'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data['sicks'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data['withoutExplanations'] ?? '-' }}
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
    <form action="{{ route('data.absence.export') }}" method="get" class="form-export">
        <input type="hidden" name="class_student" id="input_class_student" value="{{ $firstClass->id }}">
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const objectString = JSON.stringify(@json($dataReport))
            const dataReport = JSON.parse(objectString)

            $("#class").on("input", (event) => {
                let value = $("#class").val()

                $("#input_class_student").val(value)

                let students = dataReport.filter(item => item.class == value)
                let markup = ``

                students.forEach((item, index) => {
                    markup += `<tr>
                                    <td class="text-center">
                                        ${index + 1}
                                    </td>
                                    <td>
                                        ${item.name}
                                    </td>
                                    <td class="text-center">
                                        ${item.presences}
                                    </td>
                                    <td class="text-center">
                                        ${item.permissions}
                                    </td>
                                    <td class="text-center">
                                        ${item.sicks}
                                    </td>
                                    <td class="text-center">
                                        ${item.withoutExplanations}
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
