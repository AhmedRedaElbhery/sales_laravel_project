<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccountTypesController extends Controller
{
    public function index()
    {
        $data = AccountType::get();

        return view('admin.account_types.index',compact('data'));
    }
}