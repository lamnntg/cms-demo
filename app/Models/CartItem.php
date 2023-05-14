<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'cart_id',
        'product_id',
        'product_sku_id',
        'quantity',
        'price',
        'size'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function productSku() {
        return $this->belongsTo(ProductSku::class);
    }
}
