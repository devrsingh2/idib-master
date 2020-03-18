<?php
/**
 * Created by PhpStorm.
 * User: rameshkumar
 * Date: 16/3/20
 * Time: 10:35 PM
 */

namespace App\Helpers;


class GlowMaskImageGenerator
{

    public static function ImageGenerator($id, $fileName, $destination){
        /* color image creation start */
        $fabric_id = $id;

        // $homepath = $this->rootPath;
        $fabric_thumb_name =  $fileName;
        $homepath = $destination;
        $fabricThumbImgpath = $homepath.'/'.$fabric_thumb_name;
        $fabricName = "fabric_main.png";
        $fabric_0 = $homepath.'/'.$fabricName;
        //back

        $fabricName_90 = "fabric_main_90.png";
        $fabric_90 = $homepath.'/'.$fabricName_90;

        //for zoom view
        $fabric_zoom = base_path()."/customize/suit/media/men/fab_suit_images/fabric_zoom.png";
        $shirtFabImgPath = base_path().'/customize/suit/media/men/fab_suit_images/';

        exec('convert ' . $fabricThumbImgpath . ' -rotate 90 ' . $fabric_90);
//dd('convert ' . $fabricThumbImgpath . ' -rotate 90 ' . $fabric_90);
//dd($fabricThumbImgpath);
        exec('convert -size 1080x1320 tile:' . $fabric_90 . ' ' . $shirtFabImgPath . 'fabric_main_back.png');
        exec('convert -size 1080x1320 tile:' . $fabric_90 . ' ' . $fabric_90);

        $fabricName_60 = "fabric_main_60.png";
        $fabric_60 = $homepath.'/'.$fabricName_60;
        exec('convert -size 1080x1320 tile:' . $fabricThumbImgpath . ' ' . $fabric_0);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -67 ' . $fabric_60);

        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 80 ' . $shirtFabImgPath . 'fabric_cuff_side.png');

        //zoom view fabirc
        exec('convert -size 1200x900 tile:' . $fabricThumbImgpath . ' ' . $fabric_zoom);
        //created for collar
        exec('convert ' . $fabric_zoom . ' -background "rgba(0,0,0,0.5)" -distort SRT 90 ' . $shirtFabImgPath . 'fabric_main_back_zoom.png');


        $lapel_fabric_left = base_path().'/customize/suit/media/men/fab_suit_images/lapel_fabric_left.png';
        $lapel_fabric_right = base_path().'/customize/suit/media/men/fab_suit_images/lapel_fabric_right.png';
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 15 ' . $lapel_fabric_left);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -15 ' . $lapel_fabric_right);


        $lapel_fabric_upper_left = base_path().'/customize/suit/media/men/fab_suit_images/lapel_fabric_upper_left.png';
        $lapel_fabric_upper_right = base_path().'/customize/suit/media/men/fab_suit_images/lapel_fabric_upper_right.png';
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -45 ' . $lapel_fabric_upper_left);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 45 ' . $lapel_fabric_upper_right);


        $fabricName_wave_left = "fabric_wave_left.png";
        $fabricName_wave_right = "fabric_wave_right.png";

        $wave_left = $homepath.'/'.$fabricName_wave_left;
        $wave_right = $homepath.'/'.$fabricName_wave_right;

        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT -5 ' . $wave_left);
        exec('convert ' . $fabric_0 . ' -background "rgba(0,0,0,0.5)" -distort SRT 5 ' . $wave_right);



        // Read JSON file
        // suit styles..

        $json = file_get_contents(base_path().'/customize/suit/JSON/Generation/Suit_Style.json');
        //Decode JSON
        $suitStyle_collection = json_decode($json,true);
        //Print data
        //$query = "INSERT INTO `generation_cmd`(`command`) VALUES ('{$cmd}')";
        $i=0;
        foreach ($suitStyle_collection as $suitStyle){

            $suitStyleId = $suitStyle['suitstyle_id'];

            //view 1
            $glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitStyle['glow_image'];
            $mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitStyle['mask_image'];
            $highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitStyle['hi_image'];

            $back_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitStyle['back_glow_image'];
            $back_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitStyle['back_mask_image'];
            $back_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitStyle['back_hi_image'];

            if ($suitStyle['glow_image'] && $suitStyle['mask_image'] && $suitStyle['hi_image']) {
                //mask

                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_1.png';
                exec($cmd);

                //$this->connection->query($query);
            }

            if ($suitStyle['back_glow_image'] && $suitStyle['back_mask_image'] && $suitStyle['back_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $back_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $back_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $back_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/style/' . $fabric_id . '_style_' . $suitStyleId .'_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            if($suitStyleId!=3 && $suitStyleId!=7){

                //Front Collar

                $glow_collar_view_1      = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/commonCollar_shad.png';
                $mask_collar_view_1      = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/commonCollar_mask.png';
                $highlight_collar_view_1 = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/commonCollar_hi.png';

                if ($glow_collar_view_1!='' && $mask_collar_view_1!='' && $highlight_collar_view_1!='') {
                    //mask
                    $cmd = 'composite -compose Dst_In -gravity center ' . $mask_collar_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //convert
                    $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //glow
                    $cmd = 'composite ' . $glow_collar_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //highlight
                    $cmd = 'composite ' . $highlight_collar_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                }

            }
            else {

                //     //Front Collar

                $glow_collar_view_1      = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/MandarinCollar_shad.png';
                $mask_collar_view_1      = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/MandarinCollar_mask.png';
                $highlight_collar_view_1 = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/MandarinCollar_hi.png';

                if ($glow_collar_view_1!='' && $mask_collar_view_1!='' && $highlight_collar_view_1!='') {
                    //mask
                    $cmd = 'composite -compose Dst_In -gravity center ' . $mask_collar_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_style_'.$suitStyleId.'_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //convert
                    $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_style_'.$suitStyleId.'_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_style_'.$suitStyleId.'_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //glow
                    $cmd = 'composite ' . $glow_collar_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_style_'.$suitStyleId.'_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_style_'.$suitStyleId.'_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //highlight
                    $cmd = 'composite ' . $highlight_collar_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_style_'.$suitStyleId.'_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/collar/' . $fabric_id . '_styletype_'.$suitStyleId.'_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                }

            }
            $i++;
        }


        /*  Suit Jacket Generation Starts. */

        // Read JSON file
        // suit lapels..
        $jsonLapel = file_get_contents(base_path().'/customize/suit/JSON/Generation/Formal_Lapels_sample.json');
        //Decode JSON
        // echo "skdisdasjnd"; die;
        $suitLapel_collection = json_decode($jsonLapel,true);
        // echo "<pre>"; print_r($suitLapel_collection); die;
        // echo "<pre>"; print_r($suitLapel_collection); die;
        //Print data
        foreach ($suitLapel_collection as $suitLapel){

            $suitLapelId = $suitLapel['suitformallapels_id'];
            $styleId     = $suitLapel['style'];
            $lapelId     = $suitLapel['lapel'];
            $sizeId     = $suitLapel['size'];

            //view UL
            $glow_view_UL      = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_left_glow_image'];
            $mask_view_UL      = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_left_mask_image'];
            $highlight_view_UL = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_left_hi_image'];

            if ($suitLapel['upper_left_glow_image'] && $suitLapel['upper_left_mask_image'] && $suitLapel['upper_left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_UL . ' ' . $lapel_fabric_upper_left . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_UL . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_UL . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }


            //view UR
            $glow_view_UR      = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_right_glow_image'];
            $mask_view_UR      = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_right_mask_image'];
            $highlight_view_UR = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_right_hi_image'];

            if ($suitLapel['upper_right_glow_image'] && $suitLapel['upper_right_mask_image'] && $suitLapel['upper_right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_UR . ' ' . $lapel_fabric_upper_right . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_UR . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_UR . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view LL
            $glow_view_LL      = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_left_glow_image'];
            $mask_view_LL      = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_left_mask_image'];
            $highlight_view_LL = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_left_hi_image'];

            if ($suitLapel['lower_left_glow_image'] && $suitLapel['lower_left_mask_image'] && $suitLapel['lower_left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_LL . ' ' . $lapel_fabric_left . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_LL . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_LL . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view LR
            $glow_view_LR      = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_right_glow_image'];
            $mask_view_LR      = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_right_mask_image'];
            $highlight_view_LR = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_right_hi_image'];

            if ($suitLapel['lower_right_glow_image'] && $suitLapel['lower_right_mask_image'] && $suitLapel['lower_right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_LR . ' ' . $lapel_fabric_right . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_LR . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_LR . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }


            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png -geometry +0+0 -composite '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png -geometry +0+0 -composite '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png -geometry +0+0 -composite '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png';
            exec($cmd);

            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        // suit lapel ends.
        // Read JSON file
        // suit lapels..
        $jsonLapel = file_get_contents(base_path().'/customize/suit/JSON/Generation/Formal_Lapels.json');
        //Decode JSON
        $suitLapel_collection = json_decode($jsonLapel,true);
        //Print data
        foreach ($suitLapel_collection as $suitLapel){

            $suitLapelId = $suitLapel['suitformallapels_id'];
            $styleId     = $suitLapel['style'];
            $lapelId     = $suitLapel['lapel'];
            $sizeId     = $suitLapel['size'];

            //view UL
            $glow_view_UL      = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_left_glow_image'];
            $mask_view_UL      = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_left_mask_image'];
            $highlight_view_UL = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_left_hi_image'];

            if ($suitLapel['upper_left_glow_image'] && $suitLapel['upper_left_mask_image'] && $suitLapel['upper_left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_UL . ' ' . $lapel_fabric_upper_left . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_UL . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_UL . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }


            //view UR
            $glow_view_UR      = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_right_glow_image'];
            $mask_view_UR      = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_right_mask_image'];
            $highlight_view_UR = base_path() . '/customize/suit/media/men/' . $suitLapel['upper_right_hi_image'];

            if ($suitLapel['upper_right_glow_image'] && $suitLapel['upper_right_mask_image'] && $suitLapel['upper_right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_UR . ' ' . $lapel_fabric_upper_right . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_UR . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_UR . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view LL
            $glow_view_LL      = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_left_glow_image'];
            $mask_view_LL      = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_left_mask_image'];
            $highlight_view_LL = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_left_hi_image'];

            if ($suitLapel['lower_left_glow_image'] && $suitLapel['lower_left_mask_image'] && $suitLapel['lower_left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_LL . ' ' . $lapel_fabric_left . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_LL . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_LL . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view LR
            $glow_view_LR      = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_right_glow_image'];
            $mask_view_LR      = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_right_mask_image'];
            $highlight_view_LR = base_path() . '/customize/suit/media/men/' . $suitLapel['lower_right_hi_image'];

            if ($suitLapel['lower_right_glow_image'] && $suitLapel['lower_right_mask_image'] && $suitLapel['lower_right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_LR . ' ' . $lapel_fabric_right . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_LR . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_LR . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }


            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png -geometry +0+0 -composite '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png -geometry +0+0 -composite '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png -geometry +0+0 -composite '
                . base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_size_'.$sizeId.'_view_1.png';
            exec($cmd);

            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_upper_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/lapel/' . $fabric_id . '_lapelstyle_' . $styleId . '_size_'.$sizeId.'_lapeltype_'.$lapelId.'_lower_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
        }

        /* Vest Generation Starts */

        $jsonVest = file_get_contents(base_path().'/customize/suit/JSON/Generation/VestStylesEdges.json');
        //Decode JSON
        $vestStyle_collection = json_decode($jsonVest,true);
        // echo "<pre>"; print_r($vestStyle_collection); die;

        $back_glow_view_1      = base_path() . '/customize/suit/media/men/glow_mask/vestedge/Back_Vest_shad.png';
        $back_mask_view_1      = base_path() . '/customize/suit/media/men/glow_mask/vestedge/Back_Vest_mask.png';
        $back_highlight_view_1 = base_path() . '/customize/suit/media/men/glow_mask/vestedge/Back_Vest_hi.png';

        foreach ($vestStyle_collection as $vestStyle){
            $vestStyleId = $vestStyle['veststyleedge_id'];
            $styleId     = $vestStyle['style'];
            $edgeId      = $vestStyle['edge'];

            //view 1
            $glow_view_1      = base_path() . '/customize/suit/media/men/' . $vestStyle['glow_image'];
            $mask_view_1      = base_path() . '/customize/suit/media/men/' . $vestStyle['mask_image'];
            $highlight_view_1 = base_path() . '/customize/suit/media/men/' . $vestStyle['hi_image'];

            if ($vestStyle['glow_image'] && $vestStyle['mask_image'] && $vestStyle['hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$edgeId.'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);

                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $back_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $back_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $back_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_style_' . $styleId . '_bottom_'.$edgeId.'_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/veststyle/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$edgeId.'_view_2.png';
                exec($cmd);
                //$this->connection->query($query);

                // Inner Lining

                $glow_innerlining_view_2      = base_path() . '/customize/suit/media/men/glow_mask/lining/VestLining_shad.png';
                $mask_innerlining_view_2      = base_path() . '/customize/suit/media/men/glow_mask/lining/VestLining_mask.png';
                $highlight_innerlining_view_2 = base_path() . '/customize/suit/media/men/glow_mask/lining/VestLining_hi.png';

                if ($glow_innerlining_view_2!='' && $mask_innerlining_view_2!='' && $highlight_innerlining_view_2!='') {
                    //mask
                    $cmd = 'composite -compose Dst_In -gravity center ' . $mask_innerlining_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestlining/' . $fabric_id . '_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //convert
                    $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestlining/' . $fabric_id . '_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestlining/' . $fabric_id . '_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //glow
                    $cmd = 'composite ' . $glow_innerlining_view_2 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestlining/' . $fabric_id . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestlining/' . $fabric_id . '_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //highlight
                    $cmd = 'composite ' . $highlight_innerlining_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestlining/' . $fabric_id . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestlining/' . $fabric_id . '_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                }


                // Inner Collar

                $glow_innerlining_view_2      = base_path() . '/customize/suit/media/men/glow_mask/lining/VestCollar_shad.png';
                $mask_innerlining_view_2      = base_path() . '/customize/suit/media/men/glow_mask/lining/VestCollar_mask.png';
                $highlight_innerlining_view_2 = base_path() . '/customize/suit/media/men/glow_mask/lining/VestCollar_hi.png';
                if ($glow_innerlining_view_2!='' && $mask_innerlining_view_2!='' && $highlight_innerlining_view_2!='') {
                    //mask
                    $cmd = 'composite -compose Dst_In -gravity center ' . $mask_innerlining_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_vestcollar_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //convert
                    $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_vestcollar_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_vestcollar_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //glow
                    $cmd = 'composite ' . $glow_innerlining_view_2 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_vestcollar_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_vestcollar_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                    //highlight
                    // $cmd = 'composite ' . $highlight_innerlining_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_vestcollar_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_view_3.png';
                    $cmd = 'composite ' . $highlight_innerlining_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_vestcollar_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_view_3.png';
                    exec($cmd);
                    //$this->connection->query($query);
                }
                $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/vestcollar/' . $fabric_id . '_vestcollar_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
            }
        }
        // vest styles end.



        // vest pockets
        // Read JSON file
        $jsonVest = file_get_contents(base_path().'/customize/suit/JSON/Generation/VestPockets.json');
        //Decode JSON
        $vestPocket_collection = json_decode($jsonVest,true);

        foreach ($vestPocket_collection as $vestPocket){
            $vestPocketId = $vestPocket['vestpocket_id'];
            //view 1
            $glow_view_1      = base_path() . '/customize/suit/media/men/' . $vestPocket['glow_image'];
            $mask_view_1      = base_path() . '/customize/suit/media/men/' . $vestPocket['mask_image'];
            $highlight_view_1 = base_path() . '/customize/suit/media/men/' . $vestPocket['hi_image'];

            if ($vestPocket['glow_image'] && $vestPocket['mask_image'] && $vestPocket['hi_image']){
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestpockets/' . $fabric_id . '_style_' . $vestPocketId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestpockets/' . $fabric_id . '_style_' . $vestPocketId . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestpockets/' . $fabric_id . '_style_' . $vestPocketId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestpockets/' . $fabric_id . '_style_' . $vestPocketId . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestpockets/' . $fabric_id . '_style_' . $vestPocketId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestpockets/' . $fabric_id . '_style_' . $vestPocketId . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestpockets/' . $fabric_id . '_style_' . $vestPocketId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }
        }
        // vest pockets end.


        // Read JSON file
        // vest lapels.
        $jsonVestLapel = file_get_contents( base_path().'/customize/suit/JSON/Generation/VestLapels.json');
        //Decode JSON
        $vestLapel_collection = json_decode($jsonVestLapel,true);
        foreach ($vestLapel_collection as $vestLapel){
            $vestLapelId = $vestLapel['vestlapels_id'];
            $styleId     = $vestLapel['style'];
            $lapelId      = $vestLapel['lapel'];

            //view UL
            $glow_view_UL      =  base_path() . '/customize/suit/media/men/' . $vestLapel['upper_left_glow_image'];
            $mask_view_UL      =  base_path() . '/customize/suit/media/men/' . $vestLapel['upper_left_mask_image'];
            $highlight_view_UL =  base_path() . '/customize/suit/media/men/' . $vestLapel['upper_left_hi_image'];

            if ($vestLapel['upper_left_glow_image'] && $vestLapel['upper_left_mask_image'] && $vestLapel['upper_left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_UL . ' ' . $lapel_fabric_upper_left . ' -alpha Set ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png -crop 500x1320+290+0  +repage ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_UL . ' -compose Multiply  ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_UL . ' -compose Overlay  ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view UR
            $glow_view_UR      =  base_path() . '/customize/suit/media/men/' . $vestLapel['upper_right_glow_image'];
            $mask_view_UR      =  base_path() . '/customize/suit/media/men/' . $vestLapel['upper_right_mask_image'];
            $highlight_view_UR =  base_path() . '/customize/suit/media/men/' . $vestLapel['upper_right_hi_image'];

            if ($vestLapel['upper_right_glow_image'] && $vestLapel['upper_right_mask_image'] && $vestLapel['upper_right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_UR . ' ' . $lapel_fabric_upper_right . ' -alpha Set ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png -crop 500x1320+290+0  +repage ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_UR . ' -compose Multiply  ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_UR . ' -compose Overlay  ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view LL
            $glow_view_LL      =  base_path() . '/customize/suit/media/men/' . $vestLapel['lower_left_glow_image'];
            $mask_view_LL      =  base_path() . '/customize/suit/media/men/' . $vestLapel['lower_left_mask_image'];
            $highlight_view_LL =  base_path() . '/customize/suit/media/men/' . $vestLapel['lower_left_hi_image'];

            if ($vestLapel['lower_left_glow_image'] && $vestLapel['lower_left_mask_image'] && $vestLapel['lower_left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_LL . ' ' . $lapel_fabric_left . ' -alpha Set ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png -crop 500x1320+290+0  +repage ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_LL . ' -compose Multiply  ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_LL . ' -compose Overlay  ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view LR
            $glow_view_LR      =  base_path() . '/customize/suit/media/men/' . $vestLapel['lower_right_glow_image'];
            $mask_view_LR      =  base_path() . '/customize/suit/media/men/' . $vestLapel['lower_right_mask_image'];
            $highlight_view_LR =  base_path() . '/customize/suit/media/men/' . $vestLapel['lower_right_hi_image'];

            if ($vestLapel['lower_right_glow_image'] && $vestLapel['lower_right_mask_image'] && $vestLapel['lower_right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_LR . ' ' . $lapel_fabric_right . ' -alpha Set ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png -crop 500x1320+290+0  +repage ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_LR . ' -compose Multiply  ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_LR . ' -compose Overlay  ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }


            $cmd = 'convert ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png '
                .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png -geometry +0+0 -composite '
                .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'convert ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png '
                .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_view_1.png -geometry +0+0 -composite '
                .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'convert ' .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png '
                .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_view_1.png -geometry +0+0 -composite '
                .  base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_styletype_' . $styleId . '_style_'.$lapelId.'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '. base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '. base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_upper_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '. base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '. base_path() . '/customize/suit/media/men/generated_suit_images/vestlapel/' . $fabric_id . '_style_' . $styleId . '_lapel_'.$lapelId.'_lower_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        // vest lapels end.


        // vest breast pocket.
        $glow_view_1      = base_path() . '/customize/suit/media/men/glow_mask/vestpocket/Vest_Breast-Pocket_shad.png';
        $mask_view_1      = base_path() . '/customize/suit/media/men/glow_mask/vestpocket/Vest_Breast-Pocket_mask.png';
        $highlight_view_1 = base_path() . '/customize/suit/media/men/glow_mask/vestpocket/Vest_Breast-Pocket_hi.png';

        $glow_view_2      = base_path() . '/customize/suit/media/men/glow_mask/vestpocket/blank.png';
        $mask_view_2      = base_path() . '/customize/suit/media/men/glow_mask/vestpocket/blank.png';
        $highlight_view_2 = base_path() . '/customize/suit/media/men/glow_mask/vestpocket/blank.png';

        if ($glow_view_1 && $mask_view_1 && $highlight_view_1){
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_1_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //convert
            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_1_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_1_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //glow
            $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_1_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_1_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //highlight
            $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_1_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_1_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
        }

        if ($glow_view_2 && $mask_view_2 && $highlight_view_2){
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_2_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //convert
            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_2_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_2_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //glow
            $cmd = 'composite ' . $glow_view_2 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_2_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_2_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //highlight
            $cmd = 'composite ' . $highlight_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_2_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/vestbreastpocket/' . $fabric_id . '_style_2_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        // vest breast pockets end.
        /* Vest Generation Ends */

        // Read JSON file
        // suit pockets..
        $jsonPockets = file_get_contents(base_path().'/customize/suit/JSON/Generation/SuitPockets.json');
        //Decode JSON
        $suitPockets_collection = json_decode($jsonPockets,true);

        foreach ($suitPockets_collection as $suitPockets){

            $suitPocketsId = $suitPockets['suitpocket_id'];
            //left view 1
            $left_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['left_glow_image'];
            $left_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['left_mask_image'];
            $left_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['left_hi_image'];


            if ($suitPockets['left_glow_image'] && $suitPockets['left_mask_image'] && $suitPockets['left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $left_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $left_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $left_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }
            // echo "done suit pockets"; die;

            //right view 1
            $right_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['right_glow_image'];
            $right_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['right_mask_image'];
            $right_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['right_hi_image'];

            if ($suitPockets['right_glow_image'] && $suitPockets['right_mask_image'] && $suitPockets['right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $right_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $right_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $right_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //ticket view 1
            $ticket_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['ticket_glow_image'];
            $ticket_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['ticket_mask_image'];
            $ticket_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['ticket_hi_image'];

            if ($suitPockets['ticket_glow_image'] && $suitPockets['ticket_mask_image'] && $suitPockets['ticket_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $ticket_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $ticket_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $ticket_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            // $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_style_'. $suitPocketsId .'_view_1.png';

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_styletype_' . 1 .'_style_'. $suitPocketsId .'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            // Casual Style Pockets

            //left view 1
            $left_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_left_glow'];
            $left_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_left_mask'];
            $left_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_left_hi'];

            if ($suitPockets['casual_left_glow'] && $suitPockets['casual_left_mask'] && $suitPockets['casual_left_hi']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $left_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $left_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $left_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //right view 1
            $right_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_right_glow'];
            $right_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_right_mask'];
            $right_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_right_hi'];

            if ($suitPockets['casual_right_glow'] && $suitPockets['casual_right_mask'] && $suitPockets['casual_right_hi']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $right_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $right_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $right_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //ticket view 1
            $ticket_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_ticket_glow'];
            $ticket_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_ticket_mask'];
            $ticket_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_ticket_hi'];

            if ($suitPockets['casual_ticket_glow'] && $suitPockets['casual_ticket_mask'] && $suitPockets['casual_ticket_hi']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $ticket_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $ticket_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $ticket_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            // $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_view_1.png';

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_styletype_4_style_' . $suitPocketsId .'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        //breast pocket
        $glow_view_1      = base_path() . '/customize/suit/media/men/glow_mask/suitpockets/Bresat_Pocket_shad.png';
        $mask_view_1      = base_path() . '/customize/suit/media/men/glow_mask/suitpockets/Bresat_Pocket_mask.png';
        $highlight_view_1 = base_path() . '/customize/suit/media/men/glow_mask/suitpockets/Bresat_Pocket_hi.png';

        if ($glow_view_1 && $mask_view_1 && $highlight_view_1) {
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //convert
            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //glow
            $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //highlight
            $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
        }

        // suit sleeves..
        $jsonSleeve = file_get_contents(base_path().'/customize/suit/JSON/Generation/Suit_Sleeves.json');
        // Decode JSON
        $suitSeeve_collection = json_decode($jsonSleeve,true);

        $i=0;
        foreach($suitSeeve_collection as $suitSleeves){
            $suitSleevesId = $suitSleeves['suitsleeves_id'];
            //left view 1
            $left_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitSleeves['left_glow_image'];
            $left_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitSleeves['left_mask_image'];
            $left_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitSleeves['left_hi_image'];

            if ($suitSleeves['left_glow_image'] && $suitSleeves['left_mask_image'] && $suitSleeves['left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $left_mask_view_1 . ' ' . $wave_left . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $left_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $left_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //right view 1
            $right_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitSleeves['right_glow_image'];
            $right_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitSleeves['right_mask_image'];
            $right_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitSleeves['right_hi_image'];

            if ($suitSleeves['right_glow_image'] && $suitSleeves['right_mask_image'] && $suitSleeves['right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $right_mask_view_1 . ' ' . $wave_right . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $right_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $right_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //Compose Left and Right Sleeves View 1

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id .'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id .'_view_3.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            //left view 2
            $left_back_glow_view_2      = base_path() . '/customize/suit/media/men/' . $suitSleeves['back_left_glow_image'];
            $left_back_mask_view_2      = base_path() . '/customize/suit/media/men/' . $suitSleeves['back_left_mask_image'];
            $left_back_highlight_view_2 = base_path() . '/customize/suit/media/men/' . $suitSleeves['back_left_hi_image'];

            if ($suitSleeves['back_left_glow_image'] && $suitSleeves['back_left_mask_image'] && $suitSleeves['back_left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $left_back_mask_view_2 . ' ' . $wave_right . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $left_back_glow_view_2 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $left_back_highlight_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //right view 2
            $right_back_glow_view_2      = base_path() . '/customize/suit/media/men/' . $suitSleeves['back_right_glow_image'];
            $right_back_mask_view_2      = base_path() . '/customize/suit/media/men/' . $suitSleeves['back_right_mask_image'];
            $right_back_highlight_view_2 = base_path() . '/customize/suit/media/men/' . $suitSleeves['back_right_hi_image'];

            if ($suitSleeves['back_right_glow_image'] && $suitSleeves['back_right_mask_image'] && $suitSleeves['back_right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $right_back_mask_view_2 . ' ' . $wave_left . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $right_back_glow_view_2 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $right_back_highlight_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            $i++;

            //Compose Left and Right Sleeves View 2

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id .'_view_2.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_left_view_2.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/sleeves/' . $fabric_id . '_suitsleeves_' . $suitSleevesId .'_right_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        // suit sleeves ebds.

        // Read JSON file
        // suit pockets..
        $jsonPockets = file_get_contents(base_path().'/customize/suit/JSON/Generation/Suit_Pockets.json');
        //Decode JSON
        $suitPockets_collection = json_decode($jsonPockets,true);
        //Print data
        foreach ($suitPockets_collection as $suitPockets) {
            $suitPocketsId = $suitPockets['suitpocket_id'];

            //left view 1
            $left_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['left_glow_image'];
            $left_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['left_mask_image'];
            $left_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['left_hi_image'];


            if ($suitPockets['left_glow_image'] && $suitPockets['left_mask_image'] && $suitPockets['left_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $left_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $left_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $left_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //right view 1
            $right_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['right_glow_image'];
            $right_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['right_mask_image'];
            $right_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['right_hi_image'];

            if ($suitPockets['right_glow_image'] && $suitPockets['right_mask_image'] && $suitPockets['right_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $right_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $right_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $right_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //ticket view 1
            $ticket_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['ticket_glow_image'];
            $ticket_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['ticket_mask_image'];
            $ticket_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['ticket_hi_image'];

            if ($suitPockets['ticket_glow_image'] && $suitPockets['ticket_mask_image'] && $suitPockets['ticket_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $ticket_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $ticket_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $ticket_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_ticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_styletype_' . $suitPocketsId .'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_pockets_' . $suitPocketsId .'_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            /* Casual Style Pockets **/

            //left view 1
            $left_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_left_glow'];
            $left_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_left_mask'];
            $left_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_left_hi'];

            if ($suitPockets['casual_left_glow'] && $suitPockets['casual_left_mask'] && $suitPockets['casual_left_hi']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $left_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $left_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $left_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //right view 1
            $right_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_right_glow'];
            $right_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_right_mask'];
            $right_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_right_hi'];

            if ($suitPockets['casual_right_glow'] && $suitPockets['casual_right_mask'] && $suitPockets['casual_right_hi']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $right_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $right_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $right_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //ticket view 1
            $ticket_glow_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_ticket_glow'];
            $ticket_mask_view_1      = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_ticket_mask'];
            $ticket_highlight_view_1 = base_path() . '/customize/suit/media/men/' . $suitPockets['casual_ticket_hi'];

            if ($suitPockets['casual_ticket_glow'] && $suitPockets['casual_ticket_mask'] && $suitPockets['casual_ticket_hi']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $ticket_mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $ticket_glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $ticket_highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casualticketpockets_' . $suitPocketsId .'_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_left_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pockets/' . $fabric_id . '_casual_pockets_' . $suitPocketsId .'_right_view_1.png';
            exec($cmd);
            //$this->connection->query($query);

        }
        // suit pockets ends.

        // Suit Back Collar
        $glow_collar_view_2      = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/backCollar_shad.png';
        $mask_collar_view_2      = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/backCollar_mask.png';
        $highlight_collar_view_2 = base_path() . '/customize/suit/media/men/glow_mask/suitcollars/backCollar_hi.png';

        if ($glow_collar_view_2!='' && $mask_collar_view_2!='' && $highlight_collar_view_2!='') {
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $mask_collar_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_1_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
            //convert
            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_1_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_1_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
            //glow
            $cmd = 'composite ' . $glow_collar_view_2 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_1_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_1_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
            //highlight
            $cmd = 'composite ' . $highlight_collar_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_1_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_1_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        // Suit Collars
        // Suit Necklining
        $glow_necklining_view_2      = base_path() . '/customize/suit/media/men/glow_mask/suitnecklining/NeckLining_shad.png';
        $mask_necklining_view_2      = base_path() . '/customize/suit/media/men/glow_mask/suitnecklining/NeckLining_mask.png';
        $highlight_necklining_view_2 = base_path() . '/customize/suit/media/men/glow_mask/suitnecklining/NeckLining_hi.png';

        if ($glow_necklining_view_2!='' && $mask_necklining_view_2!='' && $highlight_necklining_view_2!='') {
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $mask_necklining_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_2_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
            //convert
            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_2_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_2_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
            //glow
            $cmd = 'composite ' . $glow_necklining_view_2 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_2_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_2_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
            //highlight
            $cmd = 'composite ' . $highlight_necklining_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_2_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/backcollar/' . $fabric_id . '_style_2_view_2.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        // suit backcollar ends.

        //suit breast pocket
        $glow_view_1      = base_path() . '/customize/suit/media/men/glow_mask/suitpockets/Bresat_Pocket_shad.png';
        $mask_view_1      = base_path() . '/customize/suit/media/men/glow_mask/suitpockets/Bresat_Pocket_mask.png';
        $highlight_view_1 = base_path() . '/customize/suit/media/men/glow_mask/suitpockets/Bresat_Pocket_hi.png';

        if ($glow_view_1 && $mask_view_1 && $highlight_view_1){
            //mask
            $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/breastpocket/' . $fabric_id . '_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //convert
            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/breastpocket/' . $fabric_id . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/breastpocket/' . $fabric_id . '_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //glow
            $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/breastpocket/' . $fabric_id . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/breastpocket/' . $fabric_id . '_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
            //highlight
            $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/breastpocket/' . $fabric_id . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/breastpocket/' . $fabric_id . '_view_1.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        // suit breast pocket ends.

        /*  Suit Jacket Generation Ends. */



        /* Suit Pant Generation Starts. */
        // Read JSON file
        // pant Fit..
        $rows_fit = file_get_contents(base_path().'/customize/suit/JSON/Generation/PantFit.json');
        //Decode JSON
        $rows_fits = json_decode($rows_fit,true);
        foreach ($rows_fits as $fit) {

            $pantfit_id = $fit['pantfit_id'];

            $fit_glow = base_path() . '/customize/suit/media/men/' . $fit['glow_image'];
            $fit_mask = base_path() . '/customize/suit/media/men/' . $fit['mask_image'];
            $fit_highlighted = base_path() . '/customize/suit/media/men/' . $fit['hi_image'];

            if ($fit['glow_image'] != '' && $fit['mask_image'] != '' && $fit['hi_image'] != '') {
                //mask changed
                $cmd = 'composite -compose Dst_In  -gravity center ' . $fit_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_1.png ' . $fit_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlighted
                $cmd = 'composite ' . $fit_highlighted . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }


            $fit_back_glow   = base_path() . '/customize/suit/media/men/' . $fit['back_glow_image'];
            $fit_back_mask   = base_path() . '/customize/suit/media/men/' . $fit['back_mask_image'];
            $fit_back_hi     = base_path() . '/customize/suit/media/men/' . $fit['back_hi_image'];

            if ($fit['back_glow_image'] != '' && $fit['back_mask_image'] != '' && $fit['back_hi_image'] != '') {
                //mask changed

                $cmd = 'composite -compose Dst_In  -gravity center ' . $fit_back_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_2.png ' . $fit_back_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlighted
                $cmd = 'composite ' . $fit_back_hi . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            $fit_folded_straight_glow   = base_path() . '/customize/suit/media/men/' . $fit['folded_straight_glow_image'];
            $fit_folded_straight_mask   = base_path() . '/customize/suit/media/men/' . $fit['folded_straight_mask_image'];
            $fit_folded_straight_hi     = base_path() . '/customize/suit/media/men/' . $fit['folded_straight_hi_image'];

            if ($fit['folded_straight_glow_image'] != '' && $fit['folded_straight_mask_image'] != '' && $fit['folded_straight_hi_image'] != '') {
                //mask changed

                $cmd = 'composite -compose Dst_In  -gravity center ' . $fit_folded_straight_mask . ' ' . $fabric_90 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png ' . $fit_folded_straight_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlighted
                $cmd = 'composite ' . $fit_folded_straight_hi . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            $fit_folded_tilted_glow   = base_path() . '/customize/suit/media/men/' . $fit['folded_tilted_glow_image'];
            $fit_folded_tilted_mask   = base_path() . '/customize/suit/media/men/' . $fit['folded_tilted_mask_image'];
            $fit_folded_tilted_hi     = base_path() . '/customize/suit/media/men/' . $fit['folded_tilted_hi_image'];

            if ($fit['folded_tilted_glow_image'] != '' && $fit['folded_tilted_mask_image'] != '' && $fit['folded_tilted_hi_image'] != '') {
                //mask changed

                $cmd = 'composite -compose Dst_In  -gravity center ' . $fit_folded_tilted_mask . ' ' . $fabric_60 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png ' . $fit_folded_tilted_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlighted
                $cmd = 'composite ' . $fit_folded_tilted_hi . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
            }


            $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_3.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_tilt_' . $pantfit_id . '_view_3.png';
            exec($cmd);
            //$this->connection->query($query);

            $cmd = 'rm -rf '.base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_pantfit_straight_' . $pantfit_id . '_view_3.png';
            exec($cmd);
            //$this->connection->query($query);
        }
        // suit pant fit ends.

        // pant cuffs..
        // Read JSON file
        $rows_cuffs = file_get_contents(base_path().'/customize/suit/JSON/Generation/PantCuffs.json');
        //Decode JSON
        $cuff_collection = json_decode($rows_cuffs,true);
        foreach ($cuff_collection as $cuff) {

            $pantcuff_id = $cuff['pantcuff_id'];

            $cuff_glow        = base_path() . '/customize/suit/media/men/' . $cuff['glow_image'];
            $cuff_mask        = base_path() . '/customize/suit/media/men/' . $cuff['mask_image'];
            $cuff_highlighted = base_path() . '/customize/suit/media/men/' . $cuff['hi_image'];

            if ($cuff['glow_image'] != '' && $cuff['mask_image'] != '' && $cuff['hi_image'] != '') {
                //mask changed
                $cmd = 'composite -compose Dst_In  -gravity center ' . $cuff_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_1.png ' . $cuff_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlighted
                $cmd = 'composite ' . $cuff_highlighted . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_style_' . $pantcuff_id . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }


            $cuff_back_glow   = base_path() . '/customize/suit/media/men/' . $cuff['back_glow_image'];
            $cuff_back_mask   = base_path() . '/customize/suit/media/men/' . $cuff['back_mask_image'];
            $cuff_back_hi     = base_path() . '/customize/suit/media/men/' . $cuff['back_hi_image'];

            if ($cuff['back_glow_image'] != '' && $cuff['back_mask_image'] != '' && $cuff['back_hi_image'] != '') {
                //mask changed

                $cmd = 'composite -compose Dst_In  -gravity center ' . $cuff_back_mask . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_2.png ' . $cuff_back_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlighted
                $cmd = 'composite ' . $cuff_back_hi . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_style_' . $pantcuff_id . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            $cuff_folded_straight_glow   = base_path() . '/customize/suit/media/men/' . $cuff['folded_glow_image'];
            $cuff_folded_straight_mask   = base_path() . '/customize/suit/media/men/' . $cuff['folded_mask_image'];
            $cuff_folded_straight_hi     = base_path() . '/customize/suit/media/men/' . $cuff['folded_hi_image'];

            if ($cuff['folded_glow_image'] != '' && $cuff['folded_mask_image'] != '' && $cuff['folded_hi_image'] != '') {
                //mask changed

                $cmd = 'composite -compose Dst_In  -gravity center ' . $cuff_folded_straight_mask . ' ' . $fabric_60 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_3.png ' . $cuff_folded_straight_glow . ' -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlighted
                $cmd = 'composite ' . $cuff_folded_straight_hi . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_pantcuff_' . $pantcuff_id . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantcuff/' . $fabric_id . '_style_' . $pantcuff_id . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
            }
        }
        //Pant cuff ends.

        // Read JSON file
        // pant belt loop..
        $jsonBeltLoop = file_get_contents(base_path().'/customize/suit/JSON/Generation/PantBeltLoops.json');
        //Decode JSON
        $pantBeltLoops_collection = json_decode($jsonBeltLoop,true);
        //Print data
        foreach ($pantBeltLoops_collection as $pantBeltLoops) {
            $pantbeltloopid = $pantBeltLoops['pantbeltloops_id'];

            //view 1
            $glow_view_1      = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['glow_image'];
            $mask_view_1      = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['mask_image'];
            $highlight_view_1 = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['hi_image'];

            if ($pantBeltLoops['glow_image'] && $pantBeltLoops['mask_image'] && $pantBeltLoops['hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);

                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantbeltloopid . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantbeltloopid . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view 2
            $glow_view_2      = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['back_glow_image'];
            $mask_view_2      = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['back_mask_image'];
            $highlight_view_2 = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['back_hi_image'];

            if ($pantBeltLoops['back_glow_image'] && $pantBeltLoops['back_mask_image'] && $pantBeltLoops['back_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_2 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_2 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_2 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);

                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantbeltloopid . '_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantbeltloopid . '_view_2.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view 3
            $glow_view_3      = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['folded_glow_image'];
            $mask_view_3      = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['folded_mask_image'];
            $highlight_view_3 = base_path() . '/customize/suit/media/men/' . $pantBeltLoops['folded_hi_image'];

            if ($pantBeltLoops['back_glow_image'] && $pantBeltLoops['back_mask_image'] && $pantBeltLoops['back_hi_image']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_3 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_3 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_3 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);

                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantbeltloopid . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantbeltloopid . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
            }
        }

        // $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_1.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_new_view_1.png';
        // $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_2.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_2.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_new_view_2.png';
        // $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantbeltloops/' . $fabric_id . '_pantbeltloops_' . $pantbeltloopid . '_view_3.png -geometry +0+0 -composite ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantstyle/' . $fabric_id . '_style_' . $pantfit_id . '_new_view_3.png';
        // pant belt loop ends.

        // pant side pockets..
        // Read JSON file
        $rows_pockets = file_get_contents(base_path().'/customize/suit/JSON/Generation/PantPockets.json');
        //Decode JSON
        $pantsidepocket_collection = json_decode($rows_pockets,true);
        foreach ($pantsidepocket_collection as $back) {

            $pantsidepocketId = $back['pantsidepocket_id'];
            $sidepocket_static_id = "1";

            //view 1
            $glow_view_1 = base_path() . '/customize/suit/media/men/' . $back['glow_image_view_1'];
            $mask_view_1 = base_path() . '/customize/suit/media/men/' . $back['mask_image_view_1'];
            $highlight_view_1 = base_path() . '/customize/suit/media/men/' . $back['highlighted_image_view_1'];

            if ($back['glow_image_view_1'] && $back['mask_image_view_1'] && $back['highlighted_image_view_1']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view 3
            $glow_view_3 = base_path() . '/customize/suit/media/men/' . $back['glow_image_view_3'];
            $mask_view_3 = base_path() . '/customize/suit/media/men/' . $back['mask_image_view_3'];
            $highlight_view_3 = base_path() . '/customize/suit/media/men/' . $back['highlighted_image_view_3'];

            if ($back['glow_image_view_3'] && $back['mask_image_view_3'] && $back['highlighted_image_view_3']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_3 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_3 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_3 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpockets/' . 'style_' . $pantsidepocketId . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
            }

        }
        // pant side pockets end.

        // pant pleats.
        // Read JSON file
        $rows_pleats = file_get_contents(base_path().'/customize/suit/JSON/Generation/PantPleats.json');
        //Decode JSON
        $pantpleats_collection = json_decode($rows_pleats,true);
        foreach ($pantpleats_collection as $pantpleats){

            $pantpleatsId = $pantpleats['pantpleats_id'];
            $pantpleats_static_id = "1";

            //view 1
            $glow_view_1 = base_path() . '/customize/suit/media/men/' . $pantpleats['glow_image_view_1'];
            $mask_view_1 = base_path() . '/customize/suit/media/men/' . $pantpleats['mask_image_view_1'];
            $highlight_view_1 = base_path() . '/customize/suit/media/men/' . $pantpleats['highlighted_image_view_1'];


            if ($pantpleats['glow_image_view_1'] && $pantpleats['mask_image_view_1'] && $pantpleats['highlighted_image_view_1']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_1 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //convert
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_1.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_1 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_1 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_1.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_1.png';
                exec($cmd);
                //$this->connection->query($query);
            }

            //view 3

            $glow_view_3 = base_path() . '/customize/suit/media/men/' . $pantpleats['glow_image_view_3'];
            $mask_view_3 = base_path() . '/customize/suit/media/men/' . $pantpleats['mask_image_view_3'];
            $highlight_view_3 = base_path() . '/customize/suit/media/men/' . $pantpleats['highlighted_image_view_3'];

            if ($pantpleats['glow_image_view_3'] && $pantpleats['mask_image_view_3'] && $pantpleats['highlighted_image_view_3']) {
                //mask
                $cmd = 'composite -compose Dst_In -gravity center ' . $mask_view_3 . ' ' . $fabric_0 . ' -alpha Set ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //crop
                $cmd = 'convert ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_3.png -crop 500x1320+290+0  +repage ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //glow
                $cmd = 'composite ' . $glow_view_3 . ' -compose Multiply  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
                //highlight
                $cmd = 'composite ' . $highlight_view_3 . ' -compose Overlay  ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_3.png ' . base_path() . '/customize/suit/media/men/generated_suit_images/pantpleats/' . 'style_' . $pantpleatsId . '_view_3.png';
                exec($cmd);
                //$this->connection->query($query);
            }

        }
        // pant pleats end.
        /* Pant Generation Ends. */
        // image generation ends.
        /* Suit Image Generation End */

        return true;
    }

}