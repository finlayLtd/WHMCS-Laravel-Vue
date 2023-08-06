<?php



namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use sburina\Whmcs;
use App\Http\Controllers\Controller;
use App\Virtualizor\Admin;
use App\Models\User;

class BalanceController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function __construct()
    // {
    //     $this->virtualizorAdmin = new Admin();
    // }

    public function index(Request $request)
    {
        // $oslist = $this->getOSlist();
        $orderby = 'date';
        $order = 'desc';
        $perPage = 300;

        $totalresults = 0;
        $startnumber = 0;
        $numreturned = 0;

        // get credit
        $latest_user_data = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetClientsDetails',
            'clientid' => Auth::user()->client_id,
        ]);

        if ($latest_user_data['result'] == 'success') {
            $user = User::where('whmcs_id', Auth::user()->whmcs_id)->first();
            if ($user) {
                if ($user->credit != $latest_user_data['credit']) {
                    $user->credit = $latest_user_data['credit'];
                    $user->save();
                }
            }
        }

        if ($request->order && $request->orderby) {
            $orderby = $request->orderby;
            $order = $request->order;
        }

        $response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetInvoices',
            'orderby' => $orderby,
            'order' => $order,
            'limitstart' => 0,
            'limitnum' => $perPage,
            // Set number of tickets to retrieve per request
            'userid' => Auth::user()->client_id, // Set number of tickets to retrieve per request
        ]);


        if (count($response['invoices']) != 0) {
            $invoices = $response['invoices']['invoice'];
            $totalresults = $response['totalresults'];
            $startnumber = $response['startnumber'];
            $numreturned = $response['numreturned'];
        } else
            $invoices = [];

        return response()->json([
            'invoices' => $invoices,
            'totalresults' => $totalresults,
            'startnumber' => $startnumber,
            'numreturned' => $numreturned,
        ]);
    }

}