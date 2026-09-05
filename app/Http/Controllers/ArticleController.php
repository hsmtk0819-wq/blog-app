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
            'image' => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image_path'] = str_replace('public/', 'storage/', $imagePath);
        }

        unset ($validated['image']); // 画像パスを除外して保存

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
            'image' => 'nullable|file|max:2048',
            'body' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            if ($article->image_path) {
                // 既存の画像を削除
                $existingImagePath = str_replace('storage/', 'public/', $article->image_path);
                \Storage::disk('public')->delete($existingImagePath);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image_path'] = str_replace('public/', 'storage/', $imagePath);
        }

        unset($validated['image']); // 画像パスを除外して保存

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