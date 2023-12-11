<?php
namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use DateTime;
use App\Virtualizor\Admin;
use Illuminate\Http\Request;
use Auth;
use sburina\Whmcs;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Invoices;
use App\Models\Vpsids;
use App\Models\ClientProducts;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class OverviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->virtualizorAdmin = new Admin();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $all_request = $request->input('params');

        $order_product_info = [];
        $order_info = [];
        $vps_info = [];
        $vpsid = 0;

        $order_id = $all_request['id'];
        $order_info_response = $this->getOrderinfo($order_id); //GetOrders whmcs api

        if (!isset($order_info_response['orders']['order'])) {
            // Once more try
            $order_info_response = $this->getOrderinfo($order_id); //GetOrders whmcs api
        }

        $order_info = $order_info_response['orders']['order'];

        $order_product_info = $this->getClientProductInfo($order_id, $all_request['domain']); //GetClientsProducts whmcs api
        $relid = $order_product_info['id'];

        $today = new DateTime(date("Y-m-d"));
        $start_day = new DateTime($order_info[0]['date']);

        $interval = $today->diff($start_day);
        $dayDiff = $interval->days;

        $other_info = $this->getOtherinfo($order_product_info);

        $invoiceInfo = $this->getinvoiceInfo($order_info[0]['invoiceid']); //GetInvoice whmcs api

        $flag = $other_info['flag'];
        if (isset($other_info['sys_logo'])) {
            $sys_logo = $other_info['sys_logo'];
        } else {
            $sys_logo = 'windows';
        }
        $system = $other_info['system'];
        $status = $order_info[0]['status'];
        if ($status != 'Active' && $order_product_info['status'] == 'Active')
            $status = 'Active';
        if ($status == 'Active') {
            $vpsid = $order_product_info['customfields']['customfield'][1]['value'];

            // save vpsid into the table
            $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $vpsid)->first();
            if (!$vps_id_item) {
                $vps_id_item = new Vpsids();
                $vps_id_item->client_id = Auth::user()->client_id;
                $vps_id_item->vpsid = $vpsid;
                $vps_id_item->order_id = $order_id;
                $vps_id_item->save();
            }

            $vps_info = $this->getVpsStatistics($vpsid); // Virtualizor admin api
        }

        $randStr = Str::random(32);
        $encryptedParameter = Crypt::encrypt($all_request['domain'], $randStr);

        return response()->json([
            'relid' => $relid,
            'order_id' => $order_id,
            'order_product_info' => $order_product_info,
            'dayDiff' => $dayDiff,
            'flag' => $flag,
            'sys_logo' => $sys_logo,
            'system' => $system,
            'vpsid' => $vpsid,
            'vps_info' => $vps_info,
            'invoiceInfo' => $invoiceInfo,
            'invoice_id' => $randStr, // secret key of crypting
            'encryptedParameter' => $encryptedParameter,
            'status' => $status,
        ]);

    }

    public function analysis_data(Request $request)
    {
        $all_request = $request->input('params');
        // reject if not vpsid exist
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of rejecting
        $analysis_data = [];
        $analysis_data = $this->getAnalysisData($all_request['vpsid']);
        return response()->json([
            'analysis_data' => $analysis_data,
        ]);
    }

    public function get_rdns_lists(Request $request)
    {
        $all_request = $request->input('params');
        $rdnslist = [];
        $rdnslist = $this->getDNSlist($all_request['dedicatedip']);
        return response()->json([
            'rdnslist' => $rdnslist,
        ]);
    }

    public function get_tasks(Request $request)
    {
        $all_request = $request->input('params');

        // reject if not vpsid exist
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of rejecting

        $tasks = [];

        $page = 0;
        $reslen = 0;
        //For Searching
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        $response_info = $this->virtualizorAdmin->tasks($page, $reslen, $post);
        $tasks = $response_info['tasks'];
        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    public function get_ips(Request $request)
    {
        $all_request = $request->input('params');
        $ip_list['ips'] = [];

        $decrypt_domain = Crypt::decrypt($all_request['domain'], $all_request['domain_id']);

        if((!isset($all_request['domain'])) || ($decrypt_domain == '*'))
        {
            $error = "Invalid action";
            return response()->json($error, 500);
        }

        $ip_list = $this->getIpinfo($decrypt_domain); // Virtualizor admin api

        return response()->json([
            'ip_list' => $ip_list,
        ]);
    }

    public function get_logs(Request $request)
    {
        $all_request = $request->input('params');
        $logs = [];

        // reject if not vpsid exist
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of rejecting

        $page = 0;
        $reslen = 0;
        //For Searching
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        $response_info = $this->virtualizorAdmin->userlogs($page, $reslen, $post);
        $logs = $response_info['userlogs'];
        return response()->json([
            'logs' => $logs,
        ]);
    }

    public function departments_data(Request $request)
    {
        $all_request = $request->input('params');
        $ip_list['ips'] = [];

        $decrypt_domain = Crypt::decrypt($all_request['domain'], $all_request['domain_id']);

        if((!isset($all_request['domain'])) || ($decrypt_domain == '*'))
        {
            $error = "Invalid action";
            return response()->json($error, 500);
        }

        if ($all_request['assignedips'] != "") {
            if ($all_request['status'] == 'Active') {
                $ip_list = $this->getIpinfo($decrypt_domain); // Virtualizor admin api
            }
        }


        $departments = array();
        $departments_info = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetSupportDepartments'
        ]);

        if ($departments_info['result'] == 'success') {
            if ($departments_info['totalresults'] > 0) {
                $departments = $departments_info['departments']['department'];
            }
        }

        $invoiceInfo = $this->getinvoiceInfo($all_request['invoice_id']);

        // invoice
        if ($invoiceInfo['status'] == 'Paid') {
            $invoice_lists = (new \Sburina\Whmcs\Client)->post([
                'action' => 'GetInvoices',
                'userid' => Auth::user()->client_id,
                'orderby' => 'date',
                'order' => 'desc',
                'limitstart' => 0,
                'limitnum' => 300,
            ]);

            if (count($invoice_lists['invoices']) != 0) {
                $invoices = $invoice_lists['invoices']['invoice'];
            } else
                $invoices = [];

            $temp_date = $all_request['nextduedate'];
            $filteredInvoices = array_filter($invoices, function ($item) use ($temp_date) {
                return ($item['duedate'] == $temp_date && $item['status'] == 'Unpaid');
            });

            foreach ($filteredInvoices as $item) {
                $temp = (new \Sburina\Whmcs\Client)->post([
                    'action' => 'GetInvoice',
                    'userid' => Auth::user()->client_id,
                    'invoiceid' => $item['id'],
                ]);
                if ($temp['result'] != 'success')
                    break;
                foreach ($temp['items']['item'] as $subitem) {
                    if ($subitem['relid'] == $all_request['relid']) {
                        $invoiceInfo = $temp;
                        break 2;
                    } else
                        break;
                }
            }
        }

        return response()->json([
            'departments' => $departments,
            'invoiceInfo' => $invoiceInfo,
            'ip_list' => $ip_list,
        ]);
    }

    public function oslists(Request $request)
    {
        $oslists = [];
        $OSlist = $this->getOSlist();
        foreach ($OSlist['oslist']['proxk'] as $key => $os_group) {
            foreach ($os_group as $os_id => $os) {
                $os['group_name'] = $key;
                if (!isset($os['osid']))
                    $os['osid'] = $os_id;
                array_push($oslists, $os);
            }
        }
        return response()->json([
            'oslists' => $oslists,
        ]);
    }
    private function getClientProductInfo($order_id, $domain)
    {
        $orders_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetClientsProducts',
            'clientid' => Auth::user()->client_id,
            'domain' => $domain
        ]);

        $orders = $orders_response['products']['product'];

        // if(count($orders) == 0) {
        //     $orders_response = (new \Sburina\Whmcs\Client)->post([
        //         'action' => 'GetClientsProducts',
        //         'clientid' => Auth::user()->client_id,
        //     ]);
        //     $orders = $orders_response['products']['product'];
        // }

        foreach ($orders as $order)
            if ($order['orderid'] == $order_id)
                $order_info = $order;
        return $order_info;
    }

    private function getOrderProductInfo($pid)
    {
        $product_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetProducts',
            'pid' => $pid,
        ]);
        $product_info = $product_response['products']['product'][0];
        return $product_info;
    }

    private function getProductDetailInfo($product_info)
    {
        $detail_info = array();
        $doc = new DOMDocument();
        $doc->loadHTML($product_info['description']);
        $xpath = new DOMXPath($doc);

        $items = $xpath->query('//ul[@class="list-unstyled pricing-feature-list"]/li');

        foreach ($items as $item) {
            $span = $item->getElementsByTagName('span')->item(0);
            $span_value = $span->nodeValue;
            $value = trim($item->firstChild->nextSibling->nodeValue);

            array_push($detail_info, $span_value . " " . $value);
        }

        return $detail_info;
    }

    private function getOtherinfo($order_info)
    {
        if (strpos($order_info['groupname'], 'Netherlands') !== false) {
            $info['flag'] = 'flag-nl';
        } else {
            $info['flag'] = 'flag-en';
        }

        if($order_info['status'] == 'Active'){
            $page = 0;
            $reslen = 0;
            //For Searching
            $post = array();
            $post['vpsid'] = $order_info['customfields']['customfield'][1]['value'];
            $vps_info = $this->virtualizorAdmin->listvs($page ,$reslen ,$post);
            $vps_info = $vps_info[$post['vpsid']];
            $info['vps_info'] = $vps_info;
            $system_label = explode('-',$vps_info['os_name'])[0];
            $info['system'] = $vps_info['os_name'];
        } else{
            $system_label = explode('-', $order_info['configoptions']['configoption'][1]['value'])[0];
            $info['system'] = $order_info['configoptions']['configoption'][1]['value'];
        }
        

        switch ($system_label) {
            case 'windows':
                $info['sys_logo'] = 'windows';
                break;
            case 'ubuntu':
                $info['sys_logo'] = 'ubuntu';
                break;
            case 'centos':
                $info['sys_logo'] = 'centos';
                break;
            case 'debian':
                $info['sys_logo'] = 'debian';
                break;
            case 'almalinux':
                $info['sys_logo'] = 'almalinux';
                break;
            case 'fedora':
                $info['sys_logo'] = 'fedora';
                break;
            case 'rocky':
                $info['sys_logo'] = 'rocky';
                break;
        }

        return $info;
    }

    private function getOtherinfo_VNC($order_info)
    {
        if (strpos($order_info['groupname'], 'Netherlands') !== false) {
            $info['flag'] = 'flag-nl';
        } else {
            $info['flag'] = 'flag-en';
        }

        if ($order_info['status'] == 'Active') {
            $page = 0;
            $reslen = 0;
            //For Searching
            $post = array();
            $post['vpsid'] = $order_info['customfields']['customfield'][1]['value'];
            $vps_info = $this->virtualizorAdmin->listvs($page, $reslen, $post);
            $vps_info = $vps_info[$post['vpsid']];
            $info['vps_info'] = $vps_info;
            $system_label = explode('-', $vps_info['os_name'])[0];
            $info['system'] = $vps_info['os_name'];

        } else {
            $system_label = explode('-', $order_info['configoptions']['configoption'][1]['value'])[0];
            $info['system'] = $order_info['configoptions']['configoption'][1]['value'];
        }

        switch ($system_label) {
            case 'windows':
                $info['sys_logo'] = 'windows';
                break;
            case 'ubuntu':
                $info['sys_logo'] = 'ubuntu';
                break;
            case 'centos':
                $info['sys_logo'] = 'centos';
                break;
            case 'debian':
                $info['sys_logo'] = 'debian';
                break;
            case 'almalinux':
                $info['sys_logo'] = 'almalinux';
                break;
            case 'fedora':
                $info['sys_logo'] = 'fedora';
                break;
            case 'rocky':
                $info['sys_logo'] = 'rocky';
                break;
        }

        return $info;
    }

    private function getVpsStatistics($vpsid)
    {
        $post = array();
        $post['vpsid'] = $vpsid; //Set this only when you want vps_data
        // $post['show'] = date("Ym"); //Set this only when you want vps_data
        $vps_info = $this->virtualizorAdmin->vps_stats($post);

        return $vps_info;
    }

    private function getCpuStatistics($vpsid)
    {
        $vps_info = $this->virtualizorAdmin->cpu($vpsid);
        return $vps_info;
    }

    private function getOSlist()
    {
        $oslist = $this->virtualizorAdmin->ostemplates();
        return $oslist;
    }

    private function getNetworkSpeed($vpsid)
    {
        $vps_info = $this->virtualizorAdmin->listvs(0, 0, array('vpsid' => $vpsid));
        $network_speed = $vps_info[$vpsid]['network_speed'];
        return $network_speed;
    }

    public function turnon(Request $request)
    {
        $all_request = $request->input('params');
        // check vpsid is real client's id
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of validating
        $vpsid = $all_request['vpsid'];
        $output = $this->virtualizorAdmin->start($vpsid);
        if ($output['done_msg'] == 'VPS has been started successfully') {
            return response()->json($output['done_msg'], 200);
        } else {
            $error = "Please try again!";
            return response()->json($error, 500);
        }
    }

    public function turnoff(Request $request)
    {
        $all_request = $request->input('params');
        $vpsid = $all_request['vpsid'];
        // check vpsid is real client's id
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of validating
        $output = $this->virtualizorAdmin->stop($vpsid);

        if ($output['done'] == true) {
            return response()->json('VPS has been stopped successfully', 200);
        } else {
            $error = "Please try again!";
            return response()->json($error, 500);
        }
    }

    public function poweroff(Request $request)
    {
        $all_request = $request->input('params');
        $vpsid = $all_request['vpsid'];
        // check vpsid is real client's id
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of validating
        $output = $this->virtualizorAdmin->poweroff($vpsid);
        if ($output['done'] == true) {
            return response()->json('VPS has been powered off successfully', 200);
        } else {
            $error = "Please try again!";
            return response()->json($error, 500);
        }
    }

    public function reboot(Request $request)
    {
        $all_request = $request->input('params');
        // check vpsid is real client's id
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of validating
        $vpsid = $all_request['vpsid'];
        $output = $this->virtualizorAdmin->restart($vpsid);
        if ($output['done_msg'] == 'Restart signal has been sent to the VPS') {
            return response()->json($output['done_msg'], 200);
        } else {
            $error = "Please try again!";
            return response()->json($error, 500);
        }
    }

    public function rebuild(Request $request)
    {
        $all_request = $request->input('params');
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        // check vpsid is real client's id
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of validating
        $post['format_primary'] = $all_request['format_disk_flag'];
        $post['osid'] = $all_request['selected_osid'];
        $post['newpass'] = $all_request['root_pwd'];
        $post['conf'] = $all_request['root_pwd'];
        $output = $this->virtualizorAdmin->rebuild($post);

        if ($output['done'] == 1) {
            return response()->json('Success', 200);
        } else {
            return response()->json($output['error'], 500);
        }
    }

    public function checkhostName(Request $request)
    {
        $all_request = $request->input('params');
        $exist_flag = false;
        $page = 1;
        $reslen = 100;
        $vs_list = array();
        do {
            $result = $this->virtualizorAdmin->listvs($page, $reslen);
            $vs_list = array_merge($vs_list, $result);
            $page++;
        } while (count($result) == $reslen);

        foreach ($vs_list as $vs) {
            if ($vs['hostname'] == $all_request['hostname']) {
                $exist_flag = true;
            }
        }

        if ($exist_flag)
            return response()->json('Already Exist.', 200);
        else
            return response()->json('No Exist.', 200);
    }

    public function changehostNames(Request $request)
    {
        $all_request = $request->input('params');
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        $post['hostname'] = $all_request['hostname'];
        $result = $this->virtualizorAdmin->managevps($post);
        if ($result['done']['done']) {
            return response()->json('Your hostname will be changed when the VPS is booted again', 200);
        } else {
            return response()->json('Oops! We meet some error!.', 500);
        }
    }

    public function changeRootPwd(Request $request)
    {
        $all_request = $request->input('params');
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        // check vpsid is real client's id
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of validating
        $post['rootpass'] = $all_request['root_pwd'];
        $result = $this->virtualizorAdmin->managevps($post);
        if ($result['done']['done']) {
            return response()->json('VPS password will be changed after you SHUTDOWN and START the VPS from the panel.', 200);
        } else {
            return response()->json('Oops! We meet some error!.', 500);
        }

    }

    private function serverMonitering($vpsid)
    {
        $result = $this->virtualizorAdmin->performance($vpsid);
        print_r($result);
        exit;
    }

    private function getOrderinfo($order_id)
    {
        $orders_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetOrders',
            'userid' => Auth::user()->client_id,
            'id' => $order_id,
        ]);

        return $orders_response;
    }

    private function getinvoiceInfo($invoice_id)
    {
        $invoice_info = array();

        // $invoice = Invoices::where('invoice_id', $invoice_id)->first();
        // if ($invoice)
            // return json_decode($invoice->Data, true);
        // else {
            $invoice_info = (new \Sburina\Whmcs\Client)->post([
                'action' => 'GetInvoice',
                'invoiceid' => $invoice_id,
            ]);

            if ($invoice_info['status'] == 'Paid') { //need to save to database
                // if (!$invoice) {
                    $invoice = new Invoices();
                    $invoice->Data = json_encode($invoice_info);
                    $invoice->invoice_id = $invoice_id;
                    $invoice->save();
                // }
            }

            return $invoice_info;
        // }

    }

    private function getIpinfo($hostname)
    {
        $post = array();
        $post['vps_search'] = $hostname;

        $result = $this->virtualizorAdmin->ips(1, 50, $post);
        usort($result['ips'], function ($a, $b) {
            return $b['primary'] - $a['primary'];
        });
        return $result;
    }

    private function getAnalysisData($vpsid)
    {
        $post = array();
        $datas = array();
        $date = array();
        $return_datas = array();
        $post['show'] = date("Ym");
        $post['svs'] = $vpsid;
        $output = $this->virtualizorAdmin->vps_stats($post);
        if (is_array($output['vps_stats'])) {
            foreach ($output['vps_stats'] as $state) {
                $state[1] = date('Y-m-d H:i:s', $state[1]);
                array_push($return_datas, $state);
            }
        }

        return $return_datas;
    }

    public function changeip(Request $request)
    {
        $all_request = $request->input('params');
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        // check vpsid is real client's id
        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('vpsid', $all_request['vpsid'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }
        // end of validating
        $post['ips'] = $all_request['reorder_ips'];

        $result = $this->virtualizorAdmin->managevps($post);

        if ($result['done']['done']) {
            return response()->json('Success', 200);
        } else {
            return response()->json('Error', 500);
        }
    }

    public function connectvnc(Request $request)
    {
        $all_request = $request->input('params');

        $vps_id_item = Vpsids::where('client_id', Auth::user()->client_id)->where('order_id', $all_request['id'])->first();
        if (!$vps_id_item) {
            $error = "No vpsid exist on your service.";
            return response()->json($error, 500);
        }

        $vpsid = $vps_id_item->vpsid;

        // $order_id = $all_request['id'];
        // $order_product_info = $this->getClientProductInfo($order_id, $all_request['domain']);
        // $other_info = $this->getOtherinfo_VNC($order_product_info);
        // if ($order_product_info['status'] == 'Active') {
        //     $vpsid = $other_info['vps_info']['vpsid'];
        // }

        $post = array();
        $post['novnc'] = $vpsid;
        $result = $this->virtualizorAdmin->vnc($post);

        $info = $result['info'];
        $base_url = public_path() . '/novnc/';
        $noVNC_file_path = public_path('novnc/vnc_auto_virt.html');
        $noVNC_file_content = file_get_contents($noVNC_file_path);

        $host_url = url('/');
        $ip = $this->virtualizorAdmin->ip;

        $proto = 'http';
        $port = 4081;
        $websockify = 'websockify';
        if (!empty($_SERVER['HTTPS'])) {
            $proto = 'https';
            $port = 4083;
            $websockify = 'novnc/';
        }

        $vnc_token = $vpsid;

        $array = array(
            'HOST' => 'vnc.akeimai.com',
            // 'PORT' => $port,
            'PROTO' => $proto,
            'WEBSOCKET' => $websockify,
            'TOKEN' => $vnc_token,
            'PASSWORD' => $info['password'],
            'base_url' => $host_url . '/novnc/'
        );

        foreach ($array as $k => $v) {
            $noVNC_file_content = str_replace('{{' . $k . '}}', $v, $noVNC_file_content);
        }

        return response($noVNC_file_content);
    }

    private function getDNSlist($ip)
    {
        $post = array();
        $result = $this->virtualizorAdmin->pdns(1, 50, $post);
        $pnds_server_info = reset($result['pdns']);

        $ip_array = array_reverse(explode(".", $ip));

        $post['pdnsid'] = $pnds_server_info['id'];
        $post['dns_name'] = $ip_array[0] . "." . $ip_array[1] . "." . $ip_array[2] . "." . $ip_array[3] . ".in-addr.arpa";
        $post['domain_id'] = '';
        $post['dns_domain'] = '';
        $post['record_type'] = 'PTR';
        $result = $this->virtualizorAdmin->search_dnsrecords(1, 100000, $post);

        return $result['dns_records'];

    }

    public function addRDNS(Request $request)
    {
        $all_request = $request->input('params');
        $post = array();
        $result = $this->virtualizorAdmin->pdns(1, 50, $post);
        $pnds_server_info = reset($result['pdns']);

        $ip_array = array_reverse(explode(".", $all_request['ip']));

        $post['pdnsid'] = $pnds_server_info['id'];
        $post['domain'] = $all_request['domain'];
        $post['dns_ip'] = $all_request['ip'];
        $post['dns_type'] = 'type_rdns';
        $post['content'] = $ip_array[0] . "." . $ip_array[1] . "." . $ip_array[2] . "." . $ip_array[3] . ".in-addr.arpa";
        $result = $this->virtualizorAdmin->add_dnsrecord($post);

        if ($result['done'] == 1) {

            $rdnslist = $this->getDNSlist($all_request['ip']);
            return response()->json([
                'rdnslist' => $rdnslist,

            ]);
        }
    }

    public function deleteRDNS(Request $request)
    {
        $all_request = $request->input('params');
        $post = array();
        $result = $this->virtualizorAdmin->pdns(1, 50, $post);
        $pnds_server_info = reset($result['pdns']);

        $ip_array = array_reverse(explode(".", $all_request['ip']));

        $post['pdnsid'] = $pnds_server_info['id'];
        $post['del'] = $all_request['rdns_record_id'];
        $result = $this->virtualizorAdmin->delete_dnsrecords($post);

        if ($result['done']) {
            $rdnslist = $this->getDNSlist($all_request['ip']);
            $ip = $all_request['ip'];
            $rdnslist = $this->getDNSlist($all_request['ip']);
            return response()->json([
                'rdnslist' => $rdnslist,
                'ip' => $ip,

            ]);
        }
    }
}