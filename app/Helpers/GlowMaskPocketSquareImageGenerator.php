<?php
/**
 * Created by PhpStorm.
 * User: rameshkumar
 * Date: 16/3/20
 * Time: 10:37 PM
 */

namespace App\Helpers;


class GlowMaskPocketSquareImageGenerator
{

    public static function PocketSquareImageGenerator($id, $fileName, $destination){

        /* color image creation start */
        $fabric_id =$id;

        $fabric_thumb_name =  $fileName;
        $homepath = $destination;
        $fabricThumbImgpath = $homepath.$fabric_thumb_name;
        $fabricName = "fabric_main.png";
        $fabric_0 = base_path().'/customize/suit/media/men/fab_suit_images/pocketsquare/' . $fabricName;
        //back

        exec('convert -size 1080x1320 tile:' . $fabricThumbImgpath . ' ' . $fabric_0);

        // Inner Lining
        $glow_innerpocketsquare_view_2      = base_path().'/customize/suit/media/men/glow_mask/Pocket_Squre/Pocketsquireshad.png';
        $mask_innerpocketsquare_view_2      = base_path().'/customize/suit/media/men/glow_mask/Pocket_Squre/Pocketsquire_mask.png';
        $highlight_innerpocketsquare_view_2 = base_path().'/customize/suit/media/men/glow_mask/Pocket_Squre/Pocketsquire_hi.png';

        if ($glow_innerpocketsquare_view_2!='' && $mask_innerpocketsquare_view_2!='' && $highlight_innerpocketsquare_view_2!='') {
            //mask
            exec('composite -compose Dst_In -gravity center ' . $mask_innerpocketsquare_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path().'/customize/suit/media/men/generated_suit_images/pocketsquare/' . $fabric_id .'_view_1.png');
            //convert
            exec('convert ' . base_path().'/customize/suit/media/men/generated_suit_images/pocketsquare/' . $fabric_id . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path().'/customize/suit/media/men/generated_suit_images/pocketsquare/' . $fabric_id .'_view_1.png');
            //glow
            exec('composite ' . $glow_innerpocketsquare_view_2 . ' -compose Multiply  ' . base_path().'/customize/suit/media/men/generated_suit_images/pocketsquare/' . $fabric_id .'_view_1.png ' . base_path().'/customize/suit/media/men/generated_suit_images/pocketsquare/' . $fabric_id . '_view_1.png');
            //highlight
            exec('composite ' . $highlight_innerpocketsquare_view_2 . ' -compose Overlay  ' . base_path().'/customize/suit/media/men/generated_suit_images/pocketsquare/' . $fabric_id . '_view_1.png ' . base_path().'/customize/suit/media/men/generated_suit_images/pocketsquare/' . $fabric_id . '_view_1.png');
        }
    }

}