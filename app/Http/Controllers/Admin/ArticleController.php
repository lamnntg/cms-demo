<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ArticleController extends Controller
{
    public function index() {
        $articles = Article::all();

        return view('article', compact('articles'));
    }

    /**
     * store function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request) {
        $params = $request->all();

        if (isset($params['thumnail'])) {
            $url = Cloudinary::upload($request->file('thumnail')->getRealPath())->getSecurePath();
        }

        try {
            Article::create([
                'title' => $params['title'],
                'html' => $params['html'],
                'thumnail' => $url ?? null,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('article')->with('');
    }
}
