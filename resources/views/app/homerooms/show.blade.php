@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('homerooms.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.wali_kelas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.wali_kelas.inputs.teacher_id')</h5>
                    <span>{{ optional($homeroom->teacher)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.wali_kelas.inputs.class_id')</h5>
                    <span>{{ optional($homeroom->class)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('homerooms.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Homeroom::class)
                <a href="{{ route('homerooms.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
