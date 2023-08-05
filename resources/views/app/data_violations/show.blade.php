@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('data-violations.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.data_pelanggaran.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.data_pelanggaran.inputs.violation_id')</h5>
                    <span
                        >{{ optional($dataViolation->violation)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.data_pelanggaran.inputs.student_id')</h5>
                    <span
                        >{{ optional($dataViolation->student)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.data_pelanggaran.inputs.teacher_id')</h5>
                    <span
                        >{{ optional($dataViolation->teacher)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.data_pelanggaran.inputs.date')</h5>
                    <span>{{ $dataViolation->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.data_pelanggaran.inputs.description')</h5>
                    <span>{{ $dataViolation->description ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('data-violations.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\DataViolation::class)
                <a
                    href="{{ route('data-violations.create') }}"
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
