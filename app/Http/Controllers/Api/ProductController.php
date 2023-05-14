<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends ApiController
{
    public function index() {
        return $this->response(Product::with(['productSkus'])->get());
    }

    public function show(int $id) {
        try {
            $product = Product::with(['productSkus'])->find($id);
        } catch (\Throwable $th) {
            return $this->response([], Response::HTTP_NOT_FOUND);
        }

        return $this->response($product);
    }
}
