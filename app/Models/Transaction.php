<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'firebase_user_id',
        'code',
        'order_id',
        'mode',
        'status',
        'amount',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
