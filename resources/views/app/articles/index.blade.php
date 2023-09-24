@php
    require_once app_path() . "/Helpers/helpers.php"
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <h3>
                   Data Artikel
               </h3>
           </div>
            <div class="col-md-12 text-right">
                @can('create', App\Models\Article::class)
                <a
                    href="{{ route('articles.create') }}"
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
                                @lang('crud.artikel.inputs.title')
                            </th>
                            <th class="text-left">
                                @lang('crud.artikel.inputs.user_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.artikel.inputs.date')
                            </th>
                            <th class="text-left">
                                @lang('crud.artikel.inputs.banner')
                            </th>
                            <th class="text-left">
                                @lang('crud.artikel.inputs.content')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $article->title ?? '-' }}</td>
                            <td>{{ optional($article->user)->name ?? '-' }}</td>
                            <td>{{ $article->date ? generateDate($article->date->toDateString()) : '-' }}</td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $article->banner ? \Storage::url($article->banner) : '' }}"
                                />
                            </td>
                            <td>{!! $article->content ?? '-' !!}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $article)
                                    <a
                                        href="{{ route('articles.edit', $article) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $article)
                                    <a
                                        href="{{ route('articles.show', $article) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $article)
                                    <form
                                        action="{{ route('articles.destroy', $article) }}"
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
