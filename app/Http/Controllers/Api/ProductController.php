<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFavorite;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends ApiController
{
    public function index(Request $request)
    {
        $page = $request->get('page') ?? null;
        $query = $request->get('query') ?? null;
        $productName = $request->get('product_name') ?? null;
        $category = $request->get('category') ?? null;
        $isNew = $request->get('is_new') ?? null;

        $productQuery = Product::with(['productSkus', 'category']);

        if ($productName) {
            $productQuery = $productQuery->where('name', 'like', "%{$productName}%");
        }

        if ($isNew) {
            $productQuery = $productQuery->where('is_new', $isNew);
        }

        if ($category) {
            $productQuery = $productQuery->whereHas("category", function ($query) use ($category) {
                $query->where('slug', $category);
            });
        }

        if ($query) {
            $productQuery = $productQuery->whereRaw($query);
        }

        return $this->response($productQuery->paginate(
            $perPage,
            ['*'],
            'page',
            $page
        ));
    }

    public function show(int $id)
    {
        try {
            $product = Product::with(['productSkus'])->find($id);
            $productFavoriteFlag = false;

            if (request()->has('user_id')) {
                $productFavoriteFlag = ProductFavorite::where('product_id', $id)
                    ->where('firebase_user_id', request()->get('user_id'))
                    ->exist();
            }
            $product->setAttribute('is_product_favorite', $productFavoriteFlag);
        } catch (\Throwable $th) {
            return $this->response([], Response::HTTP_NOT_FOUND);
        }
        $product = new ProductResource($product);

        return $this->response($product->toArray([]));
    }

    public function getCategories(Request $request)
    {
        $categories = Category::all();

        return $this->response($categories, Response::HTTP_OK);
    }
}
