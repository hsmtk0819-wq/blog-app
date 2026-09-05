
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '備忘録')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-blue-50 text-slate-800">
    <div class="mx-auto max-w-3xl px-4 py-8">

        <header class="mb-8 flex items-center justify-between border-b border-blue-100 pb-6">
            <a href="{{ route('articles.index') }}" class="text-2xl font-bold text-blue-950">
                👦 備忘録
            </a>
            <a href="{{ route('articles.create') }}"
               class="rounded-lg bg-blue-700 px-4 py-2 font-medium text-white shadow-sm transition hover:bg-blue-800">
                + 新しい記事
            </a>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-blue-200 bg-blue-100 px-4 py-3 text-blue-900">
                {{ session('success') }}
            </div>
        @endif

        <main>
            @yield('content')
        </main>

        <footer class="mt-12 border-t border-blue-100 pt-6 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} 備忘録
        </footer>

    </div>
</body>
</html>