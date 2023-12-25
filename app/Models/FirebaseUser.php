<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FirebaseUser extends Authenticatable
{
    use HasFactory;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    public static $roles = [
        self::ROLE_ADMIN => 'admin',
        self::ROLE_USER => 'user'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'display_name',
        'email',
        'local_id',
        'phone_number',
        'uid',
        'photo_url',
        'verify_at'
    ];

    protected $dates = [
        'verify_at',
        'created_at',
        'updated_at',
    ];

    public function getAuthIdentifierName()
    {
        return 'local_id';
    }

    public function getAuthIdentifier()
    {
        return $this->local_id;
    }
}
