<?php

namespace Idib\Suits\Seeds;

use Illuminate\Database\Seeder;

class SuitAccentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('suit_accents')->insert([
            'name' => 'Button',
            'accent_url' => 'button',
            'description' => 'Button',
            'class_name' => '',
            'price' => 5.00,
            'image' => '',
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_accents')->insert([
            'name' => 'Thread',
            'accent_url' => 'thread',
            'description' => 'Thread',
            'class_name' => '',
            'price' => 6.00,
            'image' => '',
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_accents')->insert([
            'name' => 'Pocket Square',
            'accent_url' => 'pocketsquare',
            'description' => 'Pocket Square',
            'class_name' => '',
            'price' => 7.00,
            'image' => '',
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_accents')->insert([
            'name' => 'Lining',
            'accent_url' => 'lining',
            'description' => 'Lining',
            'class_name' => '',
            'price' => 8.00,
            'image' => '',
            'status' => 1,
            'order_id' => 4,
        ]);
    }
}
