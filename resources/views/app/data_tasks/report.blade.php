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
                    <h4 class="card-title">@lang('crud.data_tugas.index_title')</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    @lang('crud.data_tugas.inputs.task_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_tugas.inputs.student_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_tugas.inputs.teacher_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_tugas.inputs.date')
                                </th>
                                <th class="text-left">
                                    @lang('crud.data_tugas.inputs.description')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataTasks as $dataTask)
                                <tr>
                                    <td>
                                        {{ optional($dataTask->task)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($dataTask->student)->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($dataTask->teacher)->name ?? '-' }}
                                    </td>
                                    <td>{{ $dataTask->date ?? '-' }}</td>
                                    <td>{{ $dataTask->description ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $dataTask)
                                                <a href="{{ route('data-tasks.edit', $dataTask) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $dataTask)
                                                <a href="{{ route('data-tasks.show', $dataTask) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $dataTask)
                                                <form action="{{ route('data-tasks.destroy', $dataTask) }}" method="POST"
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
