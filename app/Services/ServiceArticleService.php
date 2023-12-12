<?php

namespace App\Services;

use App\Models\ServiceArticle;
use Illuminate\Http\Response;

class ServiceArticleService implements ServiceArticleServiceInterface
{
    public function store(array $data)
    {
        try {
            $nextAutoIncrement = ServiceArticle::next();
            $slug = \Str::slug($data['title']) . '-' . $nextAutoIncrement;
            $saData = ServiceArticle::where('slug', $slug)->withTrashed()->exists();
            $serviceArticleCreated = [];

            if (!$saData) {
                $serviceArticleCreated = ServiceArticle::create([
                    'user_id' => empty($data['user_id']) ? 0 : $data['user_id'],
                    'title' => $data['title'],
                    'content' => empty($data['content']) ? '' : $data['content'],
                    'slug' => $slug,
                    'images' => !empty($data['images']) ? [$data['images']] : [],
                    'price' => $data['price'],
                    'status' => ServiceArticle::STATUS_ACCEPTED,
                ]);
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This title exists.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, $serviceArticleCreated];
    }

    public function hardDelete(int $saId)
    {
        try {
            $serviceArticle = ServiceArticle::withTrashed()->find($saId);

            if ($serviceArticle) {
                $serviceArticle->forceDelete();
                return [Response::HTTP_OK, ['message' => 'This record has force deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }

    public function softDelete(int $saId)
    {
        try {
            $serviceArticle = ServiceArticle::find($saId);

            if ($serviceArticle) {
                $serviceArticle->delete();
                return [Response::HTTP_OK, ['message' => 'This record has soft deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, ['message' => 'This record not found.']];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }
}
