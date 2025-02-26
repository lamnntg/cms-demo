<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
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
        $productsData = Product::with('productSkus')->get();
        $categories = Category::all()->toArray();

        $products = [];
        foreach ($productsData as $key => $product) {
            $product = new ProductResource($product);
            $products[] = $product->toArray([]);
        }

        return view('product', compact('products', 'categories'));
    }

    public function create() {
        $categories = Category::all()->toArray();

        return view('create-product', compact('categories'));
    }

    public function edit(Request $request, int $id) {
        $product = $this->productService->find($id);
        $categories = Category::all()->toArray();

        return view('edit-product', compact('product', 'categories'));
    }

    public function delete(Request $request, int $id) {
        list($result, $message) = $this->productService->destroy($id);

        if ($result) {
            return $this->response($message);
        }

        return $this->response($message, Response::HTTP_BAD_REQUEST);
    }

    public function update(Request $request, int $id) {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'images' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'is_new' => 'required|numeric',
            'material' => 'required|string',
            'description' => 'nullable|string',
            'product_skus' => 'required|array',
            'product_skus.*.sku_code' => 'required|string',
            'product_skus.*.color' => 'required|string',
            'product_skus.*.price' => 'required|integer',
            'product_skus.*.quantity' => 'required|integer',
            'product_skus.*.image_sku' => 'required|array',
            'product_skus.*.description' => 'nullable|string',
            'product_skus.*.material' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        list($result, $product) = $this->productService->update($id, $data);

        $httpResponse = Response::HTTP_OK;
        if ($result === false) {
            $httpResponse = Response::HTTP_BAD_REQUEST;
        }

        return $this->response($product, $httpResponse);
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
            'category_id' => 'required|numeric',
            'is_new' => 'required|numeric',
            'material' => 'nullable|string',
            'description' => 'required|string',
            'product_skus' => 'required|array',
            'product_skus.*.sku_code' => 'required|string',
            'product_skus.*.color' => 'required|string',
            'product_skus.*.price' => 'required|integer',
            'product_skus.*.quantity' => 'required|integer',
            'product_skus.*.image_sku' => 'required|array',
            'product_skus.*.description' => 'nullable|string',
            'product_skus.*.material' => 'nullable|string',
            'product_skus.*.size' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        list($result, $product) = $this->productService->store($data);

        $httpResponse = Response::HTTP_OK;
        if ($result === false) {
            $httpResponse = Response::HTTP_BAD_REQUEST;
        }

        return $this->response($product, $httpResponse);
    }
}
