<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function index() {
        return $this->response(Product::with(['productSkus'])->get());
    }
}
