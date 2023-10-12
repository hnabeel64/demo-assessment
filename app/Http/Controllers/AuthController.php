<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginSuperAdmin(){
        return view('login');
    }

    public function login(LoginRequest $request){
        if(Auth::guard('superadmin')->attempt(
        [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 1,
        ],
        $request->get('remmeber')))
        {
            return redirect('/dashboard');
        }
        else{
            return back()->withErrors('Invalid Credentials');
        }
    }

    public function dashboard(){
        return view('SuperAdmin.index');
    }
}
