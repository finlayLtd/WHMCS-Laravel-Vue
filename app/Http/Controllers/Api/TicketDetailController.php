<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use sburina\Whmcs;
use App\Http\Controllers\Controller;

class TicketDetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $all_request = $request->input('params');
        $ticket_id = $all_request['id'];

        $ticket_detail = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetTicket',
            'ticketid' => $ticket_id,
        ]);

        return response()->json([
            'ticket_detail' => $ticket_detail,
        ]);
    }

    public function downloadFile(Request $request)
    {
        $all_request = $request->input('params');
        $reply_id = $all_request['id'];

        $sso_url = (new \Sburina\Whmcs\Client)->post([
            'action' => 'CreateSsoToken',
            'user_id' => Auth::user()->whmcs_id,
            'destination' => 'sso:custom_redirect',

            'sso_redirect_path' => 'dl.php?type=ar&id=' . $reply_id . '&i=0',
        ]);

        if ($sso_url['result'] == 'success') {
            return response()->json([
                'result' => 'success',
                'redirect_url' => $sso_url['redirect_url'],
            ]);
        } else {
            return response()->json([
                'result' => 'failed',
            ]);
        }
    }

    public function sendReply(Request $request)
    {
        $ticket_id = $request->ticket_id;
        $clientid = Auth::user()->client_id;
        if ($request->message) {
            $message = $request->message;
        } else
            $message = ' ';

        if ($request->file) {
            $addTicketReply = (new \Sburina\Whmcs\Client)->post([
                'action' => 'AddTicketReply',
                'ticketid' => $ticket_id,
                'clientid' => $clientid,
                'message' => $message,
                'attachments' => base64_encode(json_encode([['name' => $request->file('file')->getClientOriginalName(), 'data' => base64_encode(file_get_contents($request->file))]])),
            ]);
        } else {
            $addTicketReply = (new \Sburina\Whmcs\Client)->post([
                'action' => 'AddTicketReply',
                'ticketid' => $ticket_id,
                'clientid' => $clientid,
                'message' => $message,
            ]);
        }

        $ticket_detail = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetTicket',
            'ticketid' => $ticket_id,
        ]);

        return response()->json([
            'ticket_detail' => $ticket_detail,
        ]);
    }
}