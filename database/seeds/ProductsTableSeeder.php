<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Suit',
            'seo_url' => 'suit',
            'description' => 'Suit Tool',
            'logo' => config('app.asset_url').'images/suit.jpg',
            'status' => 1,
            'order' => 1
        ]);
    }
}
