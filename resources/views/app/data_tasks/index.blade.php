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
                            <input id="indexSearch" type="text" name="search" placeholder="{{ __('crud.common.search') }}"
                                value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon ion-md-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    @can('create', App\Models\DataTask::class)
                        <a href="{{ route('data-tasks.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
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
                                    <td>{{ $dataTask->date ? generateDate($dataTask->date->toDateString()) : '-' }}</td>
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
                        <tfoot>
                            <tr>
                                <td colspan="6">{!! $dataTasks->render() !!}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
