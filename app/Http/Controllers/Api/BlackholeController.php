<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DOMDocument;
use DOMXPath;
use sburina\Whmcs;
use App\Enduser;
use App\Admin;
use App\Models\User;
use App\Models\Blackholes;

class BlackholeController extends Controller
{
    public function index(Request $request)
    {
        $all_request = $request->input('params');
        $ip = $all_request['ip'];

        $blackhole_ip = Blackholes::where('ip', $ip)->first();
        if ($blackhole_ip) {
            return response()->json([
                'result' => 'success',
                'message' => 'Yes. This IP address is blackholed in our system. Open a Support Ticket to resolve this blackhole, you need to request for a new IP for your server.',
            ]);
        }
        else return response()->json([
            'result' => 'success',
            'message' => 'Nope. This IP address is not blackholed in our system.',
        ]);
    } 
}