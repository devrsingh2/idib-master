<?php
/**
 * Created by PhpStorm.
 * User: rameshkumar
 * Date: 16/3/20
 * Time: 10:38 PM
 */

namespace App\Helpers;

/*use OhMyBrew\ShopifyApp\Models\tool\ShirtAccentElbowpatche;
use OhMyBrew\ShopifyApp\Models\tool\ShirtCuff;
use OhMyBrew\ShopifyApp\Models\tool\ShirtFit;
use OhMyBrew\ShopifyApp\Models\tool\ShirtPlacket;
use OhMyBrew\ShopifyApp\Models\tool\ShirtPocket;
use OhMyBrew\ShopifyApp\Models\tool\ShirtSleeve;
use OhMyBrew\ShopifyApp\Models\tool\ShirtStyle;*/

class GlowMaskShirtImageGenerator
{

    public static function ShirtImageGenerator($id, $fileName, $destination)
    {

        $fabric_thumb_name = $fileName;
        // color image creation start //
        $fabric_id = $id;

        // $homepath = $this->shirtHelper->getToolBasePath().'men/';
        $homepath = $destination;
        //================  Shirt Image Generator START ================================

        $fabricThumbImgpath = $homepath .'/'. $fabric_thumb_name;

        $fabricName = $fabric_id . "_fabric_main.png";
        $fabric_0 = base_path() . '/customize/shirt/media/men/fabric_images/' . $fabricName;
        //back
        $fabricName_90 = $fabric_id . "_fabric_main_90.png";
        $fabric_90 = base_path() . '/customize/shirt/media/men/fabric_images/' . $fabricName_90;

        //for zoom view
        $fabric_zoom = base_path() . '/customize/shirt/media/men/fabric_images/' . $fabric_id . '_fabric_zoom.png';
        $shirtFabImgPath = base_path() . '/customize/shirt/media/men/fabric_images/';

        $fabric_double = base_path() . '/customize/shirt/media/men/fabric_images/' . $fabric_id . '_fabric_double.png';
        //created for sleeve
        $fabricName_wave_left = $fabric_id . "_fabric_wave_left.png";
        $fabricName_wave_right = $fabric_id . "_fabric_wave_right.png";
        $fabric_cuff_side = $fabric_id . "_fabric_cuff_side.png";


        $fabric_side_view = base_path() . '/customize/shirt/media/men/fabric_images/' . $fabric_id . "_fabric_side_view.png";
        $wave_left = base_path() . '/customize/shirt/media/men/fabric_images/' . $fabricName_wave_left;
        $wave_right = base_path() . '/customize/shirt/media/men/fabric_images/' . $fabricName_wave_right;

        exec('convert ' . $fabricThumbImgpath . ' -rotate 90 ' . $fabric_90);
        exec('convert -size 1080x1320 tile:' . $fabric_90 . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png');
        exec('convert -size 1080x1320 tile:' . $fabricThumbImgpath . ' ' . $fabric_0);
        exec('convert -size 2160x2640 tile:' . $fabricThumbImgpath . ' ' . $fabric_double);

        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -5 ' . $wave_left);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 5 ' . $wave_right);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -3 ' . $fabric_side_view);

        //created for collar
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 80 ' . $shirtFabImgPath . $fabric_id . '_fabric_cuff_side.png');

        //zoom view fabirc
        exec('convert -size 1200x900 tile:' . $fabricThumbImgpath . ' ' . $fabric_zoom);
        //created for collar
        exec('convert ' . $fabric_zoom . ' -background "rgba(0,0,0,0.5)" -distort SRT 90 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back_zoom.png');
        // END create fabric image //

        // Create plain fabric image //
        // base collar rotate fabric
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png');
        //roate fabric image
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png');



        // Shirt Cuff Image Generation Start //
        $rows_cuff = ShirtCuff::where('status', 1)->get();
        $cuff_id = 1;
        $style_type = 1;
        $cuff_size = '';
        $cuff_type = '';

        $contrast_cuff_left_glow = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Cuffs/FoldedOuterCuff_left_shad.png';
        $contrast_cuff_left_mask = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Cuffs/FoldedOuterCuff_left_mask.png';
        $contrast_cuff_left_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Cuffs/FoldedOuterCuff_left_hi.png';
        $contrast_cuff_right_glow = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Cuffs/FoldedOuterCuff_right_shad.png';
        $contrast_cuff_right_mask = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Cuffs/FoldedOuterCuff_right_mask.png';
        $contrast_cuff_right_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Cuffs/FoldedOuterCuff_right_hi.png';

        $cmd = 'composite -compose Dst_In -gravity center ' . $contrast_cuff_left_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_left_view_4.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_left_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_left_view_4.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_left_view_4.png ' . $contrast_cuff_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_left_view_4.png';
        exec($cmd);

        $cmd = 'composite ' . $contrast_cuff_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cufftype_' . $cuff_id . '_left_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cufftype_' . $cuff_id . '_left_view_4.png';
        exec($cmd);

        $cmd = 'composite -compose Dst_In -gravity center ' . $contrast_cuff_right_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png ' . $contrast_cuff_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png';
        exec($cmd);

        $cmd = 'composite ' . $contrast_cuff_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_left_view_4.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_final_back_cuff.png';
        exec($cmd);
        /*exec($cmd);*/


        $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_right_view_4.png';
        exec($cmd);
        /*exec($cmd);*/


        $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_contrast_outer_cuff_' . $cuff_type . '_' . $cuff_id . '_left_view_4.png';
        exec($cmd);
        /*exec($cmd);*/


        //Cuff Contrast END
        //open cuff images
        $opencuff_left_glow = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Front/Casualcuff_Front_left_shad.png';
        $opencuff_left_mask = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Front/Casualcuff_Front_left_mask.png';
        $opencuff_left_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Front/Casualcuff_Front_left_hi.png';
        $opencuff_right_glow = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Front/Casualcuff_Front_right_shad.png';
        $opencuff_right_mask = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Front/Casualcuff_Front_right_mask.png';
        $opencuff_right_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Front/Casualcuff_Front_right_hi.png';

        $cmd = 'composite -compose Dst_In -gravity center ' . $opencuff_left_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
        exec($cmd);
        /*exec($cmd);*/

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
        exec($cmd);
        /*exec($cmd);*/

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png ' . $opencuff_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
        exec($cmd);
        /*exec($cmd);*/

        //highlight
        $cmd = 'composite ' . $opencuff_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cufftype_' . $cuff_id . '_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cufftype_' . $cuff_id . '_left_view_1.png';
        exec($cmd);

        $cmd = 'composite -compose Dst_In -gravity center ' . $opencuff_right_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png ' . $opencuff_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
        exec($cmd);

        //highlight
        $cmd = 'composite ' . $opencuff_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
        exec($cmd);

        //combine
        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_final_front_cuff.png';
        exec($cmd);

        $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
        exec($cmd);

        $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
        exec($cmd);

        $opencuff_side_left_glow = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Side/CasualCuff_Side_left_shad.png';
        $opencuff_side_left_mask = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Side/CasualCuff_Side_left_mask.png';
        $opencuff_side_left_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Side/CasualCuff_Side_left_hi.png';
        $opencuff_side_right_glow = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Side/CasualCuff_Side_right_shad.png';
        $opencuff_side_right_mask = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Side/CasualCuff_Side_right_mask.png';
        $opencuff_side_right_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Side/CasualCuff_Side_right_hi.png';

        $cmd = 'composite -compose Dst_In -gravity center ' . $opencuff_side_left_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png ' . $opencuff_side_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png';
        exec($cmd);

        //highlight
        $cmd = 'composite ' . $opencuff_side_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cufftype_' . $cuff_id . '_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cufftype_' . $cuff_id . '_left_view_2.png';
        exec($cmd);

        $cmd = 'composite -compose Dst_In -gravity center ' . $opencuff_side_right_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png ' . $opencuff_side_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
        exec($cmd);

        //highlight
        $cmd = 'composite ' . $opencuff_side_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
        exec($cmd);

        //combine
        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_final_side_cuff.png';
        exec($cmd);

        $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
        exec($cmd);

        $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png';
        exec($cmd);

        $opencuff_back_left_glow = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Back/CasualCuffs_Back_Left_shad.png';
        $opencuff_back_left_mask = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Back/CasualCuffs_Back_Left_mask.png';
        $opencuff_back_left_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Back/CasualCuffs_Back_Left_hi.png';
        $opencuff_back_right_glow = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Back/CasualCuffs_Back_Right_shad.png';
        $opencuff_back_right_mask = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Back/CasualCuffs_Back_Right_mask.png';
        $opencuff_back_right_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Open_Cuffs/Back/CasualCuffs_Back_Right_hi.png';

        $cmd = 'composite -compose Dst_In -gravity center ' . $opencuff_back_left_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png ' . $opencuff_back_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
        exec($cmd);

        //highlight
        $cmd = 'composite ' . $opencuff_back_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
        exec($cmd);

        $cmd = 'composite -compose Dst_In -gravity center ' . $opencuff_back_right_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
        exec($cmd);

        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png ' . $opencuff_back_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
        exec($cmd);

        //highlight
        $cmd = 'composite ' . $opencuff_back_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
        exec($cmd);

        //combine
        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_final_back_cuff.png';
        exec($cmd);

        $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
        exec($cmd);

        $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_opencuff_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
        exec($cmd);

        foreach ($rows_cuff as $cuffs) {
            $cuff_id = $cuffs->id;
            $style_type = $cuffs->type;
            $cuff_size = '';
            $cuff_type = '';
            if ($cuff_id == 14) {

                $cuff_left_glow = base_path() . '/customize/shirt/media/men/' . $cuffs->glow_front_left_image;
                $cuff_left_mask = base_path() . '/customize/shirt/media/men/' . $cuffs->mask_front_left_image;
                $cuff_left_highlighted = base_path() . '/customize/shirt/media/men/' . $cuffs->highlighted_front_left_image;
                $cuff_right_glow = base_path() . '/customize/shirt/media/men/' . $cuffs->glow_front_right_image;
                $cuff_right_mask = base_path() . '/customize/shirt/media/men/' . $cuffs->mask_front_right_image;
                $cuff_right_highlighted = base_path() . '/customize/shirt/media/men/' . $cuffs->highlighted_front_right_image;

                //view 1
                if ($cuffs->glow_front_left_image != '' && $cuffs->mask_front_left_image != '') {

                    $cmd = 'composite -compose Dst_In -gravity center ' . $cuff_left_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png ' . $cuff_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
                    exec($cmd);
                    //highlight
                    $cmd = 'composite ' . $cuff_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
                    exec($cmd);

                    $cmd = 'composite -compose Dst_In -gravity center ' . $cuff_right_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png ' . $cuff_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
                    exec($cmd);
                    //highlight
                    $cmd = 'composite ' . $cuff_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
                    exec($cmd);
                    //combine
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_1.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_1.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_1.png';
                    exec($cmd);
                }

                //view 2
                $cuff_side_left_glow = base_path() . '/customize/shirt/media/men/' . $cuffs->glow_side_left_image;
                $cuff_side_left_mask = base_path() . '/customize/shirt/media/men/' . $cuffs->mask_side_left_image;
                $cuff_side_left_highlighted = base_path() . '/customize/shirt/media/men/' . $cuffs->highlighted_side_left_image;
                $cuff_side_right_glow = base_path() . '/customize/shirt/media/men/' . $cuffs->glow_side_right_image;
                $cuff_side_right_mask = base_path() . '/customize/shirt/media/men/' . $cuffs->mask_side_right_image;
                $cuff_side_right_highlighted = base_path() . '/customize/shirt/media/men/' . $cuffs->highlighted_side_right_image;

                if ($cuffs->glow_side_left_image != '' && $cuffs->mask_side_left_image != '') {
                    $cmd = 'composite -compose Dst_In -gravity center ' . $cuff_side_left_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png ' . $cuff_side_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png';
                    exec($cmd);
                    //highlight
                    $cmd = 'composite ' . $cuff_side_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cufftype_' . $cuff_id . '_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cufftype_' . $cuff_id . '_left_view_2.png';
                    exec($cmd);

                    $cmd = 'composite -compose Dst_In -gravity center ' . $cuff_side_right_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png ' . $cuff_side_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
                    exec($cmd);
                    //highlight
                    $cmd = 'composite ' . $cuff_side_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
                    exec($cmd);
                    //combine
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_2.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_2.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_2.png';
                    exec($cmd);
                }

                //view 3
                $cuff_back_left_glow = base_path() . '/customize/shirt/media/men/' . $cuffs->glow_back_left_image;
                $cuff_back_left_mask = base_path() . '/customize/shirt/media/men/' . $cuffs->mask_back_left_image;
                $cuff_back_left_highlighted = base_path() . '/customize/shirt/media/men/' . $cuffs->highlighted_back_left_image;
                $cuff_back_right_glow = base_path() . '/customize/shirt/media/men/' . $cuffs->glow_back_right_image;
                $cuff_back_right_mask = base_path() . '/customize/shirt/media/men/' . $cuffs->mask_back_right_image;
                $cuff_back_right_highlighted = base_path() . '/customize/shirt/media/men/' . $cuffs->highlighted_back_right_image;

                if ($cuffs->glow_back_left_image != '' && $cuffs->mask_back_left_image != '') {

                    $cmd = 'composite -compose Dst_In -gravity center ' . $cuff_back_left_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png ' . $cuff_back_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
                    exec($cmd);
                    //highlight
                    $cmd = 'composite ' . $cuff_back_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
                    exec($cmd);

                    $cmd = 'composite -compose Dst_In -gravity center ' . $cuff_back_right_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png ' . $cuff_back_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
                    exec($cmd);
                    //highlight
                    $cmd = 'composite ' . $cuff_back_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
                    exec($cmd);
                    //combine
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_3.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_right_view_3.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_left_view_3.png';
                    exec($cmd);
                }

                //view 4
                $cuff_fold_main_glow = base_path() . '/customize/shirt/media/men/' . $cuffs->glow_fold_main_image;
                $cuff_fold_main_mask = base_path() . '/customize/shirt/media/men/' . $cuffs->mask_fold_main_image;
                $cuff_fold_main_highlighted = base_path() . '/customize/shirt/media/men/' . $cuffs->highlighted_fold_main_image;

                $inner_fold_inner_glow = base_path() . '/customize/shirt/media/men/' . $cuffs->glow_fold_inner_image;
                $inner_fold_inner_mask = base_path() . '/customize/shirt/media/men/' . $cuffs->mask_fold_inner_image;
                $inner_fold_inner_highlighted = base_path() . '/customize/shirt/media/men/' . $cuffs->highlighted_fold_inner_image;

                if ($cuffs->mask_fold_main_image != '' && $cuffs->mask_fold_inner_image != '') {

                    $cmd = 'composite -compose Dst_In -gravity center ' . $cuff_fold_main_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_4.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_4.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_4.png ' . $cuff_fold_main_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_4.png';
                    exec($cmd);
                    //highlight
                    $cmd = 'composite ' . $cuff_fold_main_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_cufftype_' . $cuff_type . '_' . $cuff_id . '_view_4.png';
                    exec($cmd);
                    //inner
                    $cmd = 'composite -compose Dst_In -gravity center ' . $inner_fold_inner_mask . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_inner_' . $cuff_type . '_' . $cuff_id . '_inner_view_4.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_inner_' . $cuff_type . '_' . $cuff_id . '_inner_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_inner_' . $cuff_type . '_' . $cuff_id . '_inner_view_4.png';
                    exec($cmd);

                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_inner_' . $cuff_type . '_' . $cuff_id . '_inner_view_4.png ' . $inner_fold_inner_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_inner_' . $cuff_type . '_' . $cuff_id . '_inner_view_4.png';
                    exec($cmd);
                    //highlight
                    $cmd = 'composite ' . $inner_fold_inner_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_inner_' . $cuff_type . '_' . $cuff_id . '_inner_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/cuffs/' . $fabric_id . '_cuffstyle_' . $style_type . '_size_' . $cuff_size . '_inner_' . $cuff_type . '_' . $cuff_id . '_inner_view_4.png';
                    exec($cmd);
                }
            }
        }
        // Shirt Cuff Image Generation End //


        /* Shirt Collar Image Generation Start */

        $rows = ShirtStyle::where('status', 1)->get();
        foreach ($rows as $style){
            $style_id = $style->id;

            // collar base for folded view.
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/collar_base/Left_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_left_front_view_4.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_left_front_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_left_front_view_4.png';
            exec($cmd);
            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_left_front_view_4.png  ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/collar_base/Left_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_left_front_view_4.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/collar_base/Left_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_collar_new_front_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_left_front_view_4.png';
            exec($cmd);

            // right side
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/collar_base/right_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png';
            exec($cmd);
            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png  ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/collar_base/right_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/collar_base/right_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_left_front_view_4.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_front_view_4.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_right_front_view_4.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/collar_base/' . $fabric_id . '_style_' . $style_id . '_left_front_view_4.png';
            exec($cmd);

            /* view 1 start */

            // //step-1: back-collar
            // //step 3: Front
            // //mask  image

            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Styles/BackCollar_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png  ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Styles/BackCollar_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Styles/BackCollar_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png';
            exec($cmd);
            // back-part
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Styles/BackPart_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_backpart_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_backpart_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_backpart_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_backpart_view_1.png  ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Styles/BackPart_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_backpart_view_1.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Styles/BackPart_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_backpart_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_front_backpart_view_1.png';
            exec($cmd);
            // //step-1: side view
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Side_View/Collar_Styles/BackCollar_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);
            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png  ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Side_View/Collar_Styles/BackCollar_shad.png ' . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Side_View/Collar_Styles/BackCollar_hi.png ' . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png';
            exec($cmd);
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Side_View/Collar_Styles/BackPart_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_sidepart_view_2.png';
            exec($cmd);
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_sidepart_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_sidepart_view_2.png';
            exec($cmd);
            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_sidepart_view_2.png  ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Side_View/Collar_Styles/BackPart_shad.png ' . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_sidepart_view_2.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Side_View/Collar_Styles/BackPart_hi.png ' . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_sidepart_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_left_sidepart_view_2.png';
            exec($cmd);

            // collar casual back part..

            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Casual/back_part/BackCollar_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_front_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_front_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_front_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_front_view_1.png  ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Casual/back_part/BackCollar_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_front_view_1.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Casual/back_part/BackCollar_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_front_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_front_view_1.png';
            exec($cmd);

            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Casual/back_part/BackPart_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_left_sidepart_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_left_sidepart_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_left_sidepart_view_1.png';
            exec($cmd);
            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_left_sidepart_view_1.png  ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Casual/back_part/BackPart_shad.png ' . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_left_sidepart_view_1.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/women_glow_mask_shirt/Front_View/Collar_Casual/back_part/BackPart_hi.png ' . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_left_sidepart_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/back_collar/' . $fabric_id . '_style_' . $style_id . '_casual_left_sidepart_view_1.png';
            exec($cmd);

            $view1_glow_left_image = base_path() . '/customize/shirt/media/men/' . $style->view1_glow_left_image;
            $view1_mask_left_image = base_path() . '/customize/shirt/media/men/' . $style->view1_mask_left_image;
            $view1_highlighted_left_image = base_path() . '/customize/shirt/media/men/' . $style->view1_highlighted_left_image;

            $view1_glow_right_image = base_path() . '/customize/shirt/media/men/' . $style->view1_glow_right_image;
            $view1_mask_right_image = base_path() . '/customize/shirt/media/men/' . $style->view1_mask_right_image;
            $view1_highlighted_right_image = base_path() . '/customize/shirt/media/men/' . $style->view1_highlighted_right_image;

            $view2_glow_left_image = base_path() . '/customize/shirt/media/men/' . $style->view2_glow_left_image;
            $view2_mask_left_image = base_path() . '/customize/shirt/media/men/' . $style->view2_mask_left_image;
            $view2_highlighted_left_image = base_path() . '/customize/shirt/media/men/' . $style->view2_highlighted_left_image;

            $view2_glow_right_image = base_path() . '/customize/shirt/media/men/' . $style->view2_glow_right_image;
            $view2_mask_right_image = base_path() . '/customize/shirt/media/men/' . $style->view2_mask_right_image;
            $view2_highlighted_right_image = base_path() . '/customize/shirt/media/men/' . $style->view2_highlighted_right_image;

            $view4_glow_left_image = base_path() . '/customize/shirt/media/men/' . $style->view4_glow_left_image;
            $view4_mask_left_image = base_path() . '/customize/shirt/media/men/' . $style->view4_mask_left_image;
            $view4_highlighted_left_image = base_path() . '/customize/shirt/media/men/' . $style->view4_highlighted_left_image;

            $view4_glow_right_image = base_path() . '/customize/shirt/media/men/' . $style->view4_glow_right_image;
            $view4_mask_right_image = base_path() . '/customize/shirt/media/men/' . $style->view4_mask_right_image;
            $view4_highlighted_right_image = base_path() . '/customize/shirt/media/men/' . $style->view4_highlighted_right_image;

            $view4_glow_inner_image = base_path() . '/customize/shirt/media/men/' . $style->view4_glow_inner_image;
            $view4_mask_inner_image = base_path() . '/customize/shirt/media/men/' . $style->view4_mask_inner_image;
            $view4_highlighted_inner_image = base_path() . '/customize/shirt/media/men/' . $style->view4_highlighted_inner_image;

            $view5_glow_left_image = base_path() . '/customize/shirt/media/men/' . $style->view5_glow_left_image;
            $view5_mask_left_image = base_path() . '/customize/shirt/media/men/' . $style->view5_mask_left_image;
            $view5_highlighted_left_image = base_path() . '/customize/shirt/media/men/' . $style->view5_highlighted_left_image;

            $view5_glow_right_image = base_path() . '/customize/shirt/media/men/' . $style->view5_glow_right_image;
            $view5_mask_right_image = base_path() . '/customize/shirt/media/men/' . $style->view5_mask_right_image;
            $view5_highlighted_right_image = base_path() . '/customize/shirt/media/men/' . $style->view5_highlighted_right_image;

            $view5_glow_inner_image = base_path() . '/customize/shirt/media/men/' . $style->view5_glow_inner_image;
            $view5_mask_inner_image = base_path() . '/customize/shirt/media/men/' . $style->view5_mask_inner_image;
            $view5_highlighted_inner_image = base_path() . '/customize/shirt/media/men/' . $style->view5_highlighted_inner_image;

            //step-1: left
            //roate fabric image
            $cmd = 'convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png';
            exec($cmd);

            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view1_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png  ' . $view1_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . $view1_highlighted_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png';
            exec($cmd);

            //step-2: right
            //roate fabric image
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view1_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png  ' . $view1_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . $view1_highlighted_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png';
            exec($cmd);

            //Combine
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_1.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png';
            exec($cmd);

            //step 3: Front
            //mask  image
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Styles/Commonpart_Front_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png  ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Styles/Commonpart_Front_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Styles/Commonpart_Front_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png';
            exec($cmd);

            //step 5: back
            //fabric image
            //mask image
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Styles/Shirt_Commoncollar_Back_Mask.png  ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back_wave.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_1.png ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Styles/Shirt_Commoncollar_Back_Shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_1.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Styles/Shirt_Commoncollar_Back_Hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_1.png';
            exec($cmd);

            //step 4: compose all images
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_1.png  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_1.png  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_1.png';
            exec($cmd);

            /* view 1 end */

            /* view 2 start */
            //step-1: left
            //roate fabric image
            $cmd = 'convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png';
            exec($cmd);
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view2_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);
            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png  ' . $view2_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . $view2_highlighted_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);

            //step-2: right
            //roate fabric image
            $cmd = 'convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png';
            exec($cmd);
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view2_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png  ' . $view2_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . $view2_highlighted_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png';
            exec($cmd);

            //Combine
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_2.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png';
            exec($cmd);

            //step 3: Front
            //mask  image
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Styles/Commonpart_Side_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_2.png  ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Styles/Commonpart_Side_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_2.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Styles/Commonpart_Side_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_2.png';
            exec($cmd);

            //step 5: back
            //fabric image
            $cmd = 'convert ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -wave 10x300 -gravity South -chop 0x10 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back_wave.png';
            exec($cmd);
            //mask image
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Back_View/Collar_Styles/Shirt_Commoncollar_Back_Mask.png  ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back_wave.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_2.png ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Back_View/Collar_Styles/Shirt_Commoncollar_Back_Shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_2.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Back_View/Collar_Styles/Shirt_Commoncollar_Back_Hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_back_view_2.png';
            exec($cmd);

            //step 4: compose all images
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_front_view_2.png  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_2.png  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_2.png';
            exec($cmd);

            /* view 4 start */

            //step-1: left
            //roate fabric image
            $cmd = 'convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png';
            exec($cmd);

            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view4_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png  ' . $view4_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $view4_highlighted_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png';
            exec($cmd);

            //step-2: right
            //roate fabric image
            $cmd = 'convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png';
            exec($cmd);

            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view4_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png  ' . $view4_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $view4_highlighted_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png';
            exec($cmd);

            //Combine
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_4.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png';
            exec($cmd);

            //step 3: common back
            //mask  image
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/Commonbackpart_Folded_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_4.png';
            exec($cmd);
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_4.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_4.png  ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/Commonbackpart_Folded_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_4.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Folded_View/Collar_Styles/Commonbackpart_Folded_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_4.png';
            exec($cmd);

            //inner mask
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Collars/Folded/inner-fabric_mask.png ' . $shirtFabImgPath . 'fabric_' . $fabric_id . '_main.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_inner_view_4.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_inner_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_inner_view_4.png';
            exec($cmd);

            //inner glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_inner_view_4.png  ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Collars/Folded/inner-fabric_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_inner_view_4.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Collars/Folded/inner-fabric_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_inner_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_inner_view_4.png';
            exec($cmd);

            //step 4: compose all images
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_4.png  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_4.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_4.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_4.png  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_4.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_4.png';
            exec($cmd);
            /* view 4 end */
            //close collar end
            //open/casual collar start

            $view1_casual_glow_left_image = base_path() . '/customize/shirt/media/men/' . $style->view1_casual_glow_left_image;
            $view1_casual_mask_left_image = base_path() . '/customize/shirt/media/men/' . $style->view1_casual_mask_left_image;
            $view1_casual_highlighted_left_image = base_path() . '/customize/shirt/media/men/' . $style->view1_casual_highlighted_left_image;

            $view1_casual_glow_right_image = base_path() . '/customize/shirt/media/men/' . $style->view1_casual_glow_right_image;
            $view1_casual_mask_right_image = base_path() . '/customize/shirt/media/men/' . $style->view1_casual_mask_right_image;
            $view1_casual_highlighted_right_image = base_path() . '/customize/shirt/media/men/' . $style->view1_casual_highlighted_right_image;

            $view2_casual_glow_left_image = base_path() . '/customize/shirt/media/men/' . $style->view2_casual_glow_left_image;
            $view2_casual_mask_left_image = base_path() . '/customize/shirt/media/men/' . $style->view2_casual_mask_left_image;
            $view2_casual_highlighted_left_image = base_path() . '/customize/shirt/media/men/' . $style->view2_casual_highlighted_left_image;

            $view2_casual_glow_right_image = base_path() . '/customize/shirt/media/men/' . $style->view2_casual_glow_right_image;
            $view2_casual_mask_right_image = base_path() . '/customize/shirt/media/men/' . $style->view2_casual_mask_right_image;
            $view2_casual_highlighted_right_image = base_path() . '/customize/shirt/media/men/' . $style->view2_casual_highlighted_right_image;


            $commonbase_front_glow_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/CommonBase_Left_shad.png';
            $commonbase_front_mask_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/CommonBase_Left_mask.png';
            $commonbase_front_hi_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/CommonBase_Left_hi.png';
            $commonbase_front_glow_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/CommonBase_Right_shad.png';
            $commonbase_front_mask_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/CommonBase_Right_mask.png';
            $commonbase_front_hi_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/CommonBase_Right_hi.png';

            $commonbase_side_glow_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/CommonBase_Left_shad.png';
            $commonbase_side_mask_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/CommonBase_Left_mask.png';
            $commonbase_side_hi_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/CommonBase_Left_hi.png';
            $commonbase_side_glow_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/CommonBase_Right_shad.png';
            $commonbase_side_mask_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/CommonBase_Right_mask.png';
            $commonbase_side_hi_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/CommonBase_Right_hi.png';


            $inner_contrast_front_glow_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Inner_Collar_Contrast_Left_shad.png';
            $inner_contrast_front_mask_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Inner_Collar_Contrast_Left_mask.png';
            $inner_contrast_front_hi_left_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Inner_Collar_Contrast_Left_hi.png';
            $inner_contrast_front_glow_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Inner_Collar_Contrast_Right_shad.png';
            $inner_contrast_front_mask_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Inner_Collar_Contrast_Right_mask.png';
            $inner_contrast_front_hi_right_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Inner_Collar_Contrast_Right_hi.png';

            $cmd = 'composite -compose Dst_In -gravity center ' . $inner_contrast_front_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png';
            exec($cmd);
            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png  ' . $inner_contrast_front_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $inner_contrast_front_hi_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png';
            exec($cmd);

            $cmd = 'composite -compose Dst_In -gravity center ' . $inner_contrast_front_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png';
            exec($cmd);
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png  ' . $inner_contrast_front_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $inner_contrast_front_hi_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png';
            exec($cmd);

            //combine
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_view_1.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_left_view_1.png';
            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_right_view_1.png';

            $inner_contrast_side_glow_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/Inner_Collar_Contrast_Left_shad.png';
            $inner_contrast_side_mask_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/Inner_Collar_Contrast_Left_mask.png';
            $inner_contrast_side_hi_image = base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/Inner_Collar_Contrast_Left_hi.png';

            $cmd = 'composite -compose Dst_In -gravity center ' . $inner_contrast_side_mask_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_view_2.png  ' . $inner_contrast_side_glow_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_view_2.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $inner_contrast_side_hi_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_inner_view_2.png';
            exec($cmd);

            /* view 1 start */

            //step-1: left
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view1_casual_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png  ' . $view1_casual_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png';
            exec($cmd);
            //highlighted
            $cmd = 'composite ' . $view1_casual_highlighted_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png';
            exec($cmd);

            //step-2: right
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view1_casual_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png';
            exec($cmd);
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png  ' . $view1_casual_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $view1_casual_highlighted_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png';
            exec($cmd);

            //step-1: common left
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $commonbase_front_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png  ' . $commonbase_front_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $commonbase_front_hi_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png';
            exec($cmd);

            //step-2: common right
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $commonbase_front_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png  ' . $commonbase_front_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $commonbase_front_hi_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png';
            exec($cmd);

            //step-2: common torso
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Torso_Bust/Casual-Bust_Front_Torso_mask.png ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png  ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Torso_Bust/Casual-Bust_Front_Torso_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Front_View/Collar_Casual/Torso_Bust/Casual-Bust_Front_Torso_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png';
            exec($cmd);

            //step-2: compose all images
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_1.png  -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_1.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_1.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_1.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_placket_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_1.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_1.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_1.png';
            exec($cmd);

            /* view 1 end */

            /* view 2 start */
            //step-1: left
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view2_casual_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png  ' . $view2_casual_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $view2_casual_highlighted_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png';
            exec($cmd);

            //step-2: right
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $view2_casual_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png  ' . $view2_casual_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $view2_casual_highlighted_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png';
            exec($cmd);

            //step-1: common left
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $commonbase_side_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png  ' . $commonbase_side_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $commonbase_side_hi_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png';
            exec($cmd);


            //step-2: common right
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $commonbase_side_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png  ' . $commonbase_side_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $commonbase_side_hi_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png';
            exec($cmd);

            //step-2: common torso
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/Torso_Bust/Casual-Bust_Side_Torso_mask.png ' . $fabric_side_view . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png  ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/Torso_Bust/Casual-Bust_Side_Torso_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/Torso_Bust/Casual-Bust_Side_Torso_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png';
            exec($cmd);

            //step-2: common placket
            //mask
            // $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/Placket/Casual-Bust_Side_Placket_mask.png ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_placket_view_2.png';
            exec($cmd);

            //view 5 start
            //roate fabric imaged
            $cmd = 'convert ' . $fabric_double . ' -background "rgba(0,0,0,0.5)" -distort SRT 45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left_zoom.png';
            exec($cmd);

            $cmd = 'convert ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left_zoom.png -gravity center -crop 1080x1320+0+0 +repage ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left_zoom.png';
            exec($cmd);

            //mask
            $cmd = 'composite -compose CopyOpacity ' . $view5_mask_left_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left_zoom.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_5.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_5.png  ' . $view5_glow_left_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_5.png';
            exec($cmd);


            //highlighted
            $cmd = 'composite ' . $view5_highlighted_left_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_5.png';
            exec($cmd);

            //step-2: right
            //roate fabric image
            $cmd = 'convert ' . $fabric_double . ' -background "rgba(0,0,0,0.5)" -distort SRT -45 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right_zoom.png';
            exec($cmd);

            $cmd = 'convert ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right_zoom.png -gravity center -crop 1080x1320+0+0 +repage ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right_zoom.png';
            exec($cmd);

            //mask
            $cmd = 'composite -compose CopyOpacity ' . $view5_mask_right_image . ' ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right_zoom.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_5.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_5.png  ' . $view5_glow_right_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_5.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . $view5_highlighted_right_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_5.png';
            exec($cmd);

            //mask image
            $cmd = 'composite -compose CopyOpacity ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Back_Mask.png  ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back_zoom.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_5.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_5.png ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Back_Shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_5.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Back_Hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_back_view_5.png';
            exec($cmd);

            $cmd = 'convert ' . $fabric_zoom . ' -background "rgba(0,0,0,0.5)" -distort SRT 80 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left_basecollar.png';
            exec($cmd);

            $cmd = 'convert ' . $fabric_zoom . ' -background "rgba(0,0,0,0.5)" -distort SRT -80 ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right_basecollar.png';
            exec($cmd);

            //left
            $cmd = 'composite -compose CopyOpacity ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Left_Mask.png  ' . $shirtFabImgPath . $fabric_id . '_fabric_main_left_basecollar.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerLeft_view_5.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerLeft_view_5.png ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Left_Shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerLeft_view_5.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Left_Hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerLeft_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerLeft_view_5.png';
            exec($cmd);

            //right
            $cmd = 'composite -compose CopyOpacity ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Right_Mask.png  ' . $shirtFabImgPath . $fabric_id . '_fabric_main_right_basecollar.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerRight_view_5.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerRight_view_5.png ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Right_Shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerRight_view_5.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/Collar_Styles/CollarBase_Right_Hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerRight_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerRight_view_5.png';
            exec($cmd);

            //innner combine
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerLeft_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerRight_view_5.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninner_view_5.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerRight_view_5.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninnerLeft_view_5.png';
            exec($cmd);

            //inner collar end
            //step 4: compose all images
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_5.png  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_5.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_5.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_commoninner_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_5.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_view_5.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_right_view_5.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_' . $style_id . '_left_view_5.png';
            exec($cmd);

            /* view 5 end */

            //step-2: compose all images
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_2.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_left_view_2.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_right_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_2.png  -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_collar_view_2.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_left_view_2.png';
            exec($cmd);

            $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_right_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_' . $style_id . '_casual_common_placket_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/casual/' . $fabric_id . '_style_casual_common_torso_view_2.png';
            exec($cmd);
        }
        /* Shirt Collar Image Generation End */

        /* view 3 start */
//step 5: back
//fabric image
//mask image
        $cmd = 'composite -compose Dst_In -gravity center ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Back_View/Collar_Styles/Shirt_Commoncollar_Back_Mask.png  ' . $shirtFabImgPath . $fabric_id . '_fabric_main_back.png -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_view_3.png';
        exec($cmd);
        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_view_3.png';
        exec($cmd);

//glow image
        $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_view_3.png ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Back_View/Collar_Styles/Shirt_Commoncollar_Back_Shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_view_3.png';
        exec($cmd);
//highlighted
        $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Back_View/Collar_Styles/Shirt_Commoncollar_Back_Hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/collarstyle/' . $fabric_id . '_style_view_3.png';
        exec($cmd);

        /* Shirt Placket Image Generation Start */
        $rows_plackets = ShirtPlacket::where('status', 1)->get();
        foreach ($rows_plackets as $plackets){

            $shirtplackets_id = $plackets['id'];

            // casual view side placket.
            $casual_mask_side_image = base_path()."/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/casual_side_placket/Shirt_Placket_Side_mask.png";
            $casual_shad_side_image = base_path()."/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/casual_side_placket/Shirt_Placket_Side_shad.png";
            $casual_hi_side_view = base_path()."/customize/shirt/media/men/glow_mask_shirt/Side_View/Collar_Casual/casual_side_placket/Shirt_Placket_Side_hi.png";

            $cmd = 'composite -compose Dst_In -gravity center ' . $casual_mask_side_image . ' ' . $fabric_side_view . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_casual_plackets_' . $shirtplackets_id . '_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_casual_plackets_' . $shirtplackets_id . '_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_casual_plackets_' . $shirtplackets_id . '_view_2.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_casual_plackets_' . $shirtplackets_id . '_view_2.png ' . $casual_shad_side_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_casual_plackets_' . $shirtplackets_id . '_view_2.png';
            exec($cmd);

            //highlight
            $cmd = 'composite ' . $casual_hi_side_view . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_casual_plackets_' . $shirtplackets_id . '_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_casual_plackets_' . $shirtplackets_id . '_view_2.png';
            exec($cmd);

            $plackets_glow = base_path() . '/customize/shirt/media/men/' . $plackets['glow_front_image'];
            $plackets_mask = base_path() . '/customize/shirt/media/men/' . $plackets['mask_front_image'];
            $plackets_highlighted = base_path() . '/customize/shirt/media/men/' . $plackets['highlighted_front_image'];
            //mask image
            $cmd = 'composite -compose CopyOpacity ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/plackets/Placket_mask.png ' . $shirtFabImgPath . $fabric_id . '_fabric_zoom.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_5.png';
            exec($cmd);

            //glow image
            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_5.png ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/plackets/Placket_shad.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_5.png';
            exec($cmd);

            //highlighted
            $cmd = 'composite ' . base_path() . '/customize/shirt/media/men/glow_mask_shirt/Zoom_View/plackets/Placket_hi.png -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_5.png';
            exec($cmd);

            //end

            if ($plackets_glow != '' && $plackets_mask != '') {
                $cmd = 'composite -compose Dst_In -gravity center ' . $plackets_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_1.png ' . $plackets_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_1.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $plackets_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_1.png';
                exec($cmd);

            }

            $glow_side_image = base_path() . '/customize/shirt/media/men/' . $plackets['glow_side_image'];
            $mask_side_image = base_path() . '/customize/shirt/media/men/' . $plackets['mask_side_image'];
            $highlighted_side_image = base_path() . '/customize/shirt/media/men/' . $plackets['highlighted_side_image'];

            if ($glow_side_image != '' && $mask_side_image != '') {
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_side_image . ' ' . $fabric_side_view . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_2.png ' . $glow_side_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_2.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $highlighted_side_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_2.png';
                exec($cmd);

            }

            $glow_fold_image = base_path() . '/customize/shirt/media/men/' . $plackets['glow_fold_image'];
            $mask_fold_image = base_path() . '/customize/shirt/media/men/' . $plackets['mask_fold_image'];
            $highlighted_fold_image = base_path() . '/customize/shirt/media/men/' . $plackets['highlighted_fold_image'];

            if ($glow_fold_image != '' && $mask_fold_image != '') {
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_fold_image . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_4.png ' . $glow_fold_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_4.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $highlighted_fold_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/plackets/' . $fabric_id . '_plackets_' . $shirtplackets_id . '_view_4.png';
                exec($cmd);

            }
        }
        /* Shirt Placket Image Generation End */


        /* view 3 end */

        // Shirt Fit Image Generation Start //
        $rows_fit = ShirtFit::where('status', 1)->get();
        foreach ($rows_fit as $fit){

            $shirtfit_id = $fit['id'];
            $style_type = '';
            $cuff_size = '';
            $cuff_type = '';

            $fit_glow = base_path() . '/customize/shirt/media/men/' . $fit['glow_front_image'];
            $fit_mask = base_path() . '/customize/shirt/media/men/' . $fit['mask_front_image'];
            $fit_highlighted = base_path() . '/customize/shirt/media/men/' . $fit['highlighted_front_image'];


            if ($fit['glow_front_image'] != '' && $fit['mask_front_image'] != '' && $fit['highlighted_front_image'] != '') {
                //mask changed
                $cmd = 'composite -compose Dst_In  -gravity center ' . $fit_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_1.png';
                exec($cmd);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_1.png';
                exec($cmd);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_1.png ' . $fit_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_1.png';
                exec($cmd);
                //highlighted
                $cmd = 'composite ' . $fit_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_1.png';
                exec($cmd);
            }

            $glow_fit_image = base_path() . '/customize/shirt/media/men/' . $fit['glow_side_image'];
            $mask_fit_image = base_path() . '/customize/shirt/media/men/' . $fit['mask_side_image'];
            $highlighted_fit_image = base_path() . '/customize/shirt/media/men/' . $fit['highlighted_side_image'];

            if ($fit['glow_side_image'] != '' && $fit['mask_side_image'] != '' && $fit['highlighted_side_image'] != '') {

                $cmd = 'composite -compose Dst_In  -gravity center ' . $mask_fit_image . ' ' . $fabric_side_view . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_2.png';
                exec($cmd);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_2.png';
                exec($cmd);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_2.png ' . $glow_fit_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_2.png';
                exec($cmd);
                //highlighted
                $cmd = 'composite ' . $highlighted_fit_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_2.png';
                exec($cmd);
            }

            $glow_back_image = base_path() . '/customize/shirt/media/men/' . $fit['glow_back_image'];
            $mask_back_image = base_path() . '/customize/shirt/media/men/' . $fit['mask_back_image'];
            $highlighted_back_image = base_path() . '/customize/shirt/media/men/' . $fit['highlighted_back_image'];

            if ($fit['glow_back_image'] != '' && $fit['mask_back_image'] != '' && $fit['highlighted_back_image'] != '') {
                $cmd = 'composite -compose Dst_In  -gravity center ' . $mask_back_image . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_3.png';
                exec($cmd);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_3.png';
                exec($cmd);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_3.png ' . $glow_back_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_3.png';
                exec($cmd);
                //highlighted
                $cmd = 'composite ' . $highlighted_back_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_3.png';
                exec($cmd);
            }

            $glow_fold_image = base_path() . '/customize/shirt/media/men/' . $fit['glow_fold_image'];
            $mask_fold_image = base_path() . '/customize/shirt/media/men/' . $fit['mask_fold_image'];
            $highlighted_fold_image = base_path() . '/customize/shirt/media/men/' . $fit['highlighted_fold_image'];

            if ($fit['glow_fold_image'] != '' && $fit['mask_fold_image'] != '' && $fit['highlighted_fold_image'] != '') {
                $cmd = 'composite -compose Dst_In  -gravity center ' . $mask_fold_image . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_4.png';
                exec($cmd);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_4.png ' . $glow_fold_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_4.png';
                exec($cmd);
                //highlighted
                $cmd = 'composite ' . $highlighted_fold_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_4.png';
                exec($cmd);
            }

            $glow_zoom_image = base_path() . '/customize/shirt/media/men/' . $fit['glow_zoom_image'];
            $mask_zoom_image = base_path() . '/customize/shirt/media/men/' . $fit['mask_zoom_image'];
            $highlighted_zoom_image = base_path() . '/customize/shirt/media/men/' . $fit['highlighted_zoom_image'];
            if ($fit['glow_zoom_image'] != '' && $fit['mask_zoom_image'] != '' && $fit['highlighted_zoom_image'] != '') {
                $cmd = 'composite -compose CopyOpacity ' . $mask_zoom_image . ' ' . $fabric_zoom . ' ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_5.png';
                exec($cmd);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_5.png ' . $glow_zoom_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_5.png';
                exec($cmd);
                //highlighted
                $cmd = 'composite ' . $highlighted_zoom_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_5.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/fit/' . $fabric_id . '_fitstyle_' . $style_type . '_size_' . $cuff_size . '_fittype_' . $cuff_type . '_' . $shirtfit_id . '_view_5.png';
                exec($cmd);
            }
        }

        // Shirt Fit Image Generation End //

        // Shirt Eblowpatch Image Generation Start //
        $elbowpatches_collection = ShirtAccentElbowpatche::where('status', 1)->get();

        foreach ($elbowpatches_collection as $elbowpatches) {
            $elbowpatches_id = $elbowpatches['elbowpatches_id'];

            $elbowpatchesLeft_glow = base_path() . '/customize/shirt/media/men/' . $elbowpatches['glow_back_image'];
            $elbowpatchesLeft_mask = base_path() . '/customize/shirt/media/men/' . $elbowpatches['mask_back_image'];
            $elbowpatchesLeft_highlighted = base_path() . '/customize/shirt/media/men/' . $elbowpatches['highlighted_back_image'];

            if ($elbowpatches['glow_back_image'] != '' && $elbowpatches['mask_back_image'] != '') {
                //left
                $cmd = 'composite -compose Dst_In -gravity center ' . $elbowpatchesLeft_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/elbowpatches/' . $fabric_id . '_elbowPatches_view_3.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/elbowpatches/' . $fabric_id . '_elbowPatches_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/elbowpatches/' . $fabric_id . '_elbowPatches_view_3.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/elbowpatches/' . $fabric_id . '_elbowPatches_view_3.png ' . $elbowpatchesLeft_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/elbowpatches/' . $fabric_id . '_elbowPatches_view_3.png';
                exec($cmd);
                //highlighted
                $cmd = 'composite ' . $elbowpatchesLeft_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/elbowpatches/' . $fabric_id . '_elbowPatches_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/elbowpatches/' . $fabric_id . '_elbowPatches_view_3.png';
                exec($cmd);
            }
        }
        // Shirt Eblowpatch Image Generation End //


        // Shirt Sleeve Image Generation Start //
        $rows_sleeves = ShirtSleeve::where('status', 1)->get();

        foreach ($rows_sleeves as $sleeves) {

            $sleeve_id = $sleeves['shirtsleeves_id'];
            $style_type = $sleeves['type'];
            $cuff_size = '';
            $cuff_type = '';

            $sleeve_placket_left_glow = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Sleeves/SleevePlacket_left_shad.png';
            $sleeve_placket_left_mask = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Sleeves/SleevePlacket_left_mask.png';
            $sleeve_placket_left_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Sleeves/SleevePlacket_left_hi.png';
            $sleeve_placket_right_glow = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Sleeves/SleevePlacket_right_shad.png';
            $sleeve_placket_right_mask = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Sleeves/SleevePlacket_right_mask.png';
            $sleeve_placket_right_highlighted = base_path() . '/customize/shirt/media/men/glow_mask/Back_View/Sleeves/SleevePlacket_right_hi.png';

            $cmd = 'composite -compose Dst_In -gravity center ' . $sleeve_placket_left_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_left_view_3.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_left_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_left_view_3.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_left_view_3.png ' . $sleeve_placket_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_left_view_3.png';
            exec($cmd);
            //highlight
            $cmd = 'composite ' . $sleeve_placket_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_left_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_left_view_3.png';
            exec($cmd);

            $cmd = 'composite -compose Dst_In -gravity center ' . $sleeve_placket_right_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_right_view_3.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_right_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_right_view_3.png';
            exec($cmd);

            $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_right_view_3.png ' . $sleeve_placket_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_right_view_3.png';
            exec($cmd);
            //highlight
            $cmd = 'composite ' . $sleeve_placket_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_right_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeveplacket/' . $fabric_id . '_sleeve_' . $sleeve_id . '_right_view_3.png';
            exec($cmd);


            $sleeve_left_glow = base_path() . '/customize/shirt/media/men/' . $sleeves['glow_front_left_image'];
            $sleeve_left_mask = base_path() . '/customize/shirt/media/men/' . $sleeves['mask_front_left_image'];
            $sleeve_left_highlighted = base_path() . '/customize/shirt/media/men/' . $sleeves['highlighted_front_left_image'];
            $sleeve_right_glow = base_path() . '/customize/shirt/media/men/' . $sleeves['glow_front_right_image'];
            $sleeve_right_mask = base_path() . '/customize/shirt/media/men/' . $sleeves['mask_front_right_image'];
            $sleeve_right_highlighted = base_path() . '/customize/shirt/media/men/' . $sleeves['highlighted_front_right_image'];


            if ($sleeves['glow_front_left_image'] != '' && $sleeves['mask_front_left_image'] != '' && $sleeves['highlighted_front_left_image'] != '') {

                $cmd = 'composite -compose Dst_In -gravity center ' . $sleeve_left_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png ' . $sleeve_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png';
                exec($cmd);
                //highlight
                $cmd = 'composite ' . $sleeve_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png';
                exec($cmd);

                $cmd = 'composite -compose Dst_In -gravity center ' . $sleeve_right_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png ' . $sleeve_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png';
                exec($cmd);
                //highlight
                $cmd = 'composite ' . $sleeve_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png';
                exec($cmd);
                //combine two images
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_1.png';
                exec($cmd);

                $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_1.png';
                exec($cmd);

                $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_1.png';
                exec($cmd);
            }


            $glow_left_sleeves_image = base_path() . '/customize/shirt/media/men/' . $sleeves['glow_side_left_image'];
            $mask_left_sleeves_image = base_path() . '/customize/shirt/media/men/' . $sleeves['mask_side_left_image'];
            $highlighted_left_sleeves_image = base_path() . '/customize/shirt/media/men/' . $sleeves['highlighted_side_left_image'];

            $glow_right_sleeves_image = base_path() . '/customize/shirt/media/men/' . $sleeves['glow_side_right_image'];
            $mask_right_sleeves_image = base_path() . '/customize/shirt/media/men/' . $sleeves['mask_side_right_image'];
            $highlighted_right_sleeves_image = base_path() . '/customize/shirt/media/men/' . $sleeves['highlighted_side_right_image'];

            if ($sleeves['glow_side_left_image'] != '' && $sleeves['mask_side_left_image'] != '' && $sleeves['highlighted_side_left_image'] != '') {

                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_left_sleeves_image . ' ' . $wave_left . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png ' . $glow_left_sleeves_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png';
                exec($cmd);
                //highlight
                $cmd = 'composite ' . $highlighted_left_sleeves_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png';
                exec($cmd);

                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_right_sleeves_image . ' ' . $wave_right . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png ' . $glow_right_sleeves_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png';
                exec($cmd);
                //highlight
                $cmd = 'composite ' . $highlighted_right_sleeves_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png';
                exec($cmd);
                //combine two images
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_2.png';
                exec($cmd);

                $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_2.png';
                exec($cmd);

                $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_2.png';
                exec($cmd);

            }

            $glow_left_back_image = base_path() . '/customize/shirt/media/men/' . $sleeves['glow_back_left_image'];
            $mask_left_back_image = base_path() . '/customize/shirt/media/men/' . $sleeves['mask_back_left_image'];
            $highlighted_left_back_image = base_path() . '/customize/shirt/media/men/' . $sleeves['highlighted_back_left_image'];
            $glow_right_back_image = base_path() . '/customize/shirt/media/men/' . $sleeves['glow_back_right_image'];
            $mask_right_back_image = base_path() . '/customize/shirt/media/men/' . $sleeves['mask_back_right_image'];
            $highlighted_right_back_image = base_path() . '/customize/shirt/media/men/' . $sleeves['highlighted_back_right_image'];

            if ($sleeves['glow_back_left_image'] != '' && $sleeves['mask_back_left_image'] != '' && $sleeves['highlighted_back_left_image'] != '') {

                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_left_back_image . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png ' . $glow_left_back_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $highlighted_left_back_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png';
                exec($cmd);

                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_right_back_image . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png ' . $glow_right_back_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $highlighted_right_back_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png';
                exec($cmd);

                //combine two images
                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_3.png';
                exec($cmd);

                $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_right_view_3.png';
                exec($cmd);

                $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_left_view_3.png';
                exec($cmd);
            }

            $glow_fold_image = base_path() . '/customize/shirt/media/men/' . $sleeves['glow_fold_image'];
            $mask_fold_image = base_path() . '/customize/shirt/media/men/' . $sleeves['mask_fold_image'];
            $highlighted_fold_image = base_path() . '/customize/shirt/media/men/' . $sleeves['highlighted_fold_image'];

            if ($sleeves['glow_fold_image'] != '' && $sleeves['mask_fold_image'] != '' && $sleeves['highlighted_fold_image'] != '') {

                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_fold_image . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_4.png ' . $glow_fold_image . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_4.png';
                exec($cmd);

                //highlight
                // $cmd = 'composite ' . $highlighted_right_back_image . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/sleeves/' . $fabric_id . '_sleevesstyle_' . $style_type . '_size_' . $cuff_size . '_sleevestype_' . $cuff_type . '_' . $sleeve_id . '_view_4.png';
//                exec($cmd);
            }
        }

        // Shirt Sleeve Image Generation End //

        /* Shirt Pocket Image Generation Start */
        $rows_pockets = ShirtPocket::where('status', 1)->get();;
        // echo "<pre>"; print_r($rows_pockets);
        foreach ($rows_pockets as $pocket){

            $pocket_id = $pocket['id'];
            $pocket_left_glow = base_path() . '/customize/shirt/media/men/' . $pocket['glow_front_left_image'];

            $pocket_left_mask = base_path() . '/customize/shirt/media/men/' . $pocket['mask_front_left_image'];
            $pocket_left_highlighted = base_path() . '/customize/shirt/media/men/' . $pocket['highlighted_front_left_image'];
            $pocket_right_glow = base_path() . '/customize/shirt/media/men/' . $pocket['glow_front_right_image'];
            $pocket_right_mask = base_path() . '/customize/shirt/media/men/' . $pocket['mask_front_right_image'];
            $pocket_right_highlighted = base_path() . '/customize/shirt/media/men/' . $pocket['highlighted_front_right_image'];

            if (($pocket['glow_front_left_image'] != '' && $pocket['mask_front_left_image'] != '') || ($pocket['glow_front_right_image'] != '' && $pocket['mask_front_right_image'] != '')) {
                $cmd = 'composite -compose Dst_In -gravity center ' . $pocket_left_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png ' . $pocket_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $pocket_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png';
                exec($cmd);

                $cmd = 'composite -compose Dst_In -gravity center ' . $pocket_right_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png ' . $pocket_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $pocket_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png';
                exec($cmd);

                if ($pocket['mask_front_right_image'] != '' && $pocket['mask_front_left_image'] != '') {
                    //combine
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_1.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png';
                    exec($cmd);

                } else if ($pocket['mask_front_right_image'] == '' && $pocket['mask_front_left_image'] != '') {
                    //combine
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/static/blank.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_1.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_1.png';
                    exec($cmd);

                } else if ($pocket['mask_front_right_image'] != '' && $pocket['mask_front_left_image'] == '') {
                    //combine
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/static/blank.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_1.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_1.png';
                    exec($cmd);

                }
            }

            $pocket_left_glow = base_path() . '/customize/shirt/media/men/' . $pocket['glow_side_left_image'];
            $pocket_left_mask = base_path() . '/customize/shirt/media/men/' . $pocket['mask_side_left_image'];
            $pocket_left_highlighted = base_path() . '/customize/shirt/media/men/' . $pocket['highlighted_side_left_image'];
            $pocket_right_glow = base_path() . '/customize/shirt/media/men/' . $pocket['glow_side_right_image'];
            $pocket_right_mask = base_path() . '/customize/shirt/media/men/' . $pocket['mask_side_right_image'];
            $pocket_right_highlighted = base_path() . '/customize/shirt/media/men/' . $pocket['highlighted_side_right_image'];

            if (($pocket['glow_side_left_image'] != '' && $pocket['mask_side_left_image'] != '') || ($pocket['glow_side_right_image'] != '' && $pocket['mask_side_right_image'] != '')) {
                $cmd = 'composite -compose Dst_In -gravity center ' . $pocket_left_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png ' . $pocket_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $pocket_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png';
                exec($cmd);

                $cmd = 'composite -compose Dst_In -gravity center ' . $pocket_right_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png ' . $pocket_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $pocket_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png';
                exec($cmd);

                //combine
                if ($pocket['mask_side_right_image'] != '' && $pocket['mask_side_left_image'] != '') {
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_2.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png';
                    exec($cmd);

                } else if ($pocket['mask_side_right_image'] == '' && $pocket['mask_side_left_image'] != '') {
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/static/blank.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_2.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_2.png';
                    exec($cmd);

                } else if ($pocket['mask_side_right_image'] != '' && $pocket['mask_side_left_image'] == '') {
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/static/blank.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_2.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_2.png';
                    exec($cmd);

                }
            }

            $pocket_left_glow = base_path() . '/customize/shirt/media/men/' . $pocket['glow_fold_left_image'];
            $pocket_left_mask = base_path() . '/customize/shirt/media/men/' . $pocket['mask_fold_left_image'];
            $pocket_left_highlighted = base_path() . '/customize/shirt/media/men/' . $pocket['highlighted_fold_left_image'];
            $pocket_right_glow = base_path() . '/customize/shirt/media/men/' . $pocket['glow_fold_right_image'];
            $pocket_right_mask = base_path() . '/customize/shirt/media/men/' . $pocket['mask_fold_right_image'];
            $pocket_right_highlighted = base_path() . '/customize/shirt/media/men/' . $pocket['highlighted_fold_right_image'];

            if (($pocket['glow_fold_left_image'] != '' && $pocket['mask_fold_left_image'] != '') || ($pocket['glow_fold_right_image'] != '' && $pocket['mask_fold_right_image'] != '')) {
                $cmd = 'composite -compose Dst_In -gravity center ' . $pocket_left_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png ' . $pocket_left_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $pocket_left_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png';
                exec($cmd);

                $cmd = 'composite -compose Dst_In -gravity center ' . $pocket_right_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png';
                exec($cmd);

                $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png ' . $pocket_right_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png';
                exec($cmd);

                //highlight
                $cmd = 'composite ' . $pocket_right_highlighted . ' -compose Overlay  ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png';
                exec($cmd);

                //combine

                if ($pocket['mask_fold_right_image'] != '' && $pocket['mask_fold_left_image'] != '') {
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_4.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png';
                    exec($cmd);

                } else if ($pocket['mask_fold_right_image'] == '' && $pocket['mask_fold_left_image'] != '') {
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/static/blank.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_4.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_left_view_4.png';
                    exec($cmd);

                } else if ($pocket['mask_fold_right_image'] != '' && $pocket['mask_fold_left_image'] == '') {
                    $cmd = 'convert ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/static/blank.png -geometry +0+0 -composite ' . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_view_4.png';
                    exec($cmd);

                    $cmd = "rm " . base_path() . '/customize/shirt/media/men/generated_shirt_images/pocket/' . $fabric_id . '_pockets_' . $pocket_id . '_right_view_4.png';
                    exec($cmd);
                }
            }
        }
        /* Shirt Pocket Image Generation End */
    }

}