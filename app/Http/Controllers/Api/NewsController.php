<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\NewsServiceInterface;
use App\Http\Requests\CreateNewsRequest;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends ApiController
{
    protected $newsService;

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

    /**
     * create a new instance
     *
     * @param NewsServiceInterface $newsService
     */
    public function __construct(NewsServiceInterface $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * store news service
     * @param CreateNewsRequest $request
     *
     * @return json
     */
    public function store(CreateNewsRequest $request)
    {
        list($statusCode, $data) = $this->newsService->store($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * force delete news service
     * @param int $id
     *
     * @return json
     */
    public function hardDelete(int $id)
    {
        list($statusCode, $data) = $this->newsService->hardDelete($id);

        return $this->response($data, $statusCode);
    }

    /**
     * soft delete news service
     * @param int $id
     *
     * @return json
     */
    public function softDelete(int $id)
    {
        list($statusCode, $data) = $this->newsService->softDelete($id);

        return $this->response($data, $statusCode);
    }
}
