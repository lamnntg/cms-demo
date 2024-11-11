<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Blazer 6 buttons form menswear',
                'industry_id' => 1,
                'slug' => 'blaze',
                'description' => 'blaze',
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/prism-store.appspot.com/o/categories%2Fblaze_6_btn.png?alt=media&token=f5b935d4-90be-41ac-a8c1-0a570a1bdf88',
                'meta_keywords' => '',
            ],
            [
                'id' => 2,
                'name' => 'Blazer Croptopn',
                'industry_id' => 1,
                'slug' => 'blaze_crop',
                'description' => 'blaze',
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/prism-store.appspot.com/o/categories%2Fblaze_crop_top.png?alt=media&token=d0871ffe-3332-4da1-91a4-95e63bd2c27f',
                'meta_keywords' => '',
            ],
            [
                'id' => 3,
                'name' => 'Blazer Crotop Leather',
                'industry_id' => 1,
                'slug' => 'blaze_crop_leather',
                'description' => 'blaze',
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/prism-store.appspot.com/o/categories%2Fblaze_crop_top_leather.png?alt=media&token=b518e2ee-4c25-4fad-81cb-13a2eb656fcb',
                'meta_keywords' => '',
            ],
            [
                'id' => 4,
                'name' => 'Blazer',
                'industry_id' => 1,
                'slug' => 'blaze_basic',
                'description' => '10:00pm - 3:00am',
                'thumbnail' => 'https://firebasestorage.googleapis.com/v0/b/prism-store.appspot.com/o/categories%2Fblaze_basic.png?alt=media&token=0565f99f-df06-47ee-bb41-2791c1de93d6',
                'meta_keywords' => '',
            ],
        ];

        DB::table('categories')->insert($data);
    }
}
