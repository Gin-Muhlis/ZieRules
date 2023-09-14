@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('articles.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.artikel.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.artikel.inputs.title')</h5>
                    <span>{{ $article->title ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.artikel.inputs.user_id')</h5>
                    <span>{{ optional($article->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.artikel.inputs.date')</h5>
                    <span>{{ $article->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.artikel.inputs.banner')</h5>
                    <x-partials.thumbnail
                        src="{{ $article->banner ? \Storage::url($article->banner) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.artikel.inputs.content')</h5>
                    <span>{{ $article->content ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('articles.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Article::class)
                <a href="{{ route('articles.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
