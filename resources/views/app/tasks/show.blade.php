@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('tasks.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.tugas.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.tugas.inputs.name')</h5>
                    <span>{{ $task->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tugas.inputs.class')</h5>
                    <span>{{ $task->class ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.tugas.inputs.description')</h5>
                    <span>{{ $task->description ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('tasks.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Task::class)
                <a href="{{ route('tasks.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
