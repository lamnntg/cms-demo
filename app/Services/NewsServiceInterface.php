<?php

namespace App\Services;

interface NewsServiceInterface
{
    public function store(array $params);

    public function hardDelete(int $id);

    public function softDelete(int $id);

    public function getNews(array $paginate);

    public function getNewsDetail(int $id);

    public function updateNews(array $params);
}
