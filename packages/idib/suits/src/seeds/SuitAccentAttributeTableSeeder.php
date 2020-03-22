<?php

namespace Idib\Suits\Seeds;

use Illuminate\Database\Seeder;

class SuitAccentAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('suit_accent_attributes')->insert([
            'accent_id' => 1,
            'name' => 'Default',
            'description' => 'Default',
            'class_name' => '',
            'price' => 2.00,
            'image' => '',
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_accent_attributes')->insert([
            'accent_id' => 1,
            'name' => 'Bronze',
            'description' => 'Bronze',
            'class_name' => '',
            'price' => 4.00,
            'image' => '',
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_accent_attributes')->insert([
            'accent_id' => 1,
            'name' => 'Silver',
            'description' => 'Silver',
            'class_name' => '',
            'price' => 8.00,
            'image' => '',
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_accent_attributes')->insert([
            'accent_id' => 1,
            'name' => 'Gold',
            'description' => 'Gold',
            'class_name' => '',
            'price' => 10.00,
            'image' => '',
            'status' => 1,
            'order_id' => 4,
        ]);

        /*\DB::table('suit_accent_attributes')->insert([
            'accent_id' => 2,
            'name' => 'Default',
            'description' => 'Default',
            'class_name' => '',
            'price' => 2.00,
            'image' => '',
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_accent_attributes')->insert([
            'accent_id' => 2,
            'name' => 'Bronze',
            'description' => 'Bronze',
            'class_name' => '',
            'price' => 4.00,
            'image' => '',
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_accent_attributes')->insert([
            'accent_id' => 2,
            'name' => 'Silver',
            'description' => 'Silver',
            'class_name' => '',
            'price' => 8.00,
            'image' => '',
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_accent_attributes')->insert([
            'accent_id' => 2,
            'name' => 'Gold',
            'description' => 'Gold',
            'class_name' => '',
            'price' => 10.00,
            'image' => '',
            'status' => 1,
            'order_id' => 4,
        ]);*/

    }
}
