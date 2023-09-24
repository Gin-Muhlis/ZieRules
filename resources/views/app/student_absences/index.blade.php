@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <h3>
                   Kehadiran Siswa
               </h3>
           </div>
            <div class="col-md-6 text-right">
                @can('create', App\Models\StudentAbsence::class)
                <a
                    href="{{ route('student-absences.create') }}"
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
                <table class="table table-borderless table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.absensi_siswa.inputs.date')
                            </th>
                            <th class="text-left">
                                @lang('crud.absensi_siswa.inputs.student_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.absensi_siswa.inputs.presence_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.absensi_siswa.inputs.time')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($studentAbsences as $studentAbsence)
                        <tr>
                            <td>{{ $studentAbsence->date ?? '-' }}</td>
                            <td>
                                {{ optional($studentAbsence->student)->name ??
                                '-' }}
                            </td>
                            <td>
                                {{ optional($studentAbsence->presence)->name ??
                                '-' }}
                            </td>
                            <td>{{ $studentAbsence->time ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $studentAbsence)
                                    <a
                                        href="{{ route('student-absences.edit', $studentAbsence) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $studentAbsence)
                                    <a
                                        href="{{ route('student-absences.show', $studentAbsence) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $studentAbsence)
                                    <form
                                        action="{{ route('student-absences.destroy', $studentAbsence) }}"
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
