<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = $this->resource;

        return [
            'id' => $data['id'],
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'content' => $data['content'],
            'slug' => $data['slug'],
            'views' => $data['views'],
            'images' => $data['images'],
            'status' => $data['status'],
            'price' => $data['price']
        ];
    }
}
