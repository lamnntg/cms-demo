<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirebaseUser extends Model
{
    use HasFactory;

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
        'uid'
    ];

    public function getAuthIdentifierName() {
        return 'local_id';
     }
     public function getAuthIdentifier(){
        return $this->local_id;
     }

}
