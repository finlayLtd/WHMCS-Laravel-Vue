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

class ServersController extends Controller
{

    public function index(Request $request)
    {
        $products = [];
        $states = [];
        $state_order = [];
        $product_group = [
            '2' => 'VPS-Netherlands',
            '3' => 'VPS-USA'
        ];

        $order_state_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetOrderStatuses',
        ]);

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

        if ($order_state_response['result'] == 'success') {
            foreach ($order_state_response['statuses']['status'] as $state_info)
                array_push($states, $state_info['title']);
            asort($states);
        }

        $temp = $states[1];
        $states[1] = $states[0];
        $states[0] = $temp;

        $orders_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetClientsProducts',
            'clientid' => $request->client_id,
        ]);

        $products_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetProducts',
        ]);

        $products = $products_response['products']['product'];

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

        if ($orders_response['result'] == 'success') {
            if ($orders_response['totalresults'] > 0) {
                $orders = $orders_response['products']['product'];
                if ($request->orderby && $request->orderby != '')
                    ;
                $orders = collect($orders)->sortByDesc($request->orderby)->values()->all();
                foreach ($states as $state) foreach ($orders as $order)
                        $state_order[$state] = []; foreach ($states as $state) foreach ($orders as $order) {
                        if ($order['status'] == $state) {
                            array_push($state_order[$state], $order);
                            $last_index = count($state_order[$state]) - 1;
                            if (strpos($order['configoptions']['configoption'][1]['value'], 'Netherlands') !== false) {
                                $state_order[$state][$last_index]['flag'] = 'flag-en';
                            } else {
                                $state_order[$state][$last_index]['flag'] = 'flag-nl';
                            }

                            $system = explode('-', $order['configoptions']['configoption'][1]['value'])[0];
                            switch ($system) {
                                case 'windows':
                                    $state_order[$state][$last_index]['sys_log'] = 'windows';
                                    break;
                                case 'ubuntu':
                                    $state_order[$state][$last_index]['sys_log'] = 'ubuntu';
                                    break;
                                case 'centos':
                                    $state_order[$state][$last_index]['sys_log'] = 'centos';
                                    break;
                                case 'debian':
                                    $state_order[$state][$last_index]['sys_log'] = 'debian';
                                    break;
                                case 'almalinux':
                                    $state_order[$state][$last_index]['sys_log'] = 'almalinux';
                                    break;
                                case 'fedora':
                                    $state_order[$state][$last_index]['sys_log'] = 'fedora';
                                    break;
                                case 'rocky':
                                    $state_order[$state][$last_index]['sys_log'] = 'rocky';
                                    break;
                                default:
                                    $state_order[$state][$last_index]['sys_log'] = 'windows';
                                    break;
                            }
                        }
                    }
            }
        }

        return response()->json(compact('states', 'state_order', 'products', 'product_group'));

    }

    private function getVPSList()
    {
        $key = 'N8q5PHMfwvMQHMHYkytYtTydVWoLsWNC';
        $pass = 'CcuJEN365CusfakK2NA8uVGSg0e8e36J';
        $ip = '37.59.33.165';

        $v = new Admin($ip, $key, $pass);
        $vps = $v->listvs();

        print_r($vps);
    }
}