<?php

namespace App\Http\Controllers\Api;

use App\Models\HouseArticle;
use App\Models\MarketArticle;
use App\Models\News;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManageController extends ApiController
{
    const POST_MODELS = [
        'market' => MarketArticle::class,
        'house' => HouseArticle::class,
        'news' => News::class,
    ];

    public function approve(Request $request)
    {
        if (!is_role_admin()) {
            return $this->response(Response::$statusTexts[Response::HTTP_FORBIDDEN], Response::HTTP_FORBIDDEN);
        }

        try {
            $request->validate([
                'status' => 'required|in:0,1,2',
                'id' => 'required|integer',
                'object_type' => 'required|string|in:market,house,news',
            ]);

            $params = $request->all();
            $model = self::POST_MODELS[$params['object_type']];
            $object = $model::findOrFail($params['id']);
            $object->update([
                'status' => $params['status']
            ]);

            return $this->response("Update successfully", Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->response($th, Response::HTTP_BAD_REQUEST);
        }

        return $this->response('Object not found', Response::HTTP_OK);
    }
}
