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
    public function store(array $product)
    {
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
            foreach ($product['product_skus'] as $sku) {
                ProductSku::create([
                    'product_id' => $productCreated->id,
                    'sku_code' => $sku['sku_code'],
                    'price' => $sku['price'],
                    'quantity_size_s' => $sku['quantity_size_s'],
                    'quantity_size_m' => $sku['quantity_size_m'],
                    'quantity_size_l' => $sku['quantity_size_l'],
                    'quantity_size_xl' => $sku['quantity_size_xl'],
                    'quantity_size_2xl' => $sku['quantity_size_2xl'],
                    'quantity' => $sku['quantity_size_s'] + $sku['quantity_size_m'] + $sku['quantity_size_l'] + $sku['quantity_size_xl'] + $sku['quantity_size_2xl'],
                    'image_sku' => $sku['image_sku'],
                    'color' => $sku['color'],
                ]);
            }

            // ProductSku::insert($skus);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return [false, $e->getMessage()];
        }

        return [true, $productCreated];
    }

    /**
     * find function
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id)
    {
        return Product::with('productSkus')->find($id);
    }

    /**
     * update function
     *
     * @param integer $id
     * @param array $product
     * @return array
     */
    public function update(int $id, $data)
    {
        $product = Product::with('productSkus')->find($id);

        if (!$product) {
            return [false, null];
        }

        DB::beginTransaction();
        try {
            $product->update([
                'category_id' => $data['category_id'] ?? 1,
                'name' => $data['name'],
                'material' => $data['material'],
                'description' => $data['description'],
                'preservation' => $data['preservation'] ?? null,
                'images' => !empty($data['images']) ? [$data['images']] : [],
                'price' => $data['price']
            ]);

            $skuIds = $product->productSkus->pluck('id')->toArray();
            ProductSku::whereIn('id', $skuIds)->forceDelete();

            // create with relationships
            foreach ($data['product_skus'] as $sku) {
                ProductSku::create([
                    'product_id' => $product->id,
                    'sku_code' => $sku['sku_code'],
                    'price' => $sku['price'],
                    'quantity_size_s' => $sku['quantity_size_s'],
                    'quantity_size_m' => $sku['quantity_size_m'],
                    'quantity_size_l' => $sku['quantity_size_l'],
                    'quantity_size_xl' => $sku['quantity_size_xl'],
                    'quantity_size_2xl' => $sku['quantity_size_2xl'],
                    'quantity' => $sku['quantity_size_s'] + $sku['quantity_size_m'] + $sku['quantity_size_l'] + $sku['quantity_size_xl'] + $sku['quantity_size_2xl'],
                    'image_sku' => $sku['image_sku'],
                    'color' => $sku['color'],
                ]);
            }

            // ProductSku::insert($skus);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return [false, $e->getMessage()];
        }

        return [true, $product];
    }

    public function destroy(int $id)
    {
        $product = Product::with('productSkus')->find($id);
        if (!$product) {
            return [false, 'Product not found'];
        }

        DB::beginTransaction();
        try {
            $skuIds = $product->productSkus->pluck('id')->toArray();
            ProductSku::whereIn('id', $skuIds)->forceDelete();
            $product->forceDelete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return [false, $e->getMessage()];
        }

        return [true, 'Delete Successfully'];
    }
}
