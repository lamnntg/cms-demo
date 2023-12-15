<?php

namespace App\Http\Controllers\Api;

use App\Services\ArticleServiceInterface;
use App\Http\Requests\CreateHouseArticleRequest;
use App\Http\Requests\CreateServiceArticleRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleController extends ApiController
{
    protected $articleService;

    /**
     * create a new instance
     *
     * @param ArticleServiceInterface $articleService
     */
    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * store house article service
     * @param CreateHouseArticleRequest $request
     *
     * @return JsonResponse
     */
    public function storeHouseArtical(CreateHouseArticleRequest $request)
    {
        list($statusCode, $data) = $this->articleService->storeHouseArticale($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * store house article service
     * @param CreateServiceArticleRequest $request
     *
     * @return JsonResponse
     */
    public function storeServiceArtical(CreateServiceArticleRequest $request)
    {
        list($statusCode, $data) = $this->articleService->storeServiceArticale($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * force delete house article service
     * @param int $id
     *
     * @return JsonResponse
     */
    public function hardDeleteHA(int $id)
    {
        list($statusCode, $data) = $this->articleService->hardDeleteHA($id);

        return $this->response($data, $statusCode);
    }

    /**
     * soft delete house article service
     * @param int $id
     *
     * @return JsonResponse
     */
    public function softDeleteHA(int $id)
    {
        list($statusCode, $data) = $this->articleService->softDeleteHA($id);

        return $this->response($data, $statusCode);
    }

    /**
     * force delete service article service
     * @param int $id
     *
     * @return JsonResponse
     */
    public function hardDeleteSA(int $id)
    {
        list($statusCode, $data) = $this->articleService->hardDeleteSA($id);

        return $this->response($data, $statusCode);
    }

    /**
     * soft delete service article service
     * @param int $id
     *
     * @return JsonResponse
     */
    public function softDeleteSA(int $id)
    {
        list($statusCode, $data) = $this->articleService->softDeleteSA($id);

        return $this->response($data, $statusCode);
    }
}
