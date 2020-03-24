<?php

namespace Idib\Suits\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuitSubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //material
        DB::table('suit_categories')->insert([
            'parent_id' => 1,
            'name' => 'Luxury Wool',
            'seo_url' => 'luxury-wool',
            'description' => 'Luxury Wool',
            'status' => 1,
            'order' => 1
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 1,
            'name' => 'Wool, Silk & Linen',
            'seo_url' => 'wool-silk-linen',
            'description' => 'Wool, Silk & Linen',
            'status' => 1,
            'order' => 2
        ]);
        //pattern
        DB::table('suit_categories')->insert([
            'parent_id' => 2,
            'name' => 'Checks',
            'seo_url' => 'checks',
            'description' => 'Checks',
            'status' => 1,
            'order' => 1
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 2,
            'name' => 'Plain',
            'seo_url' => 'plain',
            'description' => 'Plain',
            'status' => 1,
            'order' => 2
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 2,
            'name' => 'Lining',
            'seo_url' => 'lining',
            'description' => 'Lining',
            'status' => 1,
            'order' => 3
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 2,
            'name' => 'Dotted',
            'seo_url' => 'dotted',
            'description' => 'Dotted',
            'status' => 1,
            'order' => 4
        ]);
        //color
        DB::table('suit_categories')->insert([
            'parent_id' => 3,
            'name' => 'Blue',
            'seo_url' => 'blue',
            'description' => 'Blue',
            'status' => 1,
            'order' => 1
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 3,
            'name' => 'White',
            'seo_url' => 'white',
            'description' => 'White',
            'status' => 1,
            'order' => 2
        ]);
        //collection
        DB::table('suit_categories')->insert([
            'parent_id' => 4,
            'name' => 'Cotton',
            'seo_url' => 'cotton',
            'description' => 'Cotton',
            'status' => 1,
            'order' => 1
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 4,
            'name' => 'Linen',
            'seo_url' => 'linen',
            'description' => 'Linen',
            'status' => 1,
            'order' => 2
        ]);
    }
}
