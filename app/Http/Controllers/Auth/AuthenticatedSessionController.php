<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Sburina\Whmcs\Facades\Whmcs;
use Str;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $data = Whmcs::sbValidateLogin(
            $request->email,
            $request->password
        );
        if($data['result'] == 'error')
        {
            return response()->json([
                'errors' => ['email' => ['Email or Password is Invalid']]
            ], 400);
        }

        $userAbilities = [
            [
                'action' => 'manage',
                'subject' => 'all'
            ]
        ];
        
        $user = User::where('whmcs_id' ,  $data['userid'])->first();
        
        $client_data = (new \Sburina\Whmcs\Client)->post([
            'action' => 'GetClientsDetails',
            'email' => $request->email,
        ]);

        if(!$user)
        {
            $user = new User();
        }
       
        $name = $client_data['firstname'];

        //client_id concept and user_id concept is different
    
        $user->client_id = $client_data['client_id'];
        $user->credit = $client_data['credit'];
        
        $user->whmcs_id = $data['userid'];
        $user->name = $name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $request->authenticate();
       
        //print_r(Auth::user()); die;
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'userAbilities' => $userAbilities,
            'accessToken' => $token,
            'userData' => [
                'id' => $data['userid'],
              
            ]
        ]);
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->noContent();
        }

        return redirect('/');
    }

    /**
     * Create User
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {   
        $register_result = (new \Sburina\Whmcs\Client)->post([
            'action' => 'AddClient',
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'password2' => $request['password'],
            'address1' => ' ',
            'city' => ' ',
            'state' => ' ',
            'postcode' => ' ',
            'country' => ' ',
            'phonenumber' => ' ',
        ]);

        if($register_result['result']=='success'){
            return response()->json(['message' => 'Registration Successfully', 'data' => 'success'], 200);
        } else{
            // return response()->json(['error' => 'Failed to register user'], 400);
            return response()->json(['message' => $register_result['result'], 'data' => 'failed'], 200);
        }
    }

    public function forgotPassword(Request $request)
    {   
        $reset_response = (new \Sburina\Whmcs\Client)->post([
            'action' => 'ResetPassword',
            'email' => $request->email,
        ]);

        if($reset_response['result']=='success'){
            return response()->json(['message' => 'Successfully sent forgot password', 'data' => 'success'], 200);
        } else{
            // return response()->json(['error' => 'Failed to register user'], 400);
            return response()->json(['message' => $reset_response['result'], 'data' => 'failed'], 200);
        }
    }

    
}
