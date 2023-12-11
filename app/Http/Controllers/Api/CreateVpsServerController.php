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



class CreateVpsServerController extends Controller
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
    public function index()
    {
        // double check current balance
        $check_balance = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetClientsDetails',
            'clientid' => Auth::user()->client_id,
        ]);

        if ($check_balance['result'] == 'success') {
            //if credit is different
            if ($check_balance['credit'] != Auth::user()->credit) {
                $user = User::where('client_id', Auth::user()->client_id)->first();
                if ($user) {
                    $user->credit = $check_balance['credit'];
                    $user->save();
                }
            }
        }

        $os_kind = [];

        $product_info = $this->getProductGroups();
        $product_group = $product_info[0];
        $system_info = $product_info[1];

        $product_info = $this->getProductGroups();
        $payment_methods = $this->getPaymentMethods();
        // $payment_user_token = $this->getuserPaymentToken();
        $products = $this->getProducts();
        $oslist = $this->getOSlist();

        foreach ($oslist as $kind => $os) {
            array_push($os_kind, $kind);
        }

        foreach ($oslist as $kind => $os) {
            foreach ($os as $l => $o) {
                foreach ($system_info as $system) {
                    if ($this->isSimilarSystemName($system['name'], $o['name'])) {
                        $oslist[$kind][$l]['config_id'] = $system['id'];
                    }
                }
            }
        }
        // windows 2012 have to be added to windows
        $temp_array = [];
        foreach ($oslist as $kind => $os) {
            if ($kind == 'others') {

                foreach ($oslist[$kind] as $id => $innerArray) {
                    $temp_array = $innerArray;
                    break;
                }
            }
        }

        foreach ($oslist as $kind => $os) {
            if ($kind == 'windows') {
                if (count($temp_array) != 0) {
                    array_push($oslist[$kind], $temp_array);
                }
            }
        }

        return response()->json([
            'products' => $products,
            'product_group' => $product_group,
            'oslist' => $oslist,
            'os_kind' => $os_kind,
            'payment_methods' => $payment_methods,
        ]);
    }

    private function isSimilarSystemName($systemName, $oName) {
        $similarArray = array(
            'windows2012r2|Windows Server 2012 R2',
            'windows-Server-2019|Windows Server 2019',
            'almalinux-8.6-x86_64|AlmaLinux 8.6',
            'almalinux-8.8-x86_64|AlmaLinux 8.8',
            'almalinux-9.0-x86_64|AlmaLinux 9.0',
            'almalinux-9.1-x86_64|AlmaLinux 9.1',
            'almalinux-9.2-x86_64|AlmaLinux 9.2',
            'centos-6.10-x86_64|CentOS 6.10',
            'centos-7.8-x86_64|CentOS 7.8',
            'centos-8-x86_64|CentOS 8',
            'centos-8.2-x86_64|CentOS 8.2',
            'debian-8.7-x86_64|Debian 8.7',
            'debian-9.4-x86_64|Debian 9.4',
            'debian-10-x86_64|Debian 10',
            'debian-11-x86_64|Debian 11',
            'debian-12-x86_64|Debian 12',
            'fedora-34-x86_64|Fedora 34',
            'oracle-8.6-x86_64|Oracle Linux 8.6',
            'oracle-8.8-x86_64|Oracle Linux 8.8',
            'oracle-9.2-x86_64|Oracle Linux 9.2',
            'rocky-8.4-x86_64|Rocky Linux 8.4',
            'rocky-8.6-86_64|Rocky Linux 8.6',
            'rocky-9.1-x86_64|Rocky Linux 9.1',
            'rocky-9.2-x86_64|Rocky Linux 9.2',
            'scientific-7.4-x86_64|Scientific Linux 7.4',
            'suse-15.1-x86_64|openSUSE 15.1',
            'ubuntu-18.04-x86_64|Ubuntu 18.04',
            'ubuntu-20.04-x86_64|Ubuntu 20.04',
            'ubuntu-22.04-x86_64|Ubuntu 22.04',
            'webuzo-almalinux-8.6-x86_64|Webuzo 8.6',
            'kalilinux-2023.3-x86_64|Kali Linux 2023.3',
        );
    
        foreach ($similarArray as $similar) {
            $names = explode('|', $similar);
            if (($names[1] == $systemName) && ($names[0] == $oName)) {
                return true;
            }
        }

        return false;
    } 

    private function getProductGroups()
    {
        $system = array();

        $products = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetProducts',
        ]);

        $productGroups = [];
        foreach ($products['products']['product'] as $key => $product) {

            $parts = explode('?', $product['product_url']);
            $group_names = explode('/', $parts[1]);

            $groupId = $product['gid'];
            if (!isset($productGroups[$groupId])) {
                $productGroups[$groupId] = ucfirst($group_names[2]);
            }

            if ($key == 1) {
                $system_lists = $product['configoptions']['configoption'][1]['options']['option'];
                foreach ($system_lists as $system_info) {
                    array_push(
                        $system,
                        array(
                            'id' => $system_info['id'],
                            'name' => $system_info['name']
                        )
                    );
                }
            }
        }

        return array($productGroups, $system);
    }

    private function getProducts()
    {
        $products_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetProducts',
        ]);

        if ($products_response['totalresults'] > 0) {
            $products = $products_response['products']['product'];
        }

        if (count($products)) {
            foreach ($products as $key => $product) {
                $products[$key]['server_info'] = array();
                $doc = new DOMDocument();
                $doc->loadHTML($product['description']);
                $xpath = new DOMXPath($doc);

                $items = $xpath->query('//ul[@class="list-unstyled pricing-feature-list"]/li');

                foreach ($items as $item) {
                    $span = $item->getElementsByTagName('span')->item(0);
                    $span_value = $span->nodeValue;
                    $value = trim($item->firstChild->nextSibling->nodeValue);

                    array_push($products[$key]['server_info'], $span_value . " " . $value);
                }
            }
        }
        return $products;
    }

    private function getOSlist()
    {
        $oslists = $this->virtualizorAdmin->ostemplates();
        return $oslists['oslist']['proxk'];
    }

    private function getProductInfo()
    {
        $product_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetProductsGroups'
        ]);
        print_r($product_response);
        exit;
    }

    private function getPaymentMethods()
    {
        $payment_methods = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetPaymentMethods'
        ]);

        return $payment_methods['paymentmethods']['paymentmethod'];
    }

    private function getuserPaymentToken()
    {
        $payment_methods = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetPayMethods',
            'clientid' => Auth::user()->client_id,
        ]);

        print_r($payment_methods);
        exit;
    }

    public function create(Request $request)
    {
        $all_request = $request->input('params');
        $number_of_ips = $all_request['number_of_ips'];
        $hostname_array = $all_request['hostname_array'];

        $quantity = 1;
        if (isset($all_request['quantity'])) {
            $quantity = $all_request['quantity'];
        }

        // 1 is 18, ... ignore 28-30. 11 is 31, ... ignore 41-44, 21 is 45 and 60 is 84
        // this rule have to be applied for the configoptions parameter for the extra ips
        if ($number_of_ips <= 10)
            $number_of_ips += 17;
        else {
            if ($number_of_ips <= 20)
                $number_of_ips += 20;
            else
                $number_of_ips += 24;
        }

        $configoptionsFields = [
            "1" => $number_of_ips,
            "6"  => $all_request['config_id'],
        ];

        $payment_method = $all_request['paymentMethod'];
        //this case, just create vps with cryptocurrency
        if ($payment_method == 'credit')
            $payment_method = 'cryptomusgateway';

        $billingcycle = [];
        $rootpw = [];
        $pid = [];
        $configoptions = [];

        foreach ($hostname_array as $hostname) {
            array_push($billingcycle, $all_request['current_plan']);
            array_push($rootpw, $all_request['pwd']);
            array_push($pid, $all_request['product_id']);
            array_push($configoptions, base64_encode(serialize($configoptionsFields)));
        }

        $add_order_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'AddOrder',
            'clientid' => Auth::user()->client_id,
            'paymentmethod' => $payment_method,
            'billingcycle' => $billingcycle,
            'hostname' => $hostname_array,
            'rootpw' => $rootpw,
            'pid' => $pid,
            'configoptions' => $configoptions,
        ]);

        if ($add_order_response['result'] == 'success') {
            //apply the credit here
            if ($all_request['paymentMethod'] == 'credit') {
                // get the invoice id from the orderid
                $invoiceInfo = $this->getinvoiceInfo($add_order_response['orderid']);
                if (isset($invoiceInfo['invoiceid'])) {
                    $created_invoice_id = $invoiceInfo['invoiceid'];
                    //get the invoice data and total sum of price
                    $invoice_detail = (new \Sburina\Whmcs\Client)->post([
                        'action' => 'GetInvoice',
                        'clientid' => Auth::user()->client_id,
                        'invoiceid' => $created_invoice_id,
                    ]);
                    //if success, get the funds amount
                    $credit_appling_amount = 0;
                    if ($invoice_detail['result'] == 'success')
                        $credit_appling_amount = $invoice_detail['total'];

                    $apply_credit = (new \Sburina\Whmcs\Client)->post([
                        'action' => 'ApplyCredit',
                        'clientid' => Auth::user()->client_id,
                        'invoiceid' => $created_invoice_id,
                        'amount' => $credit_appling_amount,
                    ]);
                }
                // apply credit and get the result
            }

            if ($add_order_response['result'] == 'success') {
                return response()->json([
                    'result' => 'success',
                    'data' => $add_order_response,
                    'order_id' => $add_order_response['orderid'],
                ]);
            } else {
                return response()->json([
                    'result' => 'failed',
                    'data' => $add_order_response,
                ]);
            }
        } else {
            return response()->json($add_order_response, 500);
        }
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

    private function getOrderinfo($order_id)
    {
        $orders_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetOrders',
            'userid' => Auth::user()->client_id,
            'id' => $order_id,
        ]);

        return $orders_response;
    }

}