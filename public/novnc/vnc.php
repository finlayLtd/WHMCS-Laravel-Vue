<?php

include_once('admin.php');

$key = 'API';
$pass = 'PASS';
$ip = 'YOUR_IP';

$admin = new Virtualizor_Admin_API($ip, $key, $pass);

$post = array();
$post['novnc'] = YOUR_VPSID;
$res = $admin->vnc($post);

$info = $res['info'];

// This base_url will be your public directory, so change it accordingly
// In my case it was https://localhost/novnc/vnc.php
$base_url = '/novnc/';

// CHANGE /themes/default/novnc/ TO $base_url in app/ui.js before running this code

$novnc_viewer = file_get_contents(dirname(__FILE__).'/vnc_auto_virt.html');

$proto = 'http';
$port = 4081;
$websockify = 'websockify';
if(!empty($_SERVER['HTTPS'])){
    $proto = 'https';
    if($_SERVER['SERVER_PORT'] == '443'){
        $port = 443;
    }else{
        $port = 4083;
    }
    $websockify = 'novnc/';
}

$vnc_token = $post['novnc'];

$array = array('HOST' => $ip,
            'PORT' => $port,
            'PROTO' => $proto,
            'WEBSOCKET' => $websockify,
            'TOKEN' => $vnc_token,
            'PASSWORD' => $info['password'],
            'base_url' => $base_url);

foreach($array as $k => $v){
		
    $novnc_viewer = str_replace('{{'.$k.'}}', $v, $novnc_viewer);

}

echo $novnc_viewer;
