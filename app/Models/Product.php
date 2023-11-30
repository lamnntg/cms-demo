<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'material',
        'category_id',
        'name',
        'slug',
        'description',
        'instructions_for_preservation',
        'images',
        'price'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function productSkus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public static function next()
    {
        return static::max('id') + 1;
    }
}
