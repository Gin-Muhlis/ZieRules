@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('history-achievments.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.catatan_scan_prestasi.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>
                        @lang('crud.catatan_scan_prestasi.inputs.student_id')
                    </h5>
                    <span
                        >{{ optional($historyAchievment->student)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.catatan_scan_prestasi.inputs.teacher_id')
                    </h5>
                    <span
                        >{{ optional($historyAchievment->teacher)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>
                        @lang('crud.catatan_scan_prestasi.inputs.achievment_id')
                    </h5>
                    <span
                        >{{ optional($historyAchievment->achievment)->name ??
                        '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.catatan_scan_prestasi.inputs.date')</h5>
                    <span>{{ $historyAchievment->date ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('history-achievments.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\HistoryAchievment::class)
                <a
                    href="{{ route('history-achievments.create') }}"
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
