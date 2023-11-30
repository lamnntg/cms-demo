<?php

namespace App\Services;

interface ProductServiceInterface
{
    public function store(array $params);

    public function find(int $id);
}
