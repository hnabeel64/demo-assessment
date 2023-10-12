<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginAdmin(){
        return view('Admin.login');
    }

    public function login(LoginRequest $request, $subdomain){

        if(Auth::guard('admin')->attempt(
        [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 2,
        ],
        $request->get('remmeber')))
        {
            return redirect('/dashboard');
        }
        elseif(Auth::attempt(
            [
                'email' => $request->email,
                'password' => $request->password,
                'role_id' => 3,
            ],
            $request->get('remmeber'))){
                return redirect()->route('users.dashboard', $subdomain);
        }
        else{
            return back()->withErrors('Invalid Credentials');
        }
    }

    public function dashboard(){
        return view('Admin.Dashboard.index');
    }

    public function userDashboard(){
        return view('User.Dashboard.index');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        Session::regenerate();
        return redirect('/login');
    }

    public function userLogout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
