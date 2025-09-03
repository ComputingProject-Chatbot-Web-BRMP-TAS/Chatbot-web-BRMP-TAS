<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('customer.article', compact('articles'));
    }
    
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $randomProducts = Product::inRandomOrder()->take(3)->get();
        return view('customer.article_detail', compact('article', 'randomProducts'));
    }
}