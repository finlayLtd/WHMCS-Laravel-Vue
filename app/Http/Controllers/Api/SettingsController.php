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
        $emails = [];
        $clientDetails = null;
        $users_list = [];
        $totalresults = 0;

        $email_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetEmails',
            'limitstart' => ($request->page - 1) * $request->perPage,
            'limitnum' => $request->perPage, // Set number of tickets to retrieve per request
            'clientid' => Auth::user()->client_id, // Set number of tickets to retrieve per request
        ]);
        if (count($email_response['emails']) != 0) {
            $emails = $email_response['emails']['email'];
            $totalresults = $email_response['totalresults'];
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
            'totalresults' => $totalresults,
            'clientDetails' => $clientDetails,
            'users_list' => $users_list,
        ]);
    }
    
}
