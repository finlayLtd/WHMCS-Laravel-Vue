<?php

use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CreateVpsServerController;
use App\Http\Controllers\Api\OverviewController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SwitchAccountController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum' ,  'namespace' => 'App\\Http\\Controllers\\Api'], function() {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
    Route::get('category-list', [CategoryController::class, 'getList']);
    Route::get('/user', [ProfileController::class, 'user']);
    Route::put('/user', [ProfileController::class, 'update']);

    Route::get('abilities', function(Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });

    // support-ticket page fetch apis
    Route::get('support-ticket', 'SupportTicketController@index');

    // servers page fetch apis
    Route::get('servers', 'ServersController@index');


    Route::post('ticket-create', 'SupportTicketController@openticket');
    Route::post('get-ticketDetails', 'TicketDetailController@index');
    Route::post('download-file', 'TicketDetailController@downloadFile');
    Route::post('sendReply', 'TicketDetailController@sendReply');
    

    // balance page fetch apis
    Route::get('get-invoices', 'BalanceController@index');


    // switch account
    Route::get('getCurrentState', 'SwitchAccountController@index');
    Route::post('switch', 'SwitchAccountController@switch');
    
    // balance page redirect apis
    Route::post('add_funds_sso', 'SSOController@add_funds_sso');
    Route::post('invoice_detail_sso', 'SSOController@invoice_detail_sso');

    // settings page fetch profile data
    Route::get('get-profileData', 'SettingsController@index');
    Route::post('change_name', 'HomeController@change_name');
    Route::post('invite_user', 'HomeController@invite_user');
    Route::post('remove_access', 'HomeController@remove_access');
    Route::post('get_permission_detail_per_ser', 'HomeController@managePermissions');
    Route::post('edit_user_permissions', 'HomeController@edit_user_permissions');
    
    // create-vps-server apis
    Route::get('create-vps-server', 'CreateVpsServerController@index');
    Route::post('create-vps', 'CreateVpsServerController@create');
    
     // overview apis
     Route::post('overview', 'OverviewController@index');
     Route::post('overview/analysis_data', 'OverviewController@analysis_data');
     Route::post('overview/oslists', 'OverviewController@oslists');
     Route::post('overview/departments_data', 'OverviewController@departments_data');
     Route::post('overview/get_rdns_lists', 'OverviewController@get_rdns_lists');
     Route::post('overview/get_tasks', 'OverviewController@get_tasks');
     Route::post('overview/get_ips', 'OverviewController@get_ips');
     Route::post('overview/get_logs', 'OverviewController@get_logs');
     
    //  overview actions
     Route::post('overview/turnon', 'OverviewController@turnon');
     Route::post('overview/turnoff', 'OverviewController@turnoff');
    //  Route::post('overview/reboot', 'OverviewController@reboot');
     Route::post('overview/poweroff', 'OverviewController@poweroff');
     Route::post('overview/rebuild', 'OverviewController@rebuild');
     Route::post('overview/changepwd', 'OverviewController@changeRootPwd');
     Route::post('overview/changehostName', 'OverviewController@changehostNames');
     Route::post('overview/changeip', 'OverviewController@changeip');
     Route::post('overview/checkhostName', 'OverviewController@checkhostName');

     Route::post('overview/addrdns', 'OverviewController@addRDNS');
     Route::post('overview/deleterdns', 'OverviewController@deleteRDNS');
     //  connect vnc api
     Route::post('overview/noVNC-connect', 'OverviewController@connectvnc');
    
});

Route::get('category-list', [CategoryController::class, 'getList']);
Route::get('get-posts', [PostController::class, 'getPosts']);
Route::get('get-category-posts/{id}', [PostController::class, 'getCategoryByPosts']);
Route::get('get-post/{id}', [PostController::class, 'getPost']);

Route::post('/whmcs/forgot-password', [AuthenticatedSessionController::class, 'forgotPassword']);
