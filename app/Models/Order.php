<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'phone',
        'email',
        'message',
        'address',
        'type',
        'time',
        'firebase_user_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * get club
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'id');
    }

    public function firebaseUser()
    {
        return $this->belongsTo(FirebaseUser::class, 'firebase_user_id', 'id');
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }
}
