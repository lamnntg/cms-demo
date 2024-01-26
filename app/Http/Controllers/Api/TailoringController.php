<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tailoring;
use Illuminate\Http\Request;

class TailoringController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'style' => 'nullable|string',
            'bust' => 'nullable|numeric',
            'hips' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'unit' => 'required|in:cm,inches',
        ]);

        $params = $request->all();
        $product = Tailoring::create([
            'email' => $params['email'] ,
            'name' => $params['name'],
            'style' => $params['style'] ?? null,
            'bust' => $params['bust'] ?? null,
            'waist' => $params['waist'] ?? null,
            'hips' => $params['hips'] ?? null,
            'height' => $params['height'] ?? null,
            'unit' => $params['unit'] ?? null,
        ]);

        return $this->response($product);
    }
}
