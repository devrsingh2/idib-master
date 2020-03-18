<?php

namespace Idib\Settings\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laracasts\Flash\Flash;
use Idib\Settings\Models\SuitAccent;

use DB;
use Lang;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editInformation()
    {
        $name = SuitAccent::find(1)->value;
        $address = SuitAccent::find(2)->value;
        $email = SuitAccent::find(3)->value;
        $phone = SuitAccent::find(4)->value;
        $date_format = SuitAccent::find(5)->value;
        $pagination = SuitAccent::find(6)->value;
        $is_multilingual = SuitAccent::find(7)->value;

        return view('Settings::info', compact('name', 'address', 'email', 'phone', 'date_format', 'pagination','is_multilingual'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateInformation(Request $request)
    {
        $name = $request->name;
        $address = $request->address;
        $email = $request->email;
        $phone = $request->phone;
        $date_format = $request->date_format;
        $pagination = $request->pagination;
        $is_multilingual = $request->is_multilingual;

        $nameSetting = SuitAccent::find(1);
        $addressSetting = SuitAccent::find(2);
        $emailSetting = SuitAccent::find(3);
        $phoneSetting = SuitAccent::find(4);
        $dateFormatSetting = SuitAccent::find(5);
        $paginationSetting = SuitAccent::find(6);
        $isMultilingual = SuitAccent::find(7);

        $nameSetting->value = $name;
        $addressSetting->value = $address;
        $emailSetting->value = $email;
        $phoneSetting->value = $phone;
        $dateFormatSetting->value = $date_format;
        $paginationSetting->value = $pagination;
        $isMultilingual->value = $is_multilingual;

        $nameSetting->save();
        $addressSetting->save();
        $emailSetting->save();
        $phoneSetting->save();
        $dateFormatSetting->save();
        $paginationSetting->save();
        $isMultilingual->save();

        \Session::flash('alert-class', 'alert-success');
        \Session::flash('message', trans('Settings::settings.updated_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editSmtp()
    {
        $driver = SuitAccent::find(8)->value;
        $host = SuitAccent::find(9)->value;
        $port = SuitAccent::find(10)->value;
        $username = SuitAccent::find(11)->value;
        $password = SuitAccent::find(12)->value;
        $address = SuitAccent::find(13)->value;
        $name = SuitAccent::find(14)->value;
        $encryption = SuitAccent::find(15)->value;
        return view('Settings::smtp', compact('driver', 'host', 'port', 'username', 'password', 'address', 'name', 'encryption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSmtp(Request $request)
    {
        $driver = $request->driver;
        $host = $request->host;
        $port = $request->port;
        $username = $request->username;
        $password = $request->password;
        $address = $request->address;
        $name = $request->name;
        $encryption = $request->encryption;

        $driverSetting = SuitAccent::find(8);
        $hostSetting = SuitAccent::find(9);
        $portSetting = SuitAccent::find(10);
        $usernameSetting = SuitAccent::find(11);
        $passwordSetting = SuitAccent::find(12);
        $addressSetting = SuitAccent::find(13);
        $nameSetting = SuitAccent::find(14);
        $encryptionSetting = SuitAccent::find(15);

        $driverSetting->value = $driver;
        $hostSetting->value = $host;
        $portSetting->value = $port;
        $usernameSetting->value = $username;
        $passwordSetting->value = $password;
        $addressSetting->value = $address;
        $nameSetting->value = $name;
        $encryptionSetting->value = $encryption;

        $driverSetting->save();
        $hostSetting->save();
        $portSetting->save();
        $usernameSetting->save();
        $passwordSetting->save();
        $addressSetting->save();
        $nameSetting->save();
        $encryptionSetting->save();

        \Session::flash('alert-class', 'alert-success');
        \Session::flash('message', trans('Settings::settings.updated_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editSocialAccounts()
    {
        $facebook = SuitAccent::find(16)->value;
        $twitter = SuitAccent::find(17)->value;
        $gplus = SuitAccent::find(18)->value;
        $instagram = SuitAccent::find(19)->value;
//        $youtube = Setting::where('name', 'social_accounts')->where('key', 'youtube')->first();
//        $youtube = $youtube->value;
        return view('Settings::social_accounts', compact('facebook', 'twitter', 'gplus', 'instagram'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSocialAccounts(Request $request)
    {
        $facebookSetting = SuitAccent::find(16);
        $twitterSetting = SuitAccent::find(17);
        $gplusSetting = SuitAccent::find(18);
        $instagramSetting = SuitAccent::find(19);
//        $youtubeSetting = Setting::where('name', 'social_accounts')->where('key', 'youtube')->first();

        $facebookSetting->value = $request->facebook;
        $twitterSetting->value = $request->twitter;
        $gplusSetting->value = $request->gplus;
        $instagramSetting->value = $request->instagram;
//        $youtubeSetting->value = $request->youtube;

        $facebookSetting->save();
        $twitterSetting->save();
        $gplusSetting->save();
        $instagramSetting->save();
//        $youtubeSetting->save();

        \Session::flash('alert-class', 'alert-success');
        \Session::flash('message', trans('Settings::settings.updated_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editAppLinks()
    {
        $apple = SuitAccent::find(20)->value;
        $google = SuitAccent::find(21)->value;
        return view('Settings::app_links', compact('apple', 'google'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAppLinks(Request $request)
    {
        $apple = $request->apple;
        $google = $request->google;

        $appleSetting = SuitAccent::find(20);
        $googleSetting = SuitAccent::find(21);

        $appleSetting->value = $apple;
        $googleSetting->value = $google;

        $appleSetting->save();
        $googleSetting->save();

        \Session::flash('alert-class', 'alert-success');
        \Session::flash('message', trans('Settings::settings.updated_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editSeo()
    {
        $keywords = SuitAccent::find(22)->value;
        $description = SuitAccent::find(23)->value;

        return view('Settings::seo', compact('keywords', 'description'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSeo(Request $request)
    {
        $keywords = $request->keywords;
        $description = $request->description;

        $keywordsSetting = SuitAccent::find(22);
        $descriptionSetting = SuitAccent::find(23);

        $keywordsSetting->value = $keywords;
        $descriptionSetting->value = $description;

        $keywordsSetting->save();
        $descriptionSetting->save();

        \Session::flash('alert-class', 'alert-success');
        \Session::flash('message', trans('Settings::settings.updated_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editFcm()
    {
        if(!Gate::allows('hasPermission', ['fcm', 'settings'])){
            return view('errors.403');
        }

        $serverKey = SuitAccent::find(24)->value;

        return view('Settings::fcm', compact('serverKey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFcm(Request $request)
    {
        $serverKey = $request->server_key;

        $serverKeySetting = SuitAccent::find(24);

        $serverKeySetting->value = $serverKey;

        $serverKeySetting->save();

        \Session::flash('alert-class', 'alert-success');
        \Session::flash('message', trans('Settings::settings.updated_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editSms()
    {
        $url = SuitAccent::find(25)->value;
        $username = SuitAccent::find(26)->value;
        $password = SuitAccent::find(27)->value;
        $sender = SuitAccent::find(28)->value;

        return view('Settings::sms', compact('url', 'username', 'password', 'sender'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSms(Request $request)
    {
        $url = $request->url;
        $username = $request->username;
        $password = $request->password;
        $sender = $request->sender;

        $urlSetting = SuitAccent::find(25);
        $usernameSetting = SuitAccent::find(26);
        $passwordSetting = SuitAccent::find(27);
        $senderSetting = SuitAccent::find(28);

        $urlSetting->value = $url;
        $usernameSetting->value = $username;
        $passwordSetting->value = $password;
        $senderSetting->value = $sender;

        $urlSetting->save();
        $usernameSetting->save();
        $passwordSetting->save();
        $senderSetting->save();

        \Session::flash('alert-class', 'alert-success');
        \Session::flash('message', trans('Settings::settings.updated_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function editMaintenanceMode()
    {
        $mode = SuitAccent::find(29)->value;
        return view('Settings::maintenance_mode', compact('mode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMaintenanceMode(Request $request)
    {
        $mode = $request->mode;
        $modeSetting = SuitAccent::find(29);
        $modeSetting->value = $mode;
        $modeSetting->save();

        \Session::flash('alert-class', 'alert-success');
        \Session::flash('message', trans('Settings::settings.updated_successfully'));
        return back();
    }


    /**
     * insert locations(countries/states)
     */
    public function insertLocations()
    {
        ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
        // Name of the file
        $target_file = public_path().'/imp/countries.csv';
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        $uploadOk = 1;
        if($imageFileType != "csv" ) {
            $uploadOk = 0;
        }
        if ($uploadOk != 0) {
            // Reading file
            $file = fopen($target_file,"r");
            $i = 0;

            $importData_arr = array();

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($data);

                for ($c=0; $c < $num; $c++) {
                    $importData_arr[$i][] = $data[$c];
                }
                $i++;
            }
            fclose($file);

            $skip = 0;
            // insert import data
            foreach($importData_arr as $cData){
                if($skip != 0){
                    $countryId = $cData[0];
                    $iso2 = $cData[1];
                    $countryName = $cData[2];
                    $phone_code = $cData[3];
                    // Checking duplicate entry
                    $countryCount = \Idib\Locations\Models\Country::where(array('iso2'=> trim($iso2)))->count();
                    if($countryCount == 0){
                        // Insert record
                        $country = new \Idib\Locations\Models\Country;
                        $author = \auth()->user()->id;

                        $country->created_by = $author;
                        $country->updated_by = $author;
                        $country->iso2 = $iso2;
                        $country->flag = $iso2.'.png';

                        $country->active = true;
                        $country->save();
                        // Translation data
                        $countryTrans = new \Idib\Locations\Models\CountryTrans;
                        $countryTrans->country_id = $country->id;
//                        $countryTrans->iso_code = $iso2;
                        $countryTrans->iso3 = "";
                        $countryTrans->phone_code = $phone_code;
                        $countryTrans->phone_length = "";
                        $countryTrans->name = $countryName;
                        $countryTrans->lang = 'en';
                        $countryTrans->save();

                    }
                }
                $skip ++;
            }
        }
        //insert into state table
        $target_file = public_path().'/imp/states.csv';
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        $uploadOk = 1;
        if($imageFileType != "csv" ) {
            $uploadOk = 0;
        }
        if ($uploadOk != 0) {
            // Reading file
            $file = fopen($target_file,"r");
            $i = 0;

            $importData_arr = array();

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($data);

                for ($c=0; $c < $num; $c++) {
                    $importData_arr[$i][] = $data[$c];
                }
                $i++;
            }
            fclose($file);

            $skip = 0;
            // insert import data
            foreach($importData_arr as $cData){
                if($skip != 0){
                    $stateId = $cData[0];
                    $stateName = $cData[1];
                    $countryId = $cData[2];
                    // Checking duplicate entry
                    $stateCount = \Idib\Locations\Models\StateTrans::where(array('name'=> trim($stateName), 'lang'=> 'en'))->count();
                    if($stateCount == 0){
                        // Insert record
                        $state = new \Idib\Locations\Models\State;
                        $author = \auth()->user()->id;
                        $state->country_id = $countryId;
                        $state->created_by = $author;
                        $state->updated_by = $author;

                        $state->active = true;

                        $state->save();
                        // Translation data
                        $stateTrans = new \Idib\Locations\Models\StateTrans;
                        $stateTrans->state_id = $state->id;
                        $stateTrans->name = $stateName;
                        $stateTrans->lang = 'en';
                        $stateTrans->save();

                    }
                }
                $skip ++;
            }
        }
        //cities
        $target_file = public_path().'/imp/cities.csv';
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        $uploadOk = 1;
        if($imageFileType != "csv" ) {
            $uploadOk = 0;
        }
        if ($uploadOk != 0) {
            // Reading file
            $file = fopen($target_file,"r");
            $i = 0;

            $importData_arr = array();

            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($data);

                for ($c=0; $c < $num; $c++) {
                    $importData_arr[$i][] = $data[$c];
                }
                $i++;
            }
            fclose($file);

            $skip = 0;
            // insert import data
            foreach($importData_arr as $cData){
                if($skip != 0){
                    $cityId = $cData[0];
                    $cityName = $cData[1];
                    $stateId = $cData[2];
//                    echo '<pre>'; print_r($cData);
                    // Checking duplicate entry
                    $cityCount = \Idib\Locations\Models\CityTrans::where(array('name'=> trim($cityName), 'lang'=> 'en'))->count();
                    if($cityCount == 0){
                        // Insert record
                        $city = new \Idib\Locations\Models\City;
                        $author = \auth()->user()->id;
//                        $city->country_id = $countryId;
                        $city->state_id = $stateId;
                        $city->created_by = $author;
                        $city->updated_by = $author;

                        $city->active = true;

                        $city->save();
                        // Translation data
                        $cityTrans = new \Idib\Locations\Models\CityTrans;
                        $cityTrans->city_id = $city->id;
                        $cityTrans->name = $cityName;
                        $cityTrans->lang = 'en';
                        $cityTrans->save();

                    }
                }
                $skip ++;
            }
        }
//        die;
        return redirect(action('\Idib\Locations\Controllers\CountriesController@index'));
    }

}