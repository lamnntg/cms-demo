<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\NewsServiceInterface;
use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewsController extends ApiController
{
    protected $newsService;

    /**
     * index function
     *
     * @return JsonResponse
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
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        list($statusCode, $data) = $this->newsService->hardDelete($id);

        return $this->response($data, $statusCode);
    }

    /**
     * soft delete news service
     * @param int $id
     *
     * @return JsonResponse
     */
    public function softDelete(int $id)
    {
        list($statusCode, $data) = $this->newsService->softDelete($id);

        return $this->response($data, $statusCode);
    }

    /**
     * get News function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getNews(Request $request) {
        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
        ]);

        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        list($statusCode, $data) = $this->newsService->getNews($paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * update news service
     * @param UpdateNewsRequest $request
     *
     * @return JsonResponse
     */
    public function updateNews(UpdateNewsRequest $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;

        list($statusCode, $data) = $this->newsService->updateNews($data);

        return $this->response($data, $statusCode);
    }
}
