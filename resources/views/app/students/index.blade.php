@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                    <h3>
                       Data Siswa
                   </h3>
               </div>
                <div class="col-md-6 text-right">
                    @can('create', App\Models\Student::class)
                        <a href="{{ route('students.create') }}" class="btn btn-primary">
                            <i class="icon ion-md-add"></i> @lang('crud.common.create')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-borderless table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    @lang('crud.siswa.inputs.name')
                                </th>
                                <th class="text-left">
                                    @lang('crud.siswa.inputs.nis')
                                </th>
                                <th class="text-left">
                                    @lang('crud.siswa.inputs.password_show')
                                </th>
                                <th class="text-left">
                                    @lang('crud.siswa.inputs.image')
                                </th>
                                <th class="text-left">
                                    @lang('crud.siswa.inputs.gender')
                                </th>
                                <th class="text-left">
                                    @lang('crud.siswa.inputs.class_id')
                                </th>
                                <th class="text-left">
                                    @lang('crud.siswa.inputs.code')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>{{ $student->name ?? '-' }}</td>
                                    <td>{{ $student->nis ?? '-' }}</td>
                                    <td>{{ $student->password_show ?? '-' }}</td>
                                    <td>
                                        <x-partials.thumbnail
                                            src="{{ $student->image ? \Storage::url($student->image) : '' }}" />
                                    </td>
                                    <td>{{ $student->gender ?? '-' }}</td>
                                    <td>
                                        {{ optional($student->class)->name ?? '-' }}
                                    </td>
                                    <td>{{ $student->code ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $student)
                                                <a href="{{ route('students.edit', $student) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $student)
                                                <a href="{{ route('students.show', $student) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $student)
                                                <form action="{{ route('students.destroy', $student) }}" method="POST"
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
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
