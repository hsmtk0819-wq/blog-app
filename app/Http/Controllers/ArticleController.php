<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // 記事一覧（月別アーカイブつき）
    public function index(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));

        $articles = Article::whereYear('published_on', substr($month, 0, 4))
            ->whereMonth('published_on', substr($month, 5, 2))
            ->orderBy('published_on', 'desc')
            ->get();

        // 月別アーカイブの選択肢（直近12ヶ月）
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $months[$date->format('Y-m')] = $date->format('Y年n月');
        }

        return view('articles.index', compact('articles', 'months', 'month'));
    }

    // 記事ページ（1件を読む）
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    // 新規作成画面
    public function create()
    {
        return view('articles.create');
    }

    // 保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'published_on' => 'required|date',
            'body' => 'required|string',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', '記事を公開しました');
    }

    // 編集画面
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    // 更新
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'published_on' => 'required|date',
            'body' => 'required|string',
        ]);

        $article->update($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', '記事を更新しました');
    }

    // 削除
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', '記事を削除しました');
    }
}