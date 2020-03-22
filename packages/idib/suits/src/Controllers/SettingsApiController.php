<?php
namespace Idib\Settings\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Idib\Settings\Models\SuitAccent;

class SettingsApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Idib Products API Controller
    |--------------------------------------------------------------------------
    |
    */


    /**
     * Return Main Information
     *
     * @param
     * @return
     */
    public function bankInformation(Request $request)
    {
        $bankName = SuitAccent::find(27)->value;
        $accountNumber = SuitAccent::find(28)->value;
        $ownerName = SuitAccent::find(29)->value;
        $result = [
            'status' => '1',
            'data' => [
                'bank_name' => $bankName,
                'bank_account_number' => $accountNumber,
                'bank_account_owner_name' => $ownerName]
        ];
        return $result;
    }

    /**
     * Return Main Information
     *
     * @param
     * @return
     */
    public function mainInformation(Request $request)
    {
        $address = SuitAccent::find(2)->value;
        $email = SuitAccent::find(3)->value;
        $phone = SuitAccent::find(4)->value;
        $bankName = SuitAccent::find(27)->value;
        $accountNumber = SuitAccent::find(28)->value;
        $ownerName = SuitAccent::find(29)->value;
        $phones = array();
        if($phone != ""){
            $phones = explode(',', $phone);
        }
        $result = [
            'status' => '1',
            'data' => [
                'address' => $address,
                'email' => $email,
                'phone' => $phones,
                'bank_name' => $bankName,
                'bank_account_number' => $accountNumber,
                'bank_account_owner_name' => $ownerName
            ]
        ];
        return $result;
    }
}