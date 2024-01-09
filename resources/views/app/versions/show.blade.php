@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('versions.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.version.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.version.inputs.version')</h5>
                    <span>{{ $version->version ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.version.inputs.release_time')</h5>
                    <span>{{ $version->release_time ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('versions.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Presence::class)
                <a href="{{ route('versions.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
