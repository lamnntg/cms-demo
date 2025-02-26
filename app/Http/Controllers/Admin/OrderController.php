<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with(['orderItems', 'firebaseUser'])->get();

        foreach ($orders as $order) {
            $totalPrice = 0;
            foreach ($order->orderItems as $orderItem) {
                $totalPrice += $orderItem->price * $orderItem->quantity;
            }
            $order->setAttribute('total_price', $totalPrice);
        }

        return view('order', compact('orders'));
    }
}
