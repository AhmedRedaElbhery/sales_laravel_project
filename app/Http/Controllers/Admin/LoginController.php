<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequist;

class LoginController extends Controller
{
    public function showLoginView()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequist $request)
    {
        if (auth()->guard('admin')->attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.showlogin');
        }
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.showlogin');
    }
}