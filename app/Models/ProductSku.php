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
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getImageSkuAttribute($value)
    {
        if (is_array($value)) {
            return $this->attributes['image_sku'] = $value;
        }

        return $this->attributes['image_sku'] = explode(';', $value);
    }
}
