<?php

namespace App\Services;

interface ProductServiceInterface
{
    public function store(array $params);

    public function find(int $id);

    public function update(int $id, array $product);

    public function destroy(int $id);
}
