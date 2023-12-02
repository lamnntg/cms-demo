<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'price' => $data['price'],
            'material' => $data['material'],
            'description' => $data['description'],
            'preservation' => $data['preservation'],
            'images' => $data['images'],
            'is_product_favorite' => $data['is_product_favorite'],
            'product_skus' => $this->mappingSkus($data['productSkus'])
        ];
    }

    /**
     * mappingSkus function
     *
     * @param array $data
     * @return void
     */
    public function mappingSkus($productSkus) {
        $skus = [];
        foreach ($productSkus as $productSku) {
            $skus[] = [
                'id' => $productSku['id'],
                'product_id' => $productSku['product_id'],
                'sku_code' => $productSku['sku_code'],
                'price' => $productSku['price'],
                'quantity' => $productSku['quantity'],
                'image_sku' => $productSku['image_sku'],
                'quantity_size_s' => $productSku['quantity_size_s'],
                'quantity_size_m' => $productSku['quantity_size_m'],
                'quantity_size_l' => $productSku['quantity_size_l'],
                'quantity_size_xl' => $productSku['quantity_size_xl'],
                'quantity_size_2xl' => $productSku['quantity_size_2xl'],
                'color' => $productSku['color'],
            ];
        }

        return $skus;
    }
}
