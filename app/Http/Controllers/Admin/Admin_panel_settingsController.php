<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admin_panal_settings;

class Admin_panel_settingsController extends Controller
{
    public function index() {
        $data = Admin_panal_settings::where('com_code',auth()->user()->com_code)->first();;
        if(!empty($data)){
            if($data['updated_by']!= null && $data['updated_by'] > 0 )
            {
                $data['updated_by_admin'] = Admin::where('id' , $data['updated_by'])->value('name');
            }
        }
        return view('admin.admin_panel_settings.index',['data'=>$data]);
    }
}