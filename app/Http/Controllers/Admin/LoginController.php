<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequist;

class LoginController extends Controller
{
    public function show_login_view(){
        return view('admin.auth.login');
    }

    public function login(LoginRequist $request){
        if(auth()->guard('admin')->attempt(['username'=>$request->input('username'),'password'=>$request->input('password')]))
        {
            return redirect()->route('admin.dashboard');
        }
        else
        {
            return redirect()->route('admin.showlogin');
        }
    }
    public function logout(){
        auth()->logout();
        return redirect()->route('admin.showlogin');
    }
/*
to create the first admin using tinker
    public function make_new_admin()
    {
        $admin = new App\Models\Admin();
        $admin->name = 'admin';
        $admin->email = 'test@a';
        $admin->username = 'admin';
        $admin->password = bcrypt("admin");
        $admin->com_code = 1;
        $admin->save();
    }
        */
}