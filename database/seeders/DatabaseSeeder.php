<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ClubTableSeeder::run(); //

        $data = [
            [
                'key' => 'banner_1',
                'type' => 'banner',
                'value' => 'https://res.cloudinary.com/dzoocwvq8/image/upload/v1664502889/cld-sample-5.jpg'
            ],
            [
                'key' => 'banner_2',
                'type' => 'banner',
                'value' => 'https://res.cloudinary.com/dzoocwvq8/image/upload/v1664502889/cld-sample-4.jpg'
            ],
            [
                'key' => 'banner_3',
                'type' => 'banner',
                'value' => 'https://res.cloudinary.com/dzoocwvq8/image/upload/v1664502888/cld-sample-3.jpg'
            ],
            [
                'key' => 'text_title',
                'type' => 'text',
                'value' => 'Mosvici'
            ],
            [
                'key' => 'text_description',
                'type' => 'text',
                'value' => 'Mosvici'
            ],
        ];

        DB::table('landing_page_configs')->insert($data);
    }
}
