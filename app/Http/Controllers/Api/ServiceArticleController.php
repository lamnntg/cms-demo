<?php

namespace App\Http\Controllers\Api;

use App\Services\ServiceArticleServiceInterface;
use App\Http\Requests\CreateServiceArticleRequest;

class ServiceArticleController extends ApiController
{
    protected $serviceArticleService;

    /**
     * create a new instance
     *
     * @param ServiceArticleServiceInterface $serviceArticleService
     */
    public function __construct(ServiceArticleServiceInterface $serviceArticleService)
    {
        $this->serviceArticleService = $serviceArticleService;
    }

    /**
     * store service article service
     * @param CreateServiceArticleRequest $request
     *
     * @return json
     */
    public function store(CreateServiceArticleRequest $request)
    {
        list($statusCode, $data) = $this->serviceArticleService->store($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * force delete service article service
     * @param int $saId
     *
     * @return json
     */
    public function hardDelete(int $saId)
    {
        list($statusCode, $data) = $this->serviceArticleService->hardDelete($saId);

        return $this->response($data, $statusCode);
    }

    /**
     * soft delete service article service
     * @param int $saId
     *
     * @return json
     */
    public function softDelete(int $saId)
    {
        list($statusCode, $data) = $this->serviceArticleService->softDelete($saId);

        return $this->response($data, $statusCode);
    }
}
