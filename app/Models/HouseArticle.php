<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseArticle extends Model
{
    use HasFactory, SoftDeletes;

    //type
    public const TYPE_SELL = 1;
    public const TYPE_LEASE = 2;

    public static $types = [
        self::TYPE_SELL => 'Bán căn hộ',
        self::TYPE_LEASE => 'Cho thuê căn hộ',
    ];

    // kind
    public const NEWS_NORMAL = 0;
    public const NEWS_VIP = 1;

    public static $kinds = [
        self::NEWS_NORMAL => 'Tin thường',
        self::NEWS_VIP => 'Tin vip'
    ];

    // status
    public const STATUS_NOT_ACCEPTED = 0;
    public const STATUS_ACCEPTED = 1;
    public const STATUS_WAITING_ACCEPT = 2;

    public static $status = [
        self::STATUS_NOT_ACCEPTED => 'Không được duyệt',
        self::STATUS_ACCEPTED => 'Được duyệt',
        self::STATUS_WAITING_ACCEPT => 'Chờ duyệt'
    ];

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

    public static function next()
    {
        return static::max('id') + 1;
    }
}
