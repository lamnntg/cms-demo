<?php

namespace App\Http\Resources\Article;

use App\Traits\ArticleResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceArticleResource extends JsonResource
{
    use ArticleResourceTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request = null)
    {
        $data = $this->resource;

        if (!empty($data['firebaseUser'])) {
            $firebaseUser = $this->firebaseUserTransform($data['firebaseUser']);
        }

        return [
            'id' => $data['id'],
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'content' => $data['content'],
            'slug' => $data['slug'],
            'views' => $data['views'],
            'images' => $data['images'],
            'status' => $data['status'],
            'price' => $data['price'],
            'user' => $firebaseUser ?? []
        ];
    }
}
