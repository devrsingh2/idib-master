<?php

namespace Idib\Suits\Seeds;

use Illuminate\Database\Seeder;

class SuitStyleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //jacket styles
        \DB::table('suit_styles')->insert([
            'name' => 'Fit',
            'seo_url' => 'fit',
            'designType' => 'jacket',
            'description' => 'Fit',
            'class_name' => 'suit-icon-Single_Breasted_2_Button',
            'price' => 5.00,
            'image' => '',
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Style',
            'seo_url' => 'style',
            'designType' => 'jacket',
            'description' => 'Style',
            'class_name' => 'suit-icon-Main_Style_Icon',
            'price' => 4.00,
            'image' => '',
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Lapel',
            'seo_url' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Lapel',
            'class_name' => 'suit-icon-Lapel',
            'price' => 3.00,
            'image' => '',
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'pockets',
            'seo_url' => 'pockets',
            'designType' => 'jacket',
            'description' => 'pockets',
            'class_name' => 'suit-icon-Pockets_Main_Icon',
            'price' => 3.00,
            'image' => '',
            'status' => 1,
            'order_id' => 4,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'sleeve buttons',
            'seo_url' => 'sleevebuttons',
            'designType' => 'jacket',
            'description' => 'sleeve buttons',
            'class_name' => 'suit-icon-Sleeve_Main_Icon',
            'price' => 3.00,
            'image' => '',
            'status' => 1,
            'order_id' => 5,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'vents',
            'seo_url' => 'vents',
            'designType' => 'jacket',
            'description' => 'vents',
            'class_name' => 'suit-icon-Center_Vents',
            'price' => 3.00,
            'image' => '',
            'status' => 1,
            'order_id' => 6,
        ]);

        //Pant Styles
        \DB::table('suit_styles')->insert([
            'name' => 'Fit',
            'seo_url' => 'fit',
            'designType' => 'pant',
            'description' => 'Fit',
            'class_name' => 'suit-icon-Pant_Fit_Main_Icon',
            'price' => 5.00,
            'image' => '',
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Pleats',
            'seo_url' => 'pleats',
            'designType' => 'pant',
            'description' => 'Pleats',
            'class_name' => 'suit-icon-Pant_Pleated',
            'price' => 3.00,
            'image' => '',
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Fastening',
            'seo_url' => 'fastening',
            'designType' => 'pant',
            'description' => 'Fastening',
            'class_name' => 'suit-icon-Pant_Fastening_Main_Icon',
            'price' => 6.00,
            'image' => '',
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Pockets',
            'seo_url' => 'pockets',
            'designType' => 'pant',
            'description' => 'pockets',
            'class_name' => 'suit-icon-Pant_Rounded_Pocket',
            'price' => 8.00,
            'image' => '',
            'status' => 1,
            'order_id' => 4,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Cuffs',
            'seo_url' => 'cuffs',
            'designType' => 'pant',
            'description' => 'Cuffs',
            'class_name' => 'suit-icon-Pant_No_Pant_Cuffs',
            'price' => 10.00,
            'image' => '',
            'status' => 1,
            'order_id' => 5,
        ]);

        //vest style
        \DB::table('suit_styles')->insert([
            'name' => 'style',
            'seo_url' => 'style',
            'designType' => 'vest',
            'description' => 'style',
            'class_name' => 'suit-icon-Vest_Single_breasted_4_buttons',
            'price' => 2.00,
            'image' => '',
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Lapel',
            'seo_url' => 'lapel',
            'designType' => 'vest',
            'description' => 'Lapel',
            'class_name' => 'suit-icon-Vest_Notched',
            'price' => 4.00,
            'image' => '',
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Pockets',
            'seo_url' => 'pockets',
            'designType' => 'vest',
            'description' => 'Pockets',
            'class_name' => 'suit-icon-With_Flap',
            'price' => 4.00,
            'image' => '',
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Breast Pockets',
            'seo_url' => 'breastpocket',
            'designType' => 'vest',
            'description' => 'Breast Pockets',
            'class_name' => 'suit-icon-Vest_Breast_Pocket_Yes',
            'price' => 4.00,
            'image' => '',
            'status' => 1,
            'order_id' => 4,
        ]);
        \DB::table('suit_styles')->insert([
            'name' => 'Edge',
            'seo_url' => 'edge',
            'designType' => 'vest',
            'description' => 'Edge',
            'class_name' => 'suit-icon-Vest_Straight',
            'price' => 4.00,
            'image' => '',
            'status' => 1,
            'order_id' => 5,
        ]);

    }
}
