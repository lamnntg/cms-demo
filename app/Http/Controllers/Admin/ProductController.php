<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Services\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends ApiController
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index() {
        return view('product');
    }

    public function create() {
        return view('create-product');
    }

    public function edit() {
        return view('edit-product');
    }

    /**
     * store function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'images' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required',
            'material' => 'required|string',
            'description' => 'required|string',
            'product_skus' => 'required|array',
            'product_skus.*.sku_code' => 'required|string',
            'product_skus.*.color' => 'required|string',
            'product_skus.*.price' => 'required|integer',
            'product_skus.*.quantity_size_s' => 'required|integer',
            'product_skus.*.quantity_size_m' => 'required|integer',
            'product_skus.*.quantity_size_l' => 'required|integer',
            'product_skus.*.quantity_size_xl' => 'required|integer',
            'product_skus.*.quantity_size_2xl' => 'required|integer',
            'product_skus.*.image_sku' => 'required|array',
        ]);

        if ($validator->fails()) {
            return $this->response($validator->errors());
        }
        list($result, $product) = $this->productService->store($data);

        $httpResponse = Response::HTTP_OK;
        if ($result === false) {
            $httpResponse = Response::HTTP_BAD_REQUEST;
        }

        return $this->response($product, $httpResponse);
    }
}
