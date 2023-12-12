<?php

namespace App\Services;

interface ServiceArticleServiceInterface
{
    public function store(array $params);

    public function hardDelete(int $saId);

    public function softDelete(int $saId);
}
