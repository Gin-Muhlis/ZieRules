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
                                    <option value="{{ $value }}" {{ $value === 1 ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-success btn-export">
                        <i class="fas fa-download d-inline-block mr-1"></i>Download Excel</button>
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
                                <th class="text-center">
                                   Jumlah pelanggaran
                                </th>
                                <th class="text-center">
                                    Total Poin Pelanggaran
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="body-table">
                            @forelse($reports as $data)
                                <tr>
                                    <td class="text-center">
                                        {{$loop->index + 1 }}
                                    </td>
                                    <td>
                                        {{ $data['name'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data['violationsCount'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
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
     <form action="{{ route('data.violation.export') }}" method="get" class="form-export">
        <input type="hidden" name="class_student" id="input_class_student" value="1">
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

                let students =  dataReport.filter(item => item.class == value)
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
                                       ${item.violationsCount}
                                    </td>
                                    <td class="text-center">
                                        ${item.totalPoint}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('show/data-violations-report') }}/${item.student_id}">
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