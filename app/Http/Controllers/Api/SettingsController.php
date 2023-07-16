<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use sburina\Whmcs;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // return view('pages/settings');
        $emails = [];
        $clientDetails = null;
        $users_list = [];

        $email_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetEmails',
            'limitstart' => 0,
            'limitnum' => 30, // Set number of tickets to retrieve per request
            'clientid' => Auth::user()->client_id, // Set number of tickets to retrieve per request
        ]);
        if (count($email_response['emails']) != 0) {
            $emails = $email_response['emails']['email'];
        } 

        $check_user_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetClientsDetails',
            'clientid' => Auth::user()->client_id, //The ID of the client the invite is for
        ]);

        if($check_user_response['result'] == 'success'){
            $users_list = $check_user_response['client']['users']['user'];
            $clientDetails = $check_user_response;
        }

        return response()->json([
            'emails' => $emails,
            'clientDetails' => $clientDetails,
            'users_list' => $users_list,
        ]);
    }

    // public function settings_password()
    // {
    //     return view('pages/settings_password');
    // }

    // public function settings_userManage()
    // {
    //     $users_list = [];
    //     $check_user_response = (new \Sburina\Whmcs\Client)->post([
    //         'action' => 'GetClientsDetails',
    //         'clientid' => Auth::user()->client_id, //The ID of the client the invite is for
    //     ]);
    //     if($check_user_response['result'] == 'success'){
    //         $users_list = $check_user_response['client']['users']['user'];
    //     }
    //     return view('pages/settings_userManage',compact('users_list'));
    // }

    // public function settings_emailHistory()
    // {
    //     $response = (new \Sburina\Whmcs\Client)->post([
    //         'action' => 'GetEmails',
    //         'limitstart' => 0,
    //         'limitnum' => 30, // Set number of tickets to retrieve per request
    //         'clientid' => Auth::user()->client_id, // Set number of tickets to retrieve per request
    //     ]);
    //     if (count($response['emails']) != 0) {
    //         $emails = $response['emails']['email'];
    //     } else $emails = [];
    //     return view('pages/settings_emailHistory', compact('emails'));
    // }


    
    
    
}
