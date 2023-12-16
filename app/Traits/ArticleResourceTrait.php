<?php

namespace App\Traits;

trait ArticleResourceTrait
{
    public function firebaseUserTransform($firebaseUser) {
        return [
            'id' => $firebaseUser->id,
            'uid' => $firebaseUser->uid,
            'email' => $firebaseUser->email,
            'display_name' => $firebaseUser->display_name,
            'photo_url' => $firebaseUser->photo_url,
            'phone_number' => $firebaseUser->phone_number,
            'role' => $firebaseUser->role ?? 'user',
        ];
    }
}
