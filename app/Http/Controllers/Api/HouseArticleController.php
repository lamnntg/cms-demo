<?php

namespace App\Http\Controllers\Api;

use App\Services\HouseArticleServiceInterface;
use App\Http\Requests\CreateHouseArticleRequest;

class HouseArticleController extends ApiController
{
    protected $houseArticleService;

    /**
     * create a new instance
     *
     * @param HouseArticleServiceInterface $houseArticleService
     */
    public function __construct(HouseArticleServiceInterface $houseArticleService)
    {
        $this->houseArticleService = $houseArticleService;
    }

    /**
     * store house article service
     * @param CreateHouseArticleRequest $request
     *
     * @return json
     */
    public function store(CreateHouseArticleRequest $request)
    {
        list($statusCode, $data) = $this->houseArticleService->store($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * force delete house article service
     * @param int $haId
     *
     * @return json
     */
    public function hardDelete(int $haId)
    {
        list($statusCode, $data) = $this->houseArticleService->hardDelete($haId);

        return $this->response($data, $statusCode);
    }

    /**
     * soft delete house article service
     * @param int $haId
     *
     * @return json
     */
    public function softDelete(int $haId)
    {
        list($statusCode, $data) = $this->houseArticleService->softDelete($haId);

        return $this->response($data, $statusCode);
    }
}
