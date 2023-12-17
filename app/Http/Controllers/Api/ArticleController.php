<?php

namespace App\Http\Controllers\Api;

use App\Services\ArticleServiceInterface;
use App\Http\Requests\CreateHouseArticleRequest;
use App\Http\Requests\CreateMarketArticleRequest;
use App\Http\Requests\CreateServiceArticleRequest;
use Illuminate\Http\Request;
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
     * get House Article
     * @param CreateHouseArticleRequest $request
     *
     * @return JsonResponse
     */
    public function getHouseArticles(Request $request)
    {
        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'type' => 'required|in:1,2',
            'sort_fields' => 'nullable|string|in:bedrooms,wcs,price',
            'sort_order' => 'nullable|string|in:desc,asc',
        ]);

        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        $filter = [
            'type' => $params['type'],
            'sort_fields' => $params['sort_fields'] ?? null,
            'sort_order' => $params['sort_order'] ?? 'ASC',
        ];

        list($statusCode, $data) = $this->articleService->getHouseArticles($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * getHouseArticleDetail function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getHouseArticleDetail(Request $request, int $id) {

        list($statusCode, $data) = $this->articleService->houseArticleDetail($id);

        return $this->response($data, $statusCode);
    }

    /**
     * getServiceArticles function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getServiceArticles(Request $request) {
        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'sort_fields' => 'nullable|string|in:bedrooms,wcs,price',
            'sort_order' => 'nullable|string|in:desc,asc',
        ]);

        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        $filter = [
            'sort_fields' => $params['sort_fields'] ?? null,
            'sort_order' => $params['sort_order'] ?? 'ASC',
        ];

        list($statusCode, $data) = $this->articleService->getServiceArticles($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * getServiceArticleDetail function
     *
     * @return JsonResponse
     */
    public function getServiceArticleDetail(int $id) {

        list($statusCode, $data) = $this->articleService->serviceArticleDetail($id);

        return $this->response($data, $statusCode);
    }

    /**
     * getMarketArticles function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMarketArticles(Request $request) {
        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'sort_fields' => 'nullable|string|in:bedrooms,wcs,price',
            'sort_order' => 'nullable|string|in:desc,asc',
        ]);

        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        $filter = [
            'sort_fields' => $params['sort_fields'] ?? null,
            'sort_order' => $params['sort_order'] ?? 'ASC',
        ];

        list($statusCode, $data) = $this->articleService->getMarketArticles($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * getMarketArticleDetail function
     *
     * @return JsonResponse
     */
    public function getMarketArticleDetail(int $id) {

        list($statusCode, $data) = $this->articleService->marketArticleDetail($id);

        return $this->response($data, $statusCode);
    }

    /**
     * store house article service
     * @param CreateHouseArticleRequest $request
     *
     * @return JsonResponse
     */
    public function storeHouseArticle(CreateHouseArticleRequest $request)
    {
        list($statusCode, $data) = $this->articleService->storeHouseArticle($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * store house article service
     * @param CreateServiceArticleRequest $request
     *
     * @return JsonResponse
     */
    public function storeServiceArticle(CreateServiceArticleRequest $request)
    {
        list($statusCode, $data) = $this->articleService->storeServiceArticle($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * store market article func
     * @param CreateMarketArticleRequest $request
     *
     * @return JsonResponse
     */
    public function storeMarketArticle(CreateMarketArticleRequest $request)
    {
        list($statusCode, $data) = $this->articleService->storeMarketArticle($request->all());

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
    public function deleteHouseArticle(int $id)
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
    public function deleteServiceArticle(int $id)
    {
        list($statusCode, $data) = $this->articleService->softDeleteSA($id);

        return $this->response($data, $statusCode);
    }

    /**
     * soft delete market article service
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteMarketArticle(int $id)
    {
        list($statusCode, $data) = $this->articleService->softDeleteMA($id);

        return $this->response($data, $statusCode);
    }
}
