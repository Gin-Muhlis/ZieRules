@php
    require_once app_path() . '/helpers/helpers.php';
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <h3>
                   Catatan Scan Tugas
               </h3>
           </div>
            <div class="col-md-6 text-right">
                @can('create', App\Models\HistoryTask::class)
                <a
                    href="{{ route('history-tasks.create') }}"
                    class="btn btn-primary"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-borderless table-hover" id="myTable" >
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.catatan_scan_tugas.inputs.student_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.catatan_scan_tugas.inputs.teacher_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.catatan_scan_tugas.inputs.task_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.catatan_scan_tugas.inputs.date')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historyTasks as $historyTask)
                        <tr>
                            <td>
                                {{ optional($historyTask->student)->name ?? '-'
                                }}
                            </td>
                            <td>
                                {{ optional($historyTask->teacher)->name ?? '-'
                                }}
                            </td>
                            <td>
                                {{ optional($historyTask->task)->name ?? '-' }}
                            </td>
                            <td>{{ $historyTask->date ? generateDate($historyTask->date->toDateString()) : '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $historyTask)
                                    <a
                                        href="{{ route('history-tasks.edit', $historyTask) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $historyTask)
                                    <a
                                        href="{{ route('history-tasks.show', $historyTask) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $historyTask)
                                    <form
                                        action="{{ route('history-tasks.destroy', $historyTask) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
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
@endsection
