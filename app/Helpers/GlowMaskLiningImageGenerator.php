<?php
/**
 * Created by PhpStorm.
 * User: rameshkumar
 * Date: 16/3/20
 * Time: 10:36 PM
 */

namespace App\Helpers;


class GlowMaskLiningImageGenerator
{

    public static function LiningImageGenerator($id, $fileName, $destination){
        /* color image creation start */
        $fabric_id =$id;

        $fabric_thumb_name =  $fileName;
        $homepath = $destination;

        $fabricThumbImgpath = $homepath.$fabric_thumb_name;

        $fabricName = "fabric_main.png";
        $fabric_0 = base_path().'/customize/suit/media/men/fab_suit_images/lining/' . $fabricName;
        $fabricName = "fabric_main.png";
        $fabric_0 = base_path().'/customize/suit/media/men/fab_suit_images/lining/' . $fabricName;
        //back

        $fabricName_90 = "fabric_main_90.png";
        $fabric_90 = base_path().'/customize/suit/media/men/fab_suit_images/lining/' . $fabricName_90;

        //for zoom view
        $fabric_zoom = base_path()."/customize/suit/media/men/fab_suit_images/lining/fabric_zoom.png";
        $suitFabImgPath = base_path().'/customize/suit/media/men/fab_suit_images/lining/';

        exec('convert ' . $fabricThumbImgpath . ' -rotate 90 ' . $fabric_90);
        exec('convert -size 1080x1320 tile:' . $fabric_90 . ' ' . $suitFabImgPath . 'fabric_main_back.png');
        exec('convert -size 1080x1320 tile:' . $fabric_90 . ' ' . $fabric_90);

        $fabricName_60 = "fabric_main_60.png";
        $fabric_60 = base_path().'/customize/suit/media/men/fab_suit_images/lining/' . $fabricName_60;

        //exec('convert -size 1080x1320 tile:' . $fabricThumbImgpath . ' ' . $fabric_120);
        //exec('convert ' . $fabric_120 . ' -rotate 120 ' . $fabric_120);

        exec('convert -size 1080x1320 tile:' . $fabricThumbImgpath . ' ' . $fabric_0);
        //exec('convert -size 300x300 tile:' . $fabricThumbImgpath . ' ' . $homepath . 'customize/suit/media/men/fab_shirt_images/fabric_' . $fabric_id . '_show.png');
        //created for collar

        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -67 ' . $fabric_60);

        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 80 ' . $suitFabImgPath . 'fabric_cuff_side.png');

        //zoom view fabirc
        exec('convert -size 1200x900 tile:' . $fabricThumbImgpath . ' ' . $fabric_zoom);
        //created for collar
        exec('convert ' . $fabric_zoom . ' -background "rgba(0,0,0,0.5)" -distort SRT 90 ' . $suitFabImgPath . 'fabric_main_back_zoom.png');


        $lapel_fabric_left =  base_path().'/customize/suit/media/men/fab_suit_images/lining/lapel_fabric_left.png';
        $lapel_fabric_right = base_path().'/customize/suit/media/men/fab_suit_images/lining/lapel_fabric_right.png';
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 15 ' . $lapel_fabric_left);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -15 ' . $lapel_fabric_right);


        $lapel_fabric_upper_left = base_path().'/customize/suit/media/men/fab_suit_images/lining/lapel_fabric_upper_left.png';
        $lapel_fabric_upper_right = base_path().'/customize/suit/media/men/fab_suit_images/lining/lapel_fabric_upper_right.png';
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -45 ' . $lapel_fabric_upper_left);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 45 ' . $lapel_fabric_upper_right);


        $fabricName_wave_left = "fabric_wave_left.png";
        $fabricName_wave_right = "fabric_wave_right.png";

        $wave_left = base_path().'/customize/suit/media/men/fab_suit_images/lining/' . $fabricName_wave_left;
        $wave_right = base_path().'/customize/suit/media/men/fab_suit_images/lining/' . $fabricName_wave_right;

        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -5 ' . $wave_left);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 5 ' . $wave_right);
        // fabric generation ends for sizes..

        // Read JSON file
        // suit styles..
        $json = file_get_contents(base_path().'/customize/suit/JSON/Generation/Suit_Style.json');
        //Decode JSON
        $suitStyle_collection = json_decode($json,true);
        //Print data

        $i=0;
        foreach ($suitStyle_collection as $suitStyle) {
            $suitStyleId = $suitStyle['suitstyle_id'];


            if($suitStyleId!=3 && $suitStyleId!=7){

                // Inner Lining
                $glow_innerlining_view_2      = base_path().'/customize/suit/media/men/glow_mask/lining/CommonInnerlining_shad.png';
                $mask_innerlining_view_2      = base_path().'/customize/suit/media/men/glow_mask/lining/CommonInnerlining_mask.png';
                $highlight_innerlining_view_2 = base_path().'/customize/suit/media/men/glow_mask/lining/CommonInnerlining_hi.png';

                if ($glow_innerlining_view_2!='' && $mask_innerlining_view_2!='' && $highlight_innerlining_view_2!='') {
                    //mask
                    exec('composite -compose Dst_In -gravity center ' . $mask_innerlining_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');
                    //convert
                    exec('convert ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png -crop 500x1320+290+0  +repage ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');
                    //glow
                    exec('composite ' . $glow_innerlining_view_2 . ' -compose Multiply  ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');
                    //highlight
                    exec('composite ' . $highlight_innerlining_view_2 . ' -compose Overlay  ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');
                    // echo 'composite ' . $highlight_innerlining_view_2 . ' -compose Overlay  ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png'; die;
                }

            }else {

                // Inner Lining
                $glow_innerlining_view_2      = base_path().'/customize/suit/media/men/glow_mask/lining/MandarinInnerLining_shad.png';
                $mask_innerlining_view_2      = base_path().'/customize/suit/media/men/glow_mask/lining/MandarinInnerLining_mask.png';
                $highlight_innerlining_view_2 = base_path().'/customize/suit/media/men/glow_mask/lining/MandarinInnerLining_hi.png';
                if ($glow_innerlining_view_2!='' && $mask_innerlining_view_2!='' && $highlight_innerlining_view_2!=''){
                    //mask
                    exec('composite -compose Dst_In -gravity center ' . $mask_innerlining_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');
                    echo 'composite -compose Dst_In -gravity center ' . $mask_innerlining_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png';
                    //convert
                    exec('convert ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png -crop 500x1320+290+0  +repage ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');
                    //glow
                    exec('composite ' . $glow_innerlining_view_2 . ' -compose Multiply  ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');
                    //highlight
                    exec('composite ' . $highlight_innerlining_view_2 . ' -compose Overlay  ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png ' . base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');
                }

                // exec('rm -rf '.base_path().'/customize/suit/media/men/generated_suit_images/lining/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png');

            }

            $i++;
        }
    }

}