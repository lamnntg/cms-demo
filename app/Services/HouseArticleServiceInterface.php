<?php

namespace App\Services;

interface HouseArticleServiceInterface
{
    public function store(array $params);

    public function hardDelete(int $haId);

    public function softDelete(int $haId);
}
