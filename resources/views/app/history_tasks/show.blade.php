@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('history-tasks.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.catatan_scan_tugas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.catatan_scan_tugas.inputs.student_id')</h5>
                    <span
                        >{{ optional($historyTask->student)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.catatan_scan_tugas.inputs.teacher_id')</h5>
                    <span
                        >{{ optional($historyTask->teacher)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.catatan_scan_tugas.inputs.task_id')</h5>
                    <span>{{ optional($historyTask->task)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.catatan_scan_tugas.inputs.date')</h5>
                    <span>{{ $historyTask->date ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('history-tasks.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\HistoryTask::class)
                <a
                    href="{{ route('history-tasks.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
