<?php

namespace App\Http\Resources\Article;

use App\Traits\ArticleResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseArticleResource extends JsonResource
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
            'type' => $data['type'],
            'price' => $data['price'],
            'status' => $data['status'],
            'area' => $data['area'],
            'bedrooms' => $data['bedrooms'],
            'wcs' => $data['wcs'],
            'livingrooms' => $data['livingrooms'],
            'address' => $data['address'],
            'direction_house' => $data['direction_house'],
            'house_number' => $data['house_number'],
            'kind' => $data['kind'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
            'user' => $firebaseUser ?? []
        ];
    }
}
