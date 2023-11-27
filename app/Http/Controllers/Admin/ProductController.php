<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Services\ProductServiceInterface;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {

        $request->validate([
            'product_id' => 'required|integer',
            'product_sku_id' => 'required|integer',
            'quantity' => 'required|integer',
            'size' => 'required|string'
        ]);

        $data = $request->all();

        $result = $this->productService->store($data);

        return $this->response($result);
    }
}
