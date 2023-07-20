<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum' ,  'namespace' => 'App\\Http\\Controllers\\Api'], function() {
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
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
    
    
    
    
});

Route::get('category-list', [CategoryController::class, 'getList']);
Route::get('get-posts', [PostController::class, 'getPosts']);
Route::get('get-category-posts/{id}', [PostController::class, 'getCategoryByPosts']);
Route::get('get-post/{id}', [PostController::class, 'getPost']);

Route::post('/whmcs/forgot-password', [AuthenticatedSessionController::class, 'forgotPassword']);
