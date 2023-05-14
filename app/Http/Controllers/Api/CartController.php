<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends ApiController
{
    public function index(Request $request) {
        $user = request()->user();
        $cart = Cart::with(['cartItems'])->where('firebase_user_id', $user->id)->first();

        return $this->response($cart);
    }


    public function store(Request $request) {
        $user = request()->user();

        $cart = Cart::updateOrCreate(
            [
                'firebase_user_id' => $user->id,
            ],
            [
                'status' => Cart::STATUS_PROCESSING
            ]
        );

        CartItem::create($request->all());
    }
}
