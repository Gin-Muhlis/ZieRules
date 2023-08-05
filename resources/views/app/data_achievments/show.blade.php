@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('data-achievments.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.data_prestasi.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.data_prestasi.inputs.achievment_id')</h5>
                    <span
                        >{{ optional($dataAchievment->achievment)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.data_prestasi.inputs.student_id')</h5>
                    <span
                        >{{ optional($dataAchievment->student)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.data_prestasi.inputs.teacher_id')</h5>
                    <span
                        >{{ optional($dataAchievment->teacher)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.data_prestasi.inputs.date')</h5>
                    <span>{{ $dataAchievment->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.data_prestasi.inputs.description')</h5>
                    <span>{{ $dataAchievment->description ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('data-achievments.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DataAchievment::class)
                <a
                    href="{{ route('data-achievments.create') }}"
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
