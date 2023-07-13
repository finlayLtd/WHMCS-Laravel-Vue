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
        //dd($data);
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
        if(!$user)
        {
            $user = new User();
        }
       
        preg_match('/([^@]+)/', $request->email , $matches);
        $name = $matches[1];
    
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
    public function register(RegisterRequest $request)
    {
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            return response(['error' => 1, 'message' => 'user already exists'], 409);
        }

        $user = User::create([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'name' => $request['name'],
        ]);

        return $this->successResponse($user, 'Registration Successfully');
    }
}
