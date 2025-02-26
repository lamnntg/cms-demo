<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends ApiController
{
    /**
     * index function
     *
     * @return void
     */
    public function index() {
        $data = Article::all();

        return $this->response($data, 200);
    }

    /**
     * articleDetail function
     *
     * @param Request $request
     * @param integer $articleId
     * @return JsonResponse
     */
    public function articleDetail(Request $request, int $articleId) {
        try {
            $data = Article::find($articleId);
        } catch (\Throwable $th) {
            //throw $th;
            $this->response([], Response::HTTP_BAD_REQUEST);
        }

        return $this->response($data, 200);
    }
}
