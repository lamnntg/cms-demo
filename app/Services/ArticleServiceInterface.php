<?php

namespace App\Services;

interface ArticleServiceInterface
{
    public function index(array $params);

    public function storeHouseArticale(array $params);

    public function storeServiceArticale(array $params);

    public function hardDeleteHA(int $id);

    public function softDeleteHA(int $id);

    public function hardDeleteSA(int $id);

    public function softDeleteSA(int $id);
}
