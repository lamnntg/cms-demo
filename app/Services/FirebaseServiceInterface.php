<?php

namespace App\Services;

interface FirebaseServiceInterface
{
    public function login(string $method, array $params);

    public function register(array $params);

    public function logout(string $uid);
}
