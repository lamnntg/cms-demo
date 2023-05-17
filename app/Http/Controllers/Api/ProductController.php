<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFavorite;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends ApiController
{
    public function index(Request $request) {
        $page = $request->get('page') ?? null;

        return $this->response(Product::with(['productSkus'])->paginate(
            4, ['*'], 'products', $page
        ));
    }

    public function show(int $id) {
        try {
            $product = Product::with(['productSkus'])->find($id);
            $productFavoriteFlag = false;

            if (request()->has('user_id')) {
                $productFavoriteFlag = ProductFavorite::where('product_id', $id)
                    ->where('firebase_user_id', request()->get('user_id'))
                    ->exist();
            }
            $product->setAttribute('is_product_facvorite', $productFavoriteFlag);

        } catch (\Throwable $th) {
            return $this->response([], Response::HTTP_NOT_FOUND);
        }

        return $this->response($product);
    }
}
