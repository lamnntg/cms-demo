<?php

namespace App\Services;

use App\Models\HouseArticle;
use Illuminate\Http\Response;

class HouseArticleService implements HouseArticleServiceInterface
{
    public function store(array $data)
    {
        $nextAutoIncrement = HouseArticle::next();
        $slug = \Str::slug($data['title']) . '-' . $nextAutoIncrement;
        $haData = HouseArticle::where('slug', $slug)->withTrashed()->exists();
        $houseArticleCreated = [];
        try {
            if (!$haData) {
                $houseArticleCreated = HouseArticle::create([
                    'user_id' => empty($data['user_id']) ? 0 : $data['user_id'],
                    'title' => $data['title'],
                    'content' => empty($data['content']) ? '' : $data['content'],
                    'slug' => $slug,
                    'images' => !empty($data['images']) ? [$data['images']] : [],
                    'type' => $data['type'],
                    'price' => $data['price'],
                    'status' => HouseArticle::STATUS_ACCEPTED,
                    'area' => empty($data['area']) ? 0 : $data['area'],
                    'bedrooms' => empty($data['bedrooms']) ? 0 : $data['bedrooms'],
                    'wcs' => empty($data['wcs']) ? 0 : $data['wcs'],
                    'livingrooms' => empty($data['livingrooms']) ? 0 : $data['livingrooms'],
                    'address' => empty($data['address']) ? '' : $data['address'],
                    'direction_house' => empty($data['direction_house']) ? '' : $data['direction_house'],
                    'house_number' =>  empty($data['house_number']) ? 0 : $data['house_number'],
                    'kind' => $data['kind']
                ]);
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This title exists.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, $houseArticleCreated];
    }

    public function hardDelete(int $haId)
    {
        try {
            $houseArticle = HouseArticle::withTrashed()->find($haId);

            if ($houseArticle) {
                $houseArticle->forceDelete();
                return [Response::HTTP_OK, ['message' => 'This record has force deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }

    public function softDelete(int $haId)
    {
        try {
            $houseArticle = HouseArticle::find($haId);

            if ($houseArticle) {
                $houseArticle->delete();
                return [Response::HTTP_OK, ['message' => 'This record has soft deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }
}
