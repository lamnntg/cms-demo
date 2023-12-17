<?php

namespace App\Services;

interface ArticleServiceInterface
{
    public function getHouseArticles(array $params, array $paginate);

    public function getServiceArticles(array $params, array $paginate);

    public function getMarketArticles(array $params, array $paginate);

    public function houseArticleDetail(int $id);

    public function serviceArticleDetail(int $id);

    public function marketArticleDetail(int $id);

    public function storeHouseArticle(array $params);

    public function storeServiceArticle(array $params);

    public function storeMarketArticle(array $params);

    public function updateHouseArticle(array $params);

    public function updateServiceArticle(array $params);

    public function updateMarketArticle(array $params);

    public function hardDeleteHA(int $id);

    public function softDeleteHA(int $id);

    public function hardDeleteSA(int $id);

    public function softDeleteSA(int $id);

    public function softDeleteMA(int $id);
}
