<?php

namespace Idib\Suits\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuitCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suit_categories')->insert([
            'parent_id' => 0,
            'name' => 'Material',
            'seo_url' => 'material',
            'description' => 'Material',
            'status' => 1,
            'order' => 1
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 0,
            'name' => 'Pattern',
            'seo_url' => 'pattern',
            'description' => 'Pattern',
            'status' => 1,
            'order' => 2
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 0,
            'name' => 'Color',
            'seo_url' => 'color',
            'description' => 'Color',
            'status' => 1,
            'order' => 3
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 0,
            'name' => 'Collection',
            'seo_url' => 'collection',
            'description' => 'Collection',
            'status' => 1,
            'order' => 4
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 0,
            'name' => 'Season',
            'seo_url' => 'season',
            'description' => 'Season',
            'status' => 0,
            'order' => 5
        ]);
        DB::table('suit_categories')->insert([
            'parent_id' => 0,
            'name' => 'Category',
            'seo_url' => 'category',
            'description' => 'Category',
            'status' => 0,
            'order' => 6
        ]);
    }
}
