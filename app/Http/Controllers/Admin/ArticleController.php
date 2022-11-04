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

    /**
     * store function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request) {
        $params = $request->all();

        try {
            Article::create([
                'title' => $params['title'],
                'html' => $params['html'],
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('article')->with('');
    }
}
