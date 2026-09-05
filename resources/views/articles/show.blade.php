@extends('layouts.app')

@section('title', $article->title . ' - わたしのブログ')

@section('content')
    <article class="rounded-lg border border-blue-100 bg-white p-6 shadow-sm">
        <time class="text-sm text-blue-600">
            {{ $article->published_on->format('Y年n月j日') }}
        </time>
        <h1 class="mt-1 text-2xl font-bold text-blue-950">
            {{ $article->title }}
        </h1>

        <div class="mt-6 leading-relaxed text-slate-700">
            {!! nl2br(e($article->body)) !!}
        </div>
    </article>

    <div class="mt-6 flex items-center justify-between">
        <a href="{{ route('articles.index') }}" class="text-blue-700 hover:text-blue-950">
            ← 記事一覧にもどる
        </a>
        <a href="{{ route('articles.edit', $article) }}"
           class="rounded-lg border border-blue-200 bg-white px-4 py-2 text-blue-700 shadow-sm hover:border-blue-400 hover:bg-blue-50">
            編集する
        </a>
    </div>
@endsection