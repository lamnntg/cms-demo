<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\LandingPageConfig;

class LandingController extends ApiController
{
    /**
     * index function
     *
     * @return void
     */
    public function index() {
        $data['banners'] = LandingPageConfig::select('id', 'key', 'value')->get();
        $data['articles'] = Article::all();

        return $this->response($data, 200);
    }
}
