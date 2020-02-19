<?php

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
        DB::table('categories')->insert([
            'product_id' => 1,
            'name' => 'Material',
            'seo_url' => 'material',
            'description' => 'Material',
            'status' => 1,
            'order' => 1
        ]);
        DB::table('categories')->insert([
            'product_id' => 1,
            'name' => 'Pattern',
            'seo_url' => 'pattern',
            'description' => 'Pattern',
            'status' => 1,
            'order' => 2
        ]);
        DB::table('categories')->insert([
            'product_id' => 1,
            'name' => 'Season',
            'seo_url' => 'season',
            'description' => 'Season',
            'status' => 1,
            'order' => 3
        ]);
        DB::table('categories')->insert([
            'product_id' => 1,
            'name' => 'Color',
            'seo_url' => 'color',
            'description' => 'Color',
            'status' => 1,
            'order' => 4
        ]);
        DB::table('categories')->insert([
            'product_id' => 1,
            'name' => 'Category',
            'seo_url' => 'category',
            'description' => 'Category',
            'status' => 1,
            'order' => 5
        ]);
    }
}
