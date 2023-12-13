<?php

namespace App\Services;

interface ArticleServiceInterface
{
    public function storeHouseArtical(array $params);

    public function storeServiceArtical(array $params);

    public function hardDeleteHA(int $id);

    public function softDeleteHA(int $id);

    public function hardDeleteSA(int $id);

    public function softDeleteSA(int $id);
}
