<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseArticle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'content',
        'slug',
        'views',
        'images',
        'type',
        'price',
        'status',
        'area',
        'bedrooms',
        'wcs',
        'livingrooms',
        'address',
        'direction_house',
        'house_number',
        'kind'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'images' => 'array'
    ];
}
