@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('violations.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.pelanggaran.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.pelanggaran.inputs.name')</h5>
                    <span>{{ $violation->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.pelanggaran.inputs.point')</h5>
                    <span>{{ $violation->point ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('violations.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Violation::class)
                <a
                    href="{{ route('violations.create') }}"
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
