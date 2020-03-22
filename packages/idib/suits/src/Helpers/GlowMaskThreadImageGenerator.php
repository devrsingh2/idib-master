<?php
/**
 * Created by PhpStorm.
 * User: rameshkumar
 * Date: 16/3/20
 * Time: 10:40 PM
 */

namespace Idib\Suits\Helpers;


class GlowMaskThreadImageGenerator
{

    public static function ThreadImageGenerator($id, $fileName, $destination){

        $fabric_id = $id;

        $fabric_thumb_name =  $fileName;
        $homepath = $destination;
        $fabricThumbImgpath = $homepath.$fabric_thumb_name;

        //suit tool path
        $tool_path = config('suits.suit_path');

        $fabricName = "fabric_main.png";
        $fabric_0 = $tool_path.'media/men/fab_suit_images/thread/' . $fabricName;
        //for zoom view
        $fabric_zoom = $tool_path."media/men/fab_suit_images/thread/fabric_zoom.png";
        $suitFabImgPath = $tool_path.'media/men/fab_suit_images/thread/';

        exec('convert -size 500x1320 tile:' . $fabricThumbImgpath . ' ' . $fabric_0);
        //zoom view fabirc
        exec('convert -size 1200x900 tile:' . $fabricThumbImgpath . ' ' . $fabric_zoom);
        //created for collar
        exec('convert ' . $fabric_zoom . ' -background "rgba(0,0,0,0.5)" -distort SRT 90 ' . $suitFabImgPath . 'fabric_main_back_zoom.png');
//        dd('convert ' . $fabric_zoom . ' -background "rgba(0,0,0,0.5)" -distort SRT 90 ' . $suitFabImgPath . 'fabric_main_back_zoom.png');
        // fabric generation ends for sizes..


        // threads generation start..
        $suit_single_1button_thread = $tool_path.'media/men/glow_mask/suitthreads/Thread_Single-Breasted_1Button_Mask.png';
        $suit_single_2button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Single-Breasted_2Button_Mask.png';
        $suit_single_3button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Single-Breasted_3Button_Mask.png';

        $suit_double_2button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Double-Breasted_2Buttons_Mask.png';
        $suit_double_4button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Double-Breasted_4Buttons_Mask.png';
        $suit_double_6button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Double-Breasted_6Buttons_Mask.png';

        // new thread styles
        $suit_double_4x1button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Double-Breasted_4x1Buttons_Mask.png';
        $suit_double_6x1button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Double-Breasted_6x1Buttons_Mask.png';

        $suit_mandarin_5button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Mandarin_5Buttons_Mask.png';

        $suit_casual_2button_thread = $tool_path.'media/men/glow_mask/suitthreads/Threads_Casual_2Button_Mask.png';

        $suit_sleeve_2button_thread = $tool_path.'media/men/glow_mask/suitthreads/Thread_Sleeve_2Button_Mask.png';
        $suit_sleeve_3button_thread = $tool_path.'media/men/glow_mask/suitthreads/Thread_Sleeve_3Button_Mask.png';
        $suit_sleeve_4button_thread = $tool_path.'media/men/glow_mask/suitthreads/Thread_Sleeve_4Button_Mask.png';

        $jsonthreads = file_get_contents($tool_path.'JSON/Generation/ThreadJson.json');
        //Decode JSON
        $thread_collection = json_decode($jsonthreads,true);
//        dd($thread_collection);
        $fabric_t = $tool_path.'media/men/fab_suit_images/';
        foreach ($thread_collection as $key => $value){
            $styleTypeId = $value['style_type'];
            $styleId = $value['suitbutton_id'];
            $mask = $tool_path.$value['thread_mask'];
            exec('composite -compose CopyOpacity ' . $mask . ' ' . $fabric_0 . ' ' . $tool_path.'media/men/generated_suit_images/threads/' . $fabric_id . '_styletype_'. $styleTypeId .'_style_'. $styleId .'_view_1.png');

        }
    }

}