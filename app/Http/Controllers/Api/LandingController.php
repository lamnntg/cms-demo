<?php

namespace App\Http\Controllers\Api;

class LandingController extends ApiController
{
    /**
     * index function
     *
     * @return void
     */
    public function index() {
        $this->response([], 200);
    }
}
