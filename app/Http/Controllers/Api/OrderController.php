<?php

namespace App\Http\Controllers\Api;

use App\Mail\NotificationOrder;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Club;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends ApiController
{
    public function index()
    {
        $orders = Order::with('orderItems')->get();

        return $this->response($orders);
    }
    /**
     * store function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'time' => 'required',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|string|email',
            'message' => 'nullable|string',
            'address' => 'required|string',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->response($validator->errors(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $firebaseUser = request()->user();
        $cart = Cart::with(['cartItems', 'cartItems.product', 'cartItems.productSku'])->where('firebase_user_id', $firebaseUser->id)->first();

        if (!$cart) {
            return $this->response(['errors' => 'Cart not found'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $order = Order::create([
                'firebase_user_id' => $firebaseUser->id,
                'time' => $params['time'],
                'type' => $params['type'],
                'address' => $params['address'],
                'name' => $params['name'],
                'phone' => $params['phone'],
                'email' => $params['email'] ?? null,
                'message' => $params['message'] ?? null,
            ]);

            $amount = 0;
            foreach ($cart->cartItems as $cartItem) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'size' => $cartItem->size,
                ]);
                $amount = $cartItem->price + $amount;
            }

            $transaction = Transaction::create([
                'firebase_user_id' => $firebaseUser->id,
                'code' => strtoupper(md5(rand())),
                'order_id' => $order->id,
                'mode' => 1,
                'status' => 0,
                'amount' => $amount
            ]);

            $cartItemIds = $cart->cartItems->pluck('id')->toArray();
            Mail::to('prismstudiovietnam@gmail.com')->send(new NotificationOrder([
                'time' => $params['time'],
                'type' => $params['type'],
                'address' => $params['address'],
                'name' => $params['name'],
                'phone' => $params['phone'],
                'email' => $params['email'] ?? null,
                'message' => $params['message'] ?? null,
                'code' => $transaction->code,
                'amount' => $amount,
                'products' => $cart->cartItems->toArray()
            ]));

            CartItem::whereIn('id', $cartItemIds)->delete();
            $cart->delete();
        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response(['message' => 'Order Successfully']);
    }
}
