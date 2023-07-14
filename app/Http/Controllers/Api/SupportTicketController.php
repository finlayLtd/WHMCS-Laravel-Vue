<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use sburina\Whmcs;
use App\Http\Controllers\Controller;
class SupportTicketController extends Controller
{
   
    public function index(Request $request)
    {
        $orders = array();
        $departments = array();
        $tickets = array();
        $status = array();
        $tickets_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetTickets',
            'clientid' => $request->client_id, // Set number of tickets to retrieve per request
        ]);

        $tickets_status = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetSupportStatuses'
        ]);

        $order_info =  (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetOrders',
            'userid' => $request->client_id,
        ]);

        $departments_info =  (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetSupportDepartments'
        ]);
        if ($order_info['totalresults'] > 0) {
            $orders = $order_info['orders']['order'];
        }

        if ($departments_info['totalresults'] > 0) {
            $departments = $departments_info['departments']['department'];
        }


        if ($tickets_response['totalresults'] > 0) {
            $tickets = $tickets_response['tickets']['ticket'];
            if($request->order && $request->orderby)
            {
                if($request->order == 'desc') $tickets = collect($tickets)->sortByDesc($request->orderby)->values()->all();
                else  $tickets = collect($tickets)->sortBy($request->orderby)->values()->all();
            }
            
            
        }

        if ($tickets_status['totalresults'] > 0) {
            $status = $tickets_status['statuses']['status'];
        }

        return response()->json([
            'tickets' => $tickets,
            'status' => $status,
            'departments' => $departments,
            'orders' => $orders,
        ]);
        
    }

    public function supportlist(Request $request)
    {
        // 'orderby' => $request->orderby,
        // 'order' => $request->order,
        $orders = array();
        $departments = array();
        $tickets = array();
        $status = array();
        $tickets_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetTickets',

            'clientid' => $request->client_id, // Set number of tickets to retrieve per request
        ]);

        $tickets_status = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetSupportStatuses'
        ]);

        $order_info =  (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetOrders',
            'userid' => $request->client_id,
        ]);

        $departments_info =  (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetSupportDepartments'
        ]);
        if ($order_info['totalresults'] > 0) {
            $orders = $order_info['orders']['order'];
        }

        if ($departments_info['totalresults'] > 0) {
            $departments = $departments_info['departments']['department'];
        }


        if ($tickets_response['totalresults'] > 0) {
            $tickets = $tickets_response['tickets']['ticket'];
            if($request->order == 'desc') $tickets = collect($tickets)->sortByDesc($request->orderby)->values()->all();
            else  $tickets = collect($tickets)->sortBy($request->orderby)->values()->all();
            
        }

        if ($tickets_status['totalresults'] > 0) {
            $status = $tickets_status['statuses']['status'];
        }

        return view('tables/supporttable', compact('tickets', 'status', 'departments', 'orders'));
    }

    public function openticket(Request $request)
    {
        if ($request->message) {
            $message = $request->message;
        } else $message = ' ';

        $action_command_array = array(
            'action' => 'OpenTicket',
            'deptid' => $request->department,
            'subject' => $request->subject,
            'message' => $message,
            'clientid' => $request->client_id
        );
        if ($request->service != 0) $action_command_array['serviceid'] = $request->service;

        $created_ticket_info =  (new \Sburina\Whmcs\Client)->post($action_command_array);

        return redirect()->route('support-ticket');
    }
}
