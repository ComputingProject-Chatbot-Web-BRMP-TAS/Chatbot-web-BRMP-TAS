<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $articles = $this->articleService->getAllArticles(10);
            return view('admin.articles.index', compact('articles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat artikel: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'headline' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'body' => 'required',
        ]);

        try {
            $this->articleService->createArticle($validated, $request->file('image'));
            return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan artikel: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = \App\Models\Article::findOrFail($id);
        return view('admin.articles.index', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'headline' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'body' => 'required',
        ]);

        try {
            $this->articleService->updateArticle($article, $validated, $request->file('image'));
            return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate artikel: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            $this->articleService->deleteArticle($article);
            return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus artikel: ' . $e->getMessage());
        }
    }
}
