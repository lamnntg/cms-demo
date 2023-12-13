<?php

namespace App\Services;

interface NewsServiceInterface
{
    public function store(array $params);

    public function hardDelete(int $id);

    public function softDelete(int $id);
}
