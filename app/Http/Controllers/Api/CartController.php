<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CartController extends ApiController
{
    public function index(Request $request)
    {
        $user = request()->user();
        $cart = Cart::with(['cartItems', 'cartItems.product', 'cartItems.productSku'])->where('firebase_user_id', $user->id)->first();
        if (!$cart) {
            return $this->response([]);
        }

        return $this->response($cart);
    }


    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_sku_id' => 'required|integer',
            'quantity' => 'required|integer',
            'size' => 'required|string'
        ]);

        $params = $request->all();
        $user = request()->user();

        DB::beginTransaction();

        try {
            $cart = Cart::updateOrCreate(
                [
                    'firebase_user_id' => $user->id,
                ],
                [
                    'status' => Cart::STATUS_PROCESSING
                ]
            );

            $cartItem = CartItem::where([
                ['cart_id', '=', $cart->id],
                ['product_id', '=', $params['product_id']],
                ['product_sku_id', '=', $params['product_sku_id']],
            ])->first();

            $product = Product::findOrFail($params['product_id']);

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $cartItem->quantity + $params['quantity'],
                ]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $params['product_id'],
                    'product_sku_id' => $params['product_sku_id'],
                    'quantity' => $params['quantity'],
                    'price' => $product->price,
                    'size' => $params['size']
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->response(['errors' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->response(['message' => 'Add to cart successfully']);
    }
}
