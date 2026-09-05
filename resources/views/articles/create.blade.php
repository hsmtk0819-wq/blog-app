@extends('layouts.app')

@section('title', '新しい記事 - わたしのブログ')

@section('content')
    <div class="rounded-lg border border-blue-100 bg-white p-6 shadow-sm">
        <h1 class="mb-6 text-xl font-bold text-blue-950">新しい記事を書く</h1>

        <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="mb-1 block text-sm font-medium text-blue-950">タイトル</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="w-full rounded-lg border border-blue-200 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="published_on" class="mb-1 block text-sm font-medium text-blue-950">公開日</label>
                <input type="date" name="published_on" id="published_on"
                       value="{{ old('published_on', date('Y-m-d')) }}"
                       class="w-full rounded-lg border border-blue-200 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                @error('published_on')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="body" class="mb-1 block text-sm font-medium text-blue-950">本文</label>
                <textarea name="body" id="body" rows="12"
                          class="w-full rounded-lg border border-blue-200 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">{{ old('body') }}</textarea>
                @error('body')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="image" class="mb-1 block text-sm font-medium text-blue-950">画像</label>
                <input type="file" name="image" id="image"
                       class="w-full rounded-lg border border-blue-200 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('articles.index') }}" class="text-blue-700 hover:text-blue-950">
                    ← キャンセル
                </a>
                <button type="submit"
                        class="rounded-lg bg-blue-700 px-6 py-2 font-medium text-white shadow-sm hover:bg-blue-800">
                    公開する
                </button>
            </div>
        </form>
    </div>
@endsection