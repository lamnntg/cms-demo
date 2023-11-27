<?php

namespace App\Services;

class ProductService implements ProductServiceInterface
{
    /**
     * store function
     *
     * @param array $product
     * @return void
     */
    public function store(array $product) {

        
        dd($product);
    }
}
