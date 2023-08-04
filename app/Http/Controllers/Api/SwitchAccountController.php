<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use sburina\Whmcs;
use App\Http\Controllers\Controller;
use App\Virtualizor\Admin;

use App\Models\User;
use Str;
use Illuminate\Support\Arr;

class SwitchAccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $originUserData_reponse = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetUsers',
            'search' => Auth::user()->email,
        ]);

        $originUserData = $originUserData_reponse['users'][0];

        $clients = [];

        foreach ($originUserData['clients'] as $client) {
            $temp_response = (new \Sburina\Whmcs\Client)->post([
                'action' => 'GetClientsDetails',
                'clientid' => $client['id'], //The ID of the client the invite is for
            ]);
            if ($temp_response['result'] == 'success') {
                $user_instance = $temp_response['client'];
                array_push($clients, $user_instance);
            }
        }

        return response()->json([
            'clients' => $clients,
        ]);
    }

    public function switch (Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']

        $originUserData_reponse = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetUsers',
            'search' => Auth::user()->email,
        ]);

        $originUserData = $originUserData_reponse['users'][0];

        // default system to set the session again!(switch account)
        $userAttributes = [];
        $permissions = ['profile', 'contacts', 'products', 'manageproducts', 'productsso', 'domains', 'managedomains', 'invoices', 'quotes', 'tickets', 'affiliates', 'emails', 'orders'];

        $userAttributes = (array) (new \Sburina\Whmcs\Client)->post([
            'action' => 'getClientsDetails',
            'email' => $all_request['switching_email'],
        ]);

        $userAttributes['originUserData'] = $originUserData;

        $permission_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetUserPermissions',
            'client_id' => $userAttributes['client_id'],
            //The ID of the client the invite is for
            'user_id' => $userAttributes['originUserData']['id'],
        ]);

        if ($permission_response['result'] == 'success') {
            $permissions = $permission_response['permissions'];
        }

        $userAttributes['permissions'] = $permissions;

        $user = User::where('email', Auth::user()->email)->first();

        // update table
        if (!$user) {
            $user = new User();
        }

        $name = $userAttributes['firstname'];

        //client_id concept and user_id concept is different

        $user->client_id = $userAttributes['client_id'];
        $user->credit = $userAttributes['credit'];

        $user->permissions = implode(',', $userAttributes['permissions']);
        $user->name = $name;
        $user->save();

        return response()->json([
            'result' => 'success',
            'user' => $user,
        ]);
    }



}