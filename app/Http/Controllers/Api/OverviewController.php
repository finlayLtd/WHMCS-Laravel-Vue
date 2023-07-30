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
        // $all_request['id']
        

        $order_product_info = [];
        $order_info = [];
        $oslists = [];
        $network_speed = [];
        $vps_info = [];
        $cpu = [];
        $rdnslist = [];
        $vpsid = 0;
        $ip_list['ips'] = [];
        $analysis_data = [];
        $order_id  = $all_request['id'];
        $order_info_response = $this->getOrderinfo($order_id);
        $order_info = $order_info_response['orders']['order'];
        $relid = $order_info[0]['lineitems']['lineitem'][0]['relid'];
        
        $order_product_info = $this->getClientProductInfo($order_id);
        
        $today = new DateTime(date("Y-m-d"));
        $start_day = new DateTime($order_info[0]['date']);
        $interval = $today->diff($start_day);
        $dayDiff = $interval->days;
        
        $product_info = $this->getOrderProductInfo($order_product_info['pid']);

        
        $detail_info = $this->getProductDetailInfo($product_info);
        $other_info = $this->getOtherinfo($order_product_info);
        $invoiceInfo = $this->getinvoiceInfo($order_id);

        $flag = $other_info['flag'];
        if(isset($other_info['sys_logo'])){
            $sys_logo = $other_info['sys_logo'];
        } else {
            $sys_logo  = 'windows';
        }

        $system = $other_info['system'];
        
        $OSlist = $this->getOSlist();
        $status = $order_info[0]['status'];

        if($status == 'Active'){
            $vpsid = $other_info['vps_info']['vpsid'];
            $vps_info = $this->getVpsStatistics($vpsid);
            // $network_speed = $this->getNetworkSpeed($vpsid);
            $cpu = $this->getCpuStatistics($vpsid);
            $analysis_data = $this->getAnalysisData($vpsid);
            $ip_list = $this->getIpinfo($other_info['vps_info']['hostname']);
            $rdnslist = $this->getDNSlist($order_product_info['dedicatedip']);
        }


        foreach($OSlist['oslist']['proxk'] as $key=>$os_group){
            foreach($os_group as $os_id=>$os){
                $os['group_name'] = $key;
                if(!isset($os['osid'])) $os['osid'] = $os_id;
                array_push($oslists,$os);
            }
        }

        // $orders = array();
        $departments = array();

        // $orders_info =  (new \Sburina\Whmcs\Client)->post([
        //     'action' => 'GetOrders',
        //     'userid' => Auth::user()->client_id,
        // ]);

        // if ($orders_info['totalresults'] > 0) {
        //     $orders = $orders_info['orders']['order'];
        // }

        $departments_info =  (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetSupportDepartments'
        ]);

        if($departments_info['result'] == 'success'){
            if ($departments_info['totalresults'] > 0) {
                $departments = $departments_info['departments']['department'];
            }
        }

        

        
        

        if($invoiceInfo['status'] == 'Paid'){
            // order_product_info.nextduedate
        $invoice_lists = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetInvoices',
            'userid' => Auth::user()->client_id, // Set number of tickets to retrieve per request
            'orderby' => 'date',
            'order' => 'desc',
            'limitstart' => 0,
            'limitnum' => 300,
        ]);


        if (count($invoice_lists['invoices']) != 0) {
            $invoices = $invoice_lists['invoices']['invoice'];
        } else $invoices = [];

            $temp_date = $order_product_info['nextduedate'];
            $filteredInvoices = array_filter($invoices, function($item) use($temp_date) {
                return ($item['duedate'] == $temp_date && $item['status']=='Unpaid' );
            });
    
            foreach ($filteredInvoices as $item) {
                $temp = (new \Sburina\Whmcs\Client)->post([
                    'action' => 'GetInvoice',
                    'userid' => Auth::user()->client_id, // Set number of tickets to retrieve per request
                    'invoiceid' => $item['id'],
                ]);
    
                if($temp['result'] != 'success') break;
                foreach($temp['items']['item'] as $subitem){
                    if($subitem['relid'] == $relid) {$invoiceInfo = $temp; break 2;}
                    else break;
                }
            }
        }

        




        return response()->json([
            'relid' => $relid,
            // 'filteredInvoices' => $filteredInvoices,
            'order_id' => $order_id,
            'order_product_info' => $order_product_info,
            'dayDiff' => $dayDiff,
            'detail_info' => $detail_info,
            'flag' => $flag,
            'sys_logo' => $sys_logo,
            'system' => $system,
            'vpsid' => $vpsid,
            'vps_info' => $vps_info,
            'oslists' => $oslists,
            'cpu' => $cpu,
            // 'network_speed' => $network_speed,
            'invoiceInfo' => $invoiceInfo,
            // 'orders' => $orders,
            'departments' => $departments,
            'ip_list' => $ip_list,
            'analysis_data' => $analysis_data,
            'status' => $status,
            'rdnslist' => $rdnslist,
        ]);
        
        // return view('pages/overview', compact('relid','order_id','order_product_info','dayDiff','detail_info','flag','sys_logo',
        // 'system','vpsid','vps_info','oslists','cpu','network_speed','invoiceInfo','orders','departments','ip_list','analysis_data','status','rdnslist'));
    }

    private function getClientProductInfo($order_id)
    {
        $orders_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetClientsProducts',
            'clientid' => Auth::user()->client_id,
        ]);
        $orders = $orders_response['products']['product'];
        foreach($orders as $order)
            if($order['orderid'] == $order_id) $order_info = $order;
        
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

            array_push($detail_info,$span_value." ".$value);
        }

        return $detail_info;
    }

    private function getOtherinfo($order_info)
    {
        if(strpos($order_info['groupname'],'Netherlands') !== false){
            $info['flag'] = 'flag-nl';
        }else{
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

        }else{
            $system_label = explode('-',$order_info['configoptions']['configoption'][1]['value'])[0];
            $info['system'] = $order_info['configoptions']['configoption'][1]['value'];
        }

        switch($system_label){
            case 'windows':
                $info['sys_logo'] = 'windows'; break;
            case 'ubuntu':
                $info['sys_logo'] = 'ubuntu'; break;
            case 'centos':
                $info['sys_logo'] = 'centos'; break;
            case 'debian':
                $info['sys_logo'] = 'debian'; break;
            case 'almalinux':
                $info['sys_logo'] = 'almalinux'; break;
            case 'fedora':
                $info['sys_logo'] = 'fedora'; break;
            case 'rocky':
                $info['sys_logo'] = 'rocky'; break;
        }

        return $info;
    }

    private function getVpsStatistics($vpsid)
    {
        $post = array();
        $post['vpsid'] = $vpsid; //Set this only when you want vps_data
        $post['show'] = date("Ym"); //Set this only when you want vps_data
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
        $vps_info = $this->virtualizorAdmin->listvs(0,0,array('vpsid'=>$vpsid));
        $network_speed = $vps_info[$vpsid]['network_speed'];
        return $network_speed;
    }

    public function turnon(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']
        $vpsid = $all_request['vpsid'];
        $output = $this->virtualizorAdmin->start($vpsid);
        if($output['done_msg'] == 'VPS has been started successfully'){
            return response()->json($output['done_msg'], 200);
        }else{
            $error = "Please try again!";
            return response()->json($error, 500);
        }
    }
    
    public function turnoff(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']
        $vpsid = $all_request['vpsid'];
        $output = $this->virtualizorAdmin->stop($vpsid);
        if($output['done_msg'] == 'Shutdown signal has been sent to the VPS'){
            return response()->json($output['done_msg'], 200);
        }else{
            $error = "Please try again!";
            return response()->json($error, 500);
        }
    }

    public function poweroff(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']
        $vpsid = $all_request['vpsid'];
        $output = $this->virtualizorAdmin->poweroff($vpsid);
        if($output['done_msg'] == 'VPS has been powered off successfully'){
            return response()->json($output['done_msg'], 200);
        }else{
            $error = "Please try again!";
            return response()->json($error, 500);
        }
    }

    public function reboot(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']
        $vpsid = $all_request['vpsid'];
        $output = $this->virtualizorAdmin->restart($vpsid);
        if($output['done_msg'] == 'Restart signal has been sent to the VPS'){
            return response()->json($output['done_msg'], 200);
        }else{
            $error = "Please try again!";
            return response()->json($error, 500);
        }
    }

    public function rebuild(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        $post['format_primary'] = $all_request['format_disk_flag'];
        $post['osid'] = $all_request['selected_osid'];
        $post['newpass'] = $all_request['root_pwd'];
        $post['conf'] = $all_request['root_pwd'];
        $output = $this->virtualizorAdmin->rebuild($post);
        
        if($output['done'] == 1){
            return response()->json('Success', 200);
        }else{
            return response()->json($output['error'], 500);
        }
    }

    public function checkhostName(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']
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

        if($exist_flag) return response()->json('Already Exist.', 200);
        else return response()->json('No Exist.', 200);
    }

    public function changehostNames(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        $post['hostname'] = $all_request['hostname'];
        $result = $this->virtualizorAdmin->managevps($post);
        if($result['done']['done']){
            return response()->json('Your hostname will be changed when the VPS is booted again', 200);
        }else{
            return response()->json('Oops! We meet some error!.', 500);
        }
    }

    public function changeRootPwd(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']
        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        $post['rootpass'] = $all_request['root_pwd'];
        $result = $this->virtualizorAdmin->managevps($post);
        if($result['done']['change_pass_msg']){
            return response()->json('VPS password will be changed after you SHUTDOWN and START the VPS from the panel.', 200);
        }else{
            return response()->json('Oops! We meet some error!.', 500);
        }

    }

    private function serverMonitering($vpsid)
    {
        $result = $this->virtualizorAdmin->performance($vpsid);
        print_r($result);exit;
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

    private function getinvoiceInfo($order_id)
    {
        $invoice_info = array();
        $orders_response = $this->getOrderinfo($order_id);
        
        $invoice_info = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetInvoice',
            'invoiceid' => $orders_response['orders']['order'][0]['invoiceid'],
        ]);
        
        return $invoice_info;
    }

    private function getIpinfo($hostname)
    {
        $post = array();
        $ip_list = array();
        $post['vps_search'] = $hostname;
        
        $result = $this->virtualizorAdmin->ips(1, 50, $post);
        usort($result['ips'], function($a, $b) {
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
        if(is_array($output['vps_stats'])){
            foreach($output['vps_stats'] as $state){
                $state[1] = date('Y-m-d H:i:s', $state[1]);
                array_push($return_datas,$state);
            }
        }

        return $return_datas;
    }

    public function changeip(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']

        $post = array();
        $post['vpsid'] = $all_request['vpsid'];
        $post['ips'] = $all_request['reorder_ips'];
        
        $result = $this->virtualizorAdmin->managevps($post);
        
        if($result['done']['done']){
            return response()->json('Success', 200);
        }else{
            return response()->json('Error', 500);
        }
    }

    public function connectvnc(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']

        $post = array();
        $post['novnc'] = $all_request['id'];
        $result = $this->virtualizorAdmin->vnc($post);

        $info = $result['info'];
        $base_url = public_path().'/novnc/';
        $noVNC_file_path = public_path('novnc/vnc_auto_virt.html');
        // $noVNC_file_path = public_path('novnc/vnc_lite.html');
        $noVNC_file_content = file_get_contents($noVNC_file_path);
        
        $host_url = url('/');
        $ip = $this->virtualizorAdmin->ip;

        $proto = 'http';
        $port = 4081;
        $websockify = 'websockify';
        if(!empty($_SERVER['HTTPS'])){
            $proto = 'https';
            // if($_SERVER['SERVER_PORT'] == '443'){
            //     $port = 443;
            // }else{
            //     $port = 4083;
            // }
            $port = 4083;
            $websockify = 'novnc/';
        }

        $vnc_token = $all_request['id'];

        $array = array('HOST' => 'vnc.fidelcastro.cc',
                    'PORT' => $port,
                    'PROTO' => $proto,
                    'WEBSOCKET' => $websockify,
                    'TOKEN' => $vnc_token,
                    'PASSWORD' => $info['password'],
                    'base_url' => $host_url.'/novnc/');
        
        foreach($array as $k => $v){
            $noVNC_file_content = str_replace('{{'.$k.'}}', $v, $noVNC_file_content);
        }

        return response($noVNC_file_content);
    }

    private function getDNSlist($ip){
        $post = array();
        $result = $this->virtualizorAdmin->pdns(1, 50, $post);
        $pnds_server_info = reset($result['pdns']);
        
        $ip_array = array_reverse(explode(".",$ip));
        
        $post['pdnsid'] = $pnds_server_info['id'];
        $post['dns_name'] = $ip_array[0].".".$ip_array[1].".".$ip_array[2].".".$ip_array[3].".in-addr.arpa";
        $post['domain_id'] = '';
        $post['dns_domain'] = '';
        $post['record_type'] = 'PTR';
        $result = $this->virtualizorAdmin->search_dnsrecords(1, 100000, $post);

        return $result['dns_records'];
        
    }

    public function addRDNS(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['id']

        $post = array();
        $result = $this->virtualizorAdmin->pdns(1, 50, $post);
        $pnds_server_info = reset($result['pdns']);

        $ip_array = array_reverse(explode(".",$all_request['ip']));

        $post['pdnsid'] = $pnds_server_info['id'];
        $post['domain'] = $all_request['domain'];
        $post['dns_ip'] = $all_request['ip'];
        $post['dns_type'] = 'type_rdns';
        $post['content'] = $ip_array[0].".".$ip_array[1].".".$ip_array[2].".".$ip_array[3].".in-addr.arpa";
        $result = $this->virtualizorAdmin->add_dnsrecord($post);

        if($result['done'] == 1){

            $rdnslist = $this->getDNSlist($all_request['ip']);
            return response()->json([
                'rdnslist' => $rdnslist,
                
            ]);
        }
    }

    public function deleteRDNS(Request $request)
    {
        $all_request = $request->input('params');
        // $all_request['ip']

        $post = array();
        $result = $this->virtualizorAdmin->pdns(1, 50, $post);
        $pnds_server_info = reset($result['pdns']);

        $ip_array = array_reverse(explode(".",$all_request['ip']));

        $post['pdnsid'] = $pnds_server_info['id'];
        $post['del'] = $all_request['rdns_record_id'];
        $result = $this->virtualizorAdmin->delete_dnsrecords($post);

        if($result['done']){
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
