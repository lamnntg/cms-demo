<?php

namespace App\Services;

interface ArticleServiceInterface
{
    public function index(array $params, array $paginate);

    public function storeHouseArticle(array $params);

    public function storeServiceArticle(array $params);

    public function hardDeleteHA(int $id);

    public function softDeleteHA(int $id);

    public function hardDeleteSA(int $id);

    public function softDeleteSA(int $id);
}
