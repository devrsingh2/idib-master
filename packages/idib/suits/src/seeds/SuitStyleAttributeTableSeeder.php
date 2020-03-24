<?php

namespace Idib\Suits\Seeds;

use Illuminate\Database\Seeder;

class SuitStyleAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //jacket style
        //style 1
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 1,
            'name' => 'Slim Fit',
            'parent' => 'fit',
            'designType' => 'jacket',
            'description' => 'Slim Fit',
            'class_name' => 'suit-icon-Slim_Fit',
            'price' => 10.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 1,
            'name' => 'Classic Fit',
            'parent' => 'fit',
            'designType' => 'jacket',
            'description' => 'Classic Fit',
            'class_name' => 'suit-icon-Fit_Main_Icon',
            'price' => 8.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 1,
            'name' => 'XL/Plus Size',
            'parent' => 'fit',
            'designType' => 'jacket',
            'description' => 'XL/Plus Size',
            'class_name' => 'suit-icon-Large_Fit',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        //style 2
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 2,
            'name' => 'Single Breasted 1 Button',
            'parent' => 'style',
            'designType' => 'jacket',
            'description' => 'Single Breasted 1 Button',
            'class_name' => 'suit-icon-Single_Breasted_1_Button',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 2,
            'name' => 'Single Breasted 2 Button',
            'parent' => 'style',
            'designType' => 'jacket',
            'description' => 'Single Breasted 2 Button',
            'class_name' => 'suit-icon-Single_Breasted_2_Button',
            'price' => 7.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 2,
            'name' => 'Single Breasted 3 Button',
            'parent' => 'style',
            'designType' => 'jacket',
            'description' => 'Single Breasted 3 Button',
            'class_name' => 'suit-icon-Single_Breasted_3_Button',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 2,
            'name' => 'Double Breasted 2 Button',
            'parent' => 'style',
            'designType' => 'jacket',
            'description' => 'Double Breasted 2 Button',
            'class_name' => 'suit-icon-Double_Breasted_2_Buttons',
            'price' => 8.00,
            'status' => 1,
            'order_id' => 4,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 2,
            'name' => 'Double Breasted 4 Button',
            'parent' => 'style',
            'designType' => 'jacket',
            'description' => 'Double Breasted 4 Button',
            'class_name' => 'suit-icon-Double_Breasted_4_Buttons',
            'price' => 6.00,
            'status' => 1,
            'order_id' => 5,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 2,
            'name' => 'Double Breasted 6x2 Button',
            'parent' => 'style',
            'designType' => 'jacket',
            'description' => 'Double Breasted 6x2 Button',
            'class_name' => 'suit-icon-Double_Breasted_6_Buttons',
            'price' => 8.00,
            'status' => 1,
            'order_id' => 6,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 2,
            'name' => 'Double Breasted 8 Button',
            'parent' => 'style',
            'designType' => 'jacket',
            'description' => 'Double Breasted 8 Button',
            'class_name' => 'suit-icon-Double_Breasted_8_Buttons',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 7,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 2,
            'name' => 'Mandarin 5 Button',
            'parent' => 'style',
            'designType' => 'jacket',
            'description' => 'Mandarin 5 Button',
            'class_name' => 'suit-icon-Mandarin',
            'price' => 7.00,
            'status' => 1,
            'order_id' => 8,
        ]);
        //style 3
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Notch Slim',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Notch Slim',
            'class_name' => 'suit-icon-Slim_Lapel',
            'price' => 2.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Notch Regular',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Notch Regular',
            'class_name' => 'suit-icon-Standard',
            'price' => 3.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Notch Wide',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Notch Wide',
            'class_name' => 'suit-icon-Wide',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Peak Slim',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Peak Slim',
            'class_name' => 'suit-icon-Peak',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 4,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Peak Regular',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Peak Regular',
            'class_name' => 'suit-icon-Peak',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 5,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Peak Wide',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Peak Wide',
            'class_name' => 'suit-icon-Peak',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 6,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Shawl Slim',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Shawl Slim',
            'class_name' => 'suit-icon-Shawl',
            'price' => 6.00,
            'status' => 1,
            'order_id' => 7,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Shawl Regular',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Shawl Regular',
            'class_name' => 'suit-icon-Shawl',
            'price' => 6.00,
            'status' => 1,
            'order_id' => 8,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 3,
            'name' => 'Shawl Wide',
            'parent' => 'lapel',
            'designType' => 'jacket',
            'description' => 'Shawl Wide',
            'class_name' => 'suit-icon-Shawl',
            'price' => 3.00,
            'status' => 1,
            'order_id' => 9,
        ]);
        //style 4
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 4,
            'name' => 'No Pocket',
            'parent' => 'pockets',
            'designType' => 'jacket',
            'description' => 'No Pocket',
            'class_name' => 'suit-icon-No_Pockets',
            'price' => 0.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 4,
            'name' => 'Flap Pockets',
            'parent' => 'pockets',
            'designType' => 'jacket',
            'description' => 'Flap Pockets',
            'class_name' => 'suit-icon-With_Flap',
            'price' => 2.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 4,
            'name' => 'Patch Pockets',
            'parent' => 'pockets',
            'designType' => 'jacket',
            'description' => 'Patch Pockets',
            'class_name' => 'suit-icon-Patched',
            'price' => 3.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 4,
            'name' => 'Welted Pockets',
            'parent' => 'pockets',
            'designType' => 'jacket',
            'description' => 'Welted Pockets',
            'class_name' => 'suit-icon-Double_Welted',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 4,
        ]);
        //style 5
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 5,
            'name' => '2 Button',
            'parent' => 'sleevebuttons',
            'designType' => 'jacket',
            'description' => '2 Button',
            'class_name' => 'suit-icon-button2',
            'price' => 2.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 5,
            'name' => '3 Button',
            'parent' => 'sleevebuttons',
            'designType' => 'jacket',
            'description' => '3 Button',
            'class_name' => 'suit-icon-button3',
            'price' => 3.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 5,
            'name' => '4 Button',
            'parent' => 'sleevebuttons',
            'designType' => 'jacket',
            'description' => '4 Button',
            'class_name' => 'suit-icon-button4',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        //style 6
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 6,
            'name' => 'No Vent',
            'parent' => 'vents',
            'designType' => 'jacket',
            'description' => 'No Vent',
            'class_name' => 'suit-icon-No',
            'price' => 0.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 6,
            'name' => 'Center Vent',
            'parent' => 'vents',
            'designType' => 'jacket',
            'description' => 'Center Vent',
            'class_name' => 'suit-icon-Center_Vents',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 6,
            'name' => 'Side Vent',
            'parent' => 'vents',
            'designType' => 'jacket',
            'description' => 'Side Vent',
            'class_name' => 'suit-icon-Side_Vents',
            'price' => 6.00,
            'status' => 1,
            'order_id' => 3,
        ]);

        //pant style
        //style 1
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 7,
            'name' => 'Regular Fit',
            'parent' => 'pantfit',
            'designType' => 'pant',
            'description' => 'Regular Fit',
            'class_name' => 'suit-icon-Pant_Regular_Fit',
            'price' => 6.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 7,
            'name' => 'Slim Fit',
            'parent' => 'pantfit',
            'designType' => 'pant',
            'description' => 'Slim Fit',
            'class_name' => 'suit-icon-Pant_Slim_Fit',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        //style 2
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 8,
            'name' => 'No Pleat',
            'parent' => 'pantpleats',
            'designType' => 'pant',
            'description' => 'No Pleat',
            'class_name' => 'suit-icon-No',
            'price' => 0.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 8,
            'name' => 'Single Pleat',
            'parent' => 'pantpleats',
            'designType' => 'pant',
            'description' => 'Single Pleat',
            'class_name' => 'suit-icon-Pant_Pleated',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 8,
            'name' => 'Double Pleat',
            'parent' => 'pantpleats',
            'designType' => 'pant',
            'description' => 'Double Pleat',
            'class_name' => 'suit-icon-Pant_Double_Pleats',
            'price' => 10.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        //style 3
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 9,
            'name' => 'Centered',
            'parent' => 'pantfastening',
            'designType' => 'pant',
            'description' => 'Centered',
            'class_name' => 'suit-icon-Pant_Centered',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 9,
            'name' => 'Off Centered',
            'parent' => 'pantfastening',
            'designType' => 'pant',
            'description' => 'Off Centered',
            'class_name' => 'suit-icon-Pant_Off_Centered_Buttonless',
            'price' => 6.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        //style 4
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 10,
            'name' => 'Rounded Pocket',
            'parent' => 'pantpockets',
            'designType' => 'pant',
            'description' => 'Rounded Pocket',
            'class_name' => 'suit-icon-Pant_Rounded_Pocket',
            'price' => 3.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 10,
            'name' => 'Diagonal Pocket',
            'parent' => 'pantpockets',
            'designType' => 'pant',
            'description' => 'Diagonal Pocket',
            'class_name' => 'suit-icon-Pant_No_Button',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 10,
            'name' => 'Vertical Pocket',
            'parent' => 'pantpockets',
            'designType' => 'pant',
            'description' => 'Vertical Pocket',
            'class_name' => 'suit-icon-Pant_Vertical_Pocket',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        //style 5
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 11,
            'name' => 'No Cuffs',
            'parent' => 'pantcuffs',
            'designType' => 'pant',
            'description' => 'No Cuffs',
            'class_name' => 'suit-icon-Pant_No_Pant_Cuffs',
            'price' => 0.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 11,
            'name' => 'Traditional Cuffs',
            'parent' => 'pantcuffs',
            'designType' => 'pant',
            'description' => 'Traditional Cuffs',
            'class_name' => 'suit-icon-With_Pant_Cuffs',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 2,
        ]);

        //vest style
        //style 1
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 12,
            'name' => 'Single Breasted 3 Buttons',
            'parent' => 'veststyle',
            'designType' => 'vest',
            'description' => 'Single Breasted 3 Buttons',
            'class_name' => 'suit-icon-Vest_style_main',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 12,
            'name' => 'Single Breasted 4 Buttons',
            'parent' => 'veststyle',
            'designType' => 'vest',
            'description' => 'Single Breasted 4 Buttons',
            'class_name' => 'suit-icon-Vest_Single_breasted_4_buttons',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 12,
            'name' => 'Single Breasted 5 Buttons',
            'parent' => 'veststyle',
            'designType' => 'vest',
            'description' => 'Single Breasted 5 Buttons',
            'class_name' => 'suit-icon-Vest_Single_breasted_5_buttons',
            'price' => 8.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 12,
            'name' => 'Single Breasted 6 Buttons',
            'parent' => 'veststyle',
            'designType' => 'vest',
            'description' => 'Single Breasted 6 Buttons',
            'class_name' => 'suit-icon-Vest_Single_Breasted_6_buttons',
            'price' => 9.00,
            'status' => 1,
            'order_id' => 4,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 12,
            'name' => 'Double Breasted 4 Buttons',
            'parent' => 'veststyle',
            'designType' => 'vest',
            'description' => 'Double Breasted 4 Buttons',
            'class_name' => 'suit-icon-Vest_Double_breasted',
            'price' => 10.00,
            'status' => 1,
            'order_id' => 5,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 12,
            'name' => 'Double Breasted 6 Buttons',
            'parent' => 'veststyle',
            'designType' => 'vest',
            'description' => 'Double Breasted 6 Buttons',
            'class_name' => 'suit-icon-Vest_Double_breasted_6_buttons',
            'price' => 12.00,
            'status' => 1,
            'order_id' => 6,
        ]);
        //style 2
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 13,
            'name' => 'No Lapel',
            'parent' => 'vestlapel',
            'designType' => 'vest',
            'description' => 'No Lapel',
            'class_name' => 'suit-icon-Vest_v_shape',
            'price' => 0.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 13,
            'name' => 'Notch',
            'parent' => 'vestlapel',
            'designType' => 'vest',
            'description' => 'Notch',
            'class_name' => 'suit-icon-Vest_Notched',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 13,
            'name' => 'Peak',
            'parent' => 'vestlapel',
            'designType' => 'vest',
            'description' => 'Peak',
            'class_name' => 'suit-icon-Vest_Peak',
            'price' => 6.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 13,
            'name' => 'Shawl',
            'parent' => 'vestlapel',
            'designType' => 'vest',
            'description' => 'Shawl',
            'class_name' => 'suit-icon-Vest_shawl',
            'price' => 6.00,
            'status' => 1,
            'order_id' => 4,
        ]);
        //style 3
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 14,
            'name' => 'No Pocket',
            'parent' => 'vestpockets',
            'designType' => 'vest',
            'description' => 'No Pocket',
            'class_name' => 'suit-icon-No_Pockets',
            'price' => 0.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 14,
            'name' => 'Flap Pocket',
            'parent' => 'vestpockets',
            'designType' => 'vest',
            'description' => 'Flap Pocket',
            'class_name' => 'suit-icon-With_Flap',
            'price' => 2.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 14,
            'name' => 'Welted Pocket',
            'parent' => 'vestpockets',
            'designType' => 'vest',
            'description' => 'Welted Pocket',
            'class_name' => 'suit-icon-Yes',
            'price' => 3.00,
            'status' => 1,
            'order_id' => 3,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 14,
            'name' => 'Double welted pocket',
            'parent' => 'vestpockets',
            'designType' => 'vest',
            'description' => 'Double welted pocket',
            'class_name' => 'suit-icon-Double_Welted',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 4,
        ]);
        //style 4
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 15,
            'name' => 'Breast Pocket',
            'parent' => 'vestbreastpocket',
            'designType' => 'vest',
            'description' => 'Breast Pocket',
            'class_name' => 'suit-icon-Vest_Breast_Pocket_Yes',
            'price' => 5.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 15,
            'name' => 'Without Breast Pocket',
            'parent' => 'vestbreastpocket',
            'designType' => 'vest',
            'description' => 'Without Breast Pocket',
            'class_name' => 'suit-icon-Vest_Breast_Pocket_No',
            'price' => 0.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        //style 5
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 16,
            'name' => 'Straight',
            'parent' => 'vestedge',
            'designType' => 'vest',
            'description' => 'Straight',
            'class_name' => 'suit-icon-Vest_Straight',
            'price' => 2.00,
            'status' => 1,
            'order_id' => 1,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 16,
            'name' => 'Diagonal',
            'parent' => 'vestedge',
            'designType' => 'vest',
            'description' => 'Diagonal',
            'class_name' => 'suit-icon-Vest_Diagonal',
            'price' => 3.00,
            'status' => 1,
            'order_id' => 2,
        ]);
        \DB::table('suit_style_attributes')->insert([
            'style_id' => 16,
            'name' => 'Rounded',
            'parent' => 'vestedge',
            'designType' => 'vest',
            'description' => 'Rounded',
            'class_name' => 'suit-icon-Vest_Rounded',
            'price' => 4.00,
            'status' => 1,
            'order_id' => 3,
        ]);

    }
}
