<?php

namespace App\Http\Controllers\Api;

use App\Models\Club;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($params, [
            'time' => 'required|string',
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

        try {
            Order::create([
                'time' => $params['time'],
                'type' => $params['type'],
                'address' => $params['address'],
                'name' => $params['name'],
                'phone' => $params['phone'],
                'email' => $params['email'] ?? null,
                'message' => $params['message'] ?? null,
            ]);
        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response([], Response::HTTP_NO_CONTENT);
    }
}
