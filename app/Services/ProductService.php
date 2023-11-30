<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductServiceInterface
{
    /**
     * store function
     *
     * @param array $product
     * @return array
     */
    public function store(array $product) {
        DB::beginTransaction();
        try {
            $nextAutoIncrement = Product::next();

            $productCreated = Product::create([
                'category_id' => $product['category_id'] ?? 1,
                'name' => $product['name'],
                'slug' => \Str::slug($product['name']) . '-' . $nextAutoIncrement,
                'material' => $product['material'],
                'description' => $product['description'],
                'preservation' => $product['preservation'] ?? null,
                'images' => !empty($product['images']) ? [$product['images']] : [],
                'price' => $product['price']
            ]);

            // create with relationships
            $skus = [];
            foreach ($product['product_skus'] as $sku) {
                $skus[] = [
                    'product_id' => $productCreated->id,
                    'sku_code' => $sku['sku_code'],
                    'price' => $sku['price'],
                    'quantity_size_s' => $sku['quantity_size_s'],
                    'quantity_size_m' => $sku['quantity_size_m'],
                    'quantity_size_l' => $sku['quantity_size_l'],
                    'quantity_size_xl' => $sku['quantity_size_xl'],
                    'quantity_size_2xl' => $sku['quantity_size_2xl'],
                    'image_sku' => json_encode($sku['image_sku']),
                    'color' => $sku['color'],
                ];
            }

            ProductSku::insert($skus);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return [false, $e->getMessage()];
        }

        return [true, $productCreated];
    }
}
