@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <h3>
                       Jenis Tugas
                   </h3>
               </div>
                <div class="col-md-6 text-right">
                    @can('create', App\Models\Task::class)
                        <button class="btn btn-primary btn-import">Import</button>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
            <div class="row mt-3">
                @if ($errors->any())
                    <p class="text-danger">{{ $errors->first() }}</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-borderless table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    @lang('crud.tugas.inputs.name')
                                </th>
                                <th class="text-left">
                                    @lang('crud.tugas.inputs.class')
                                </th>
                                <th class="text-left">
                                    @lang('crud.tugas.inputs.description')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr>
                                    <td>{{ $task->name ?? '-' }}</td>
                                    <td>{{ $task->class ?? '-' }}</td>
                                    <td>{{ $task->description ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $task)
                                                <a href="{{ route('tasks.edit', $task) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $task)
                                                <a href="{{ route('tasks.show', $task) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $task)
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
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
                                    <td colspan="4">
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
    <form action="{{ route('task.import') }}" method="post" class="d-none form-import" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" id="file">
    </form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(".btn-import").on("click", function() {
                $("#file").click()
            })
            $("#file").on("change", function() {
                $(".form-import").submit()
            })
        })
    </script>
@endpush
