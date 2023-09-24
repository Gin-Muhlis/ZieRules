@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">
                     <h3>
                        Jenis Prestasi
                    </h3>
                </div>
                <div class="col-md-6 text-right">
                    @can('create', App\Models\Achievment::class)
                        <button class="btn btn-primary btn-import">Import</button>
                        <a href="{{ route('achievments.create') }}" class="btn btn-primary">
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
                                    @lang('crud.prestasi.inputs.name')
                                </th>
                                <th class="text-left">
                                    @lang('crud.prestasi.inputs.point')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($achievments as $achievment)
                                <tr>
                                    <td>{{ $achievment->name ?? '-' }}</td>
                                    <td>{{ $achievment->point ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $achievment)
                                                <a href="{{ route('achievments.edit', $achievment) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('view', $achievment)
                                                <a href="{{ route('achievments.show', $achievment) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $achievment)
                                                <form action="{{ route('achievments.destroy', $achievment) }}" method="POST"
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
                                    <td colspan="3">
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
    <form action="{{ route('achievment.import') }}" method="post" class="d-none form-import"
        enctype="multipart/form-data">
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
