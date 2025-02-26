<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'product_id',
        'sku_code',
        'price',
        'quantity',
        'image_sku',
        'color',
        'quantity_size_s',
        'quantity_size_m',
        'quantity_size_l',
        'quantity_size_xl',
        'quantity_size_2xl',
        'description',
        'material',
        'size'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'image_sku' => 'array',
    ];

    // public function getImageSkuAttribute($value)
    // {
    //     if (is_array($value)) {
    //         return $this->attributes['image_sku'] = $value;
    //     }

    //     return $this->attributes['image_sku'] = explode(';', $value);
    // }
}
