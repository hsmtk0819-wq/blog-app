@extends('layouts.app')

@section('title', 'わたしのブログ')

@section('content')
    <form method="GET" action="{{ route('articles.index') }}" class="mb-6">
        <label for="month" class="mr-2 text-sm font-medium text-blue-950">月別アーカイブ</label>
        <select name="month" id="month" onchange="this.form.submit()"
            class="rounded-lg border border-blue-200 bg-white px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
            @foreach ($months as $value => $label)
                <option value="{{ $value }}" {{ $month === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </form>

    @if ($articles->isEmpty())
        <div class="rounded-lg border border-blue-100 bg-white p-8 text-center text-slate-500 shadow-sm">
            この月の記事はまだありません。<br>
            右上の「+ 新しい記事」から書いてみましょう！
        </div>
    @else
        <div class="space-y-4">
            @foreach ($articles as $article)
                <a href="{{ route('articles.show', $article) }}"
                   class="block rounded-lg border border-blue-100 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:shadow-md">
                    @if ($article->image_path)
                        <img src="{{ asset('storage/' . $article->image_path) }}" alt="記事の画像" class="mb-4 w-full rounded-lg">
                        
                    @endif

                    <time class="text-sm text-blue-600">
                        {{ $article->published_on->format('Y年n月j日') }}
                    </time>
                    <h2 class="mt-1 text-xl font-bold text-blue-950">
                        {{ $article->title }}
                    </h2>
                    <p class="mt-2 text-slate-600">
                        {{ Str::limit($article->body, 100) }}
                    </p>
                </a>
            @endforeach
        </div>
    @endif
@endsection