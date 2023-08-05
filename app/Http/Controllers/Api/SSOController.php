<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;
use sburina\Whmcs;
use App\Http\Controllers\Controller;

class SSOController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function invoice_detail_sso(Request $request)
    {
        $invoice_id = $request['params'];

        $sso_url = (new \Sburina\Whmcs\Client)->post([
            'action' => 'CreateSsoToken',
            'user_id' => Auth::user()->whmcs_id,
            'destination' => 'sso:custom_redirect',

            'sso_redirect_path' => 'viewinvoice.php?id=' . $invoice_id,
        ]);

        if ($sso_url['result'] == 'success') {
            return response()->json([
                'result' => 'success',
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        } else {
            return response()->json([
                'result' => 'failed',
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        }
    }

    public function add_funds_sso(Request $request)
    {

        $sso_url = (new \Sburina\Whmcs\Client)->post([
            'action' => 'CreateSsoToken',
            'user_id' => Auth::user()->whmcs_id,
            'destination' => 'sso:custom_redirect',
            'sso_redirect_path' => 'clientarea.php?action=addfunds',
        ]);

        if ($sso_url['result'] == 'success') {
            return response()->json([
                'result' => 'success',
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        } else {
            return response()->json([
                'result' => 'failed',
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        }
    }

    public function connect_vnc_sso(Request $request)
    {
        $sso_url = (new \Sburina\Whmcs\Client)->post([
            'action' => 'CreateSsoToken',
            'user_id' => Auth::user()->originUserData['id'],
            'destination' => 'sso:custom_redirect',
            'sso_redirect_path' => 'clientarea.php?action=productdetails&id=' . $request->relid . '&act=vnc&novnc=1&jsnohf=1&svs=' . $request->vpsid,
        ]);

        if ($sso_url['result'] == 'success') {
            return response()->json([
                'result' => 'success',
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        } else {
            return response()->json([
                'result' => 'failed',
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        }
    }

    public function get_analysis_data_sso(Request $request)
    {
        $sso_url = (new \Sburina\Whmcs\Client)->post([
            'action' => 'CreateSsoToken',
            'user_id' => Auth::user()->originUserData['id'],
            'destination' => 'sso:custom_redirect',
            'sso_redirect_path' => 'clientarea.php?action=productdetails&id=' . $request->relid . '&api=json&act=monitor&svs=' . $request->vpsid . '&show=' . date("Ym"),
        ]);

        if ($sso_url['result'] == 'success') {
            return response()->json([
                'result' => 'success',
                'token' => $sso_url['access_token'],
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        } else {
            return response()->json([
                'result' => 'failed',
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        }
    }




}