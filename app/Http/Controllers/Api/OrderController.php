<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends ApiController
{
    /**
     * store function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request) {
        $params = $request->all();

        try {
            Order::create([
                'club_id' => $params['club_id'],
                'name' => $params['name'],
                'phone' => $params['phone'],
                'email' => $params['email'],
                'message' => $params['message'],
            ]);
        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response([], Response::HTTP_NO_CONTENT);
    }
}
