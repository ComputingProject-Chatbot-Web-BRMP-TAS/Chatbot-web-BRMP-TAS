<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        return view('customer.article');
    }
} 