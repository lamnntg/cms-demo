<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Club;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index() {
        $articles = Article::all();
        $clubs = Club::all();

        return view('article', compact('articles', 'clubs'));
    }
}
