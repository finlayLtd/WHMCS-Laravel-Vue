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

        $order_info = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetOrders',
            'userid' => $request->client_id,
        ]);

        if ($order_info['result'] == 'success') {
            if ($order_info['totalresults'] > 0) {
                $orders = $order_info['orders']['order'];
            }
        }

        $departments_info = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetSupportDepartments'
        ]);

        if ($departments_info['result'] == 'success') {
            if ($departments_info['totalresults'] > 0) {
                $departments = $departments_info['departments']['department'];
            }
        }

        if ($tickets_response['result'] == 'success') {
            if ($tickets_response['totalresults'] > 0) {
                $tickets = $tickets_response['tickets']['ticket'];
                if ($request->order && $request->orderby) {
                    if ($request->order == 'desc')
                        $tickets = collect($tickets)->sortByDesc($request->orderby)->values()->all();
                    else
                        $tickets = collect($tickets)->sortBy($request->orderby)->values()->all();
                }
            }
        }

        if ($tickets_status['result'] == 'success') {
            if ($tickets_status['totalresults'] > 0) {
                $status = $tickets_status['statuses']['status'];
            }
        }

        $perPage = 8; // Number of items per page
        $page = $request->input('page', 1); // Get the current page number (default to 1 if not provided)

        // Calculate the offset for pagination
        $offset = ($page - 1) * $perPage;

        // Extract a slice of the tickets array based on the current page and number of items per page
        $totalTickets = count($tickets);
        //$pagedTickets = array_slice($tickets, $offset, $perPage);

        return response()->json([
            'totalTickets' => $totalTickets,
            'perPage' => $perPage,
            'page' => $page,
            'tickets' => $tickets,
            'status' => $status,
            'departments' => $departments,
            'orders' => $orders,
        ]);

    }

    public function supportlist(Request $request)
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

        $order_info = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetOrders',
            'userid' => $request->client_id,
        ]);

        $departments_info = (new \Sburina\Whmcs\Client)->post([
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
            if ($request->order == 'desc')
                $tickets = collect($tickets)->sortByDesc($request->orderby)->values()->all();
            else
                $tickets = collect($tickets)->sortBy($request->orderby)->values()->all();

        }

        if ($tickets_status['totalresults'] > 0) {
            $status = $tickets_status['statuses']['status'];
        }

        return view('tables/supporttable', compact('tickets', 'status', 'departments', 'orders'));
    }

    public function openticket(Request $request)
    {
        $all_request = $request->input('params');
        $tickets = [];

        if ($all_request['message']) {
            $message = $all_request['message'];
        } else
            $message = ' ';

        $action_command_array = array(
            'action' => 'OpenTicket',
            'deptid' => $all_request['department'],
            'subject' => $all_request['subject'],
            'message' => $message,
            'clientid' => Auth::user()->client_id
        );

        if ($all_request['service'] != 0)
            $action_command_array['serviceid'] = $all_request['service'];

        $created_ticket_info = (new \Sburina\Whmcs\Client)->post($action_command_array);

        $tickets_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetTickets',
            'clientid' => Auth::user()->client_id, // Set number of tickets to retrieve per request
        ]);

        if ($tickets_response['totalresults'] > 0) {
            $tickets = $tickets_response['tickets']['ticket'];
            $tickets = collect($tickets)->sortByDesc($request->orderby)->values()->all();
        }

        if ($created_ticket_info['result'] == 'success') {
            return response()->json([
                'result' => 'success',
                'data' => $created_ticket_info,
                'tickets' => $tickets,
            ]);
        } else {
            return response()->json([
                'result' => 'failed',
                'data' => $created_ticket_info,
            ]);
        }
    }
}