<?php

namespace App\Http\Controllers\Api;

use App\Models\HouseArticle;
use App\Models\MarketArticle;
use App\Models\ServiceArticle;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ManageController extends ApiController
{
    const POST_MODELS = [
        'market' => MarketArticle::class,
        'house' => HouseArticle::class,
        'service' => ServiceArticle::class,
    ];

    public function approve(Request $request)
    {
        if (!is_role_admin()) {
            return $this->response(Response::$statusTexts[Response::HTTP_FORBIDDEN], Response::HTTP_FORBIDDEN);
        }

        try {
            $request->validate([
                'status' => 'required|in:0,1,2',
                'id' => 'required|integer',
                'object_type' => 'required|string|in:market,house,service',
            ]);

            $params = $request->all();
            $model = self::POST_MODELS[$params['object_type']];
            $object = $model::findOrFail($params['id']);
            $object->update([
                'status' => $params['status']
            ]);

            return $this->response("Update successfully", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->response($th, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * get House Article
     * @param $request
     *
     * @return JsonResponse
     */
    public function getHouseArticles(Request $request)
    {
        $user = request()->user();

        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'type' => 'required|in:1,2',
            'sort_fields' => 'nullable|string|in:bedrooms,wcs,price',
            'sort_order' => 'nullable|string|in:desc,asc',
            'from' => 'nullable|string'
        ]);
        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        $filter = [
            'from' => $params['from'] ?? null,
            'type' => $params['type'],
            'sort_fields' => $params['sort_fields'] ?? null,
            'sort_order' => $params['sort_order'] ?? 'ASC',
        ];

        list($statusCode, $data) = $this->articleService->getHouseArticles($filter, $paginate, $user->id);

        return $this->response($data, $statusCode);
    }

    /**
     * getServiceArticles function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getServiceArticles(Request $request) {
        $user = request()->user();

        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'sort_fields' => 'nullable|string|in:bedrooms,wcs,price',
            'sort_order' => 'nullable|string|in:desc,asc',
            'from' => 'nullable|string'
        ]);

        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        $filter = [
            'from' => $params['from'] ?? null,
            'sort_fields' => $params['sort_fields'] ?? null,
            'sort_order' => $params['sort_order'] ?? 'ASC',
        ];

        list($statusCode, $data) = $this->articleService->getServiceArticles($filter, $paginate, $user->id);

        return $this->response($data, $statusCode);
    }


     /**
     * getMarketArticles function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMarketArticles(Request $request) {
        $user = request()->user();

        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'sort_fields' => 'nullable|string|in:bedrooms,wcs,price',
            'sort_order' => 'nullable|string|in:desc,asc',
            'from' => 'nullable|string'
        ]);

        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        $filter = [
            'from' => $params['from'] ?? null,
            'sort_fields' => $params['sort_fields'] ?? null,
            'sort_order' => $params['sort_order'] ?? 'ASC',
        ];

        list($statusCode, $data) = $this->articleService->getMarketArticles($filter, $paginate, $user->id);

        return $this->response($data, $statusCode);
    }
}
