@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('students.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.siswa.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.siswa.inputs.name')</h5>
                    <span>{{ $student->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.siswa.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $student->image ? \Storage::url($student->image) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.siswa.inputs.gender')</h5>
                    <span>{{ $student->gender ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.siswa.inputs.class_id')</h5>
                    <span>{{ optional($student->class)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.siswa.inputs.user_id')</h5>
                    <span>{{ optional($student->user)->email ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('students.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Student::class)
                <a href="{{ route('students.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
