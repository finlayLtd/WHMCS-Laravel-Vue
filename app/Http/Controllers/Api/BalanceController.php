<?php



namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use sburina\Whmcs;
use App\Http\Controllers\Controller;

class BalanceController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $orderby = 'date';
        $order = 'desc';
        $perPage = 100;

        $totalresults = 0;
        $startnumber = 0;
        $numreturned = 0;

        if($request->order && $request->orderby)
        {
            $orderby = $request->orderby;
            $order = $request->order;
        } 
        
        $response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetInvoices',
            'orderby' => $orderby,
            'order' => $order,
            'limitstart' => 0,
            'limitnum' => $perPage, // Set number of tickets to retrieve per request
            'userid' => Auth::user()->client_id, // Set number of tickets to retrieve per request
        ]);


        if (count($response['invoices']) != 0) {
            $invoices = $response['invoices']['invoice'];
            $totalresults = $response['totalresults'];
            $startnumber = $response['startnumber'];
            $numreturned = $response['numreturned'];
        } else $invoices = [];

        return response()->json([
            'invoices' => $invoices,
            'totalresults' => $totalresults,
            'startnumber' => $startnumber,
            'numreturned' => $numreturned,
        ]);
    }

    public function invoiceDetail(Request $request)
    {
        $invoice_id  = $request->id;

        $invoice_detail = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetInvoice',
            'invoiceid' => $invoice_id,
        ]);

        return view('pages/invoice-detail', compact('invoice_id','invoice_detail'));
    }

    
}
