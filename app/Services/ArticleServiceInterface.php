<?php

namespace App\Services;

interface ArticleServiceInterface
{
    public function getHouseArticles(array $params, array $paginate);

    public function getServiceArticles(array $params, array $paginate);

    public function storeHouseArticle(array $params);

    public function storeServiceArticle(array $params);

    public function hardDeleteHA(int $id);

    public function softDeleteHA($params);

    public function hardDeleteSA(int $id);

    public function softDeleteSA($params);
}
