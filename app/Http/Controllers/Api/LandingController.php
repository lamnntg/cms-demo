<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Category;
use App\Models\Club;
use App\Models\Event;
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
        $data['events'] = Event::all();
        $data['clubs'] = Club::all();
        $data['articles'] = Article::all();
        $data['categories'] = Category::all();

        return $this->response($data, 200);
    }
}
