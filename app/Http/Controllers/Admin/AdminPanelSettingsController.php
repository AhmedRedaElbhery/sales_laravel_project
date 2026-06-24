<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPanalSettings;
use App\Http\Requests\AdminPanelSettingRequest;
use App\Models\Accounts;
use App\Models\AccountType;

class AdminPanelSettingsController extends Controller
{
    public function index()
    {
        $data = AdminPanalSettings::where('com_code', auth()->user()->com_code)->first();
        $data['customer_parent_account_name'] = Accounts::select('name')->where('id', $data['customer_parent_account_number'])->first()?->name;
        $data['supplier_parent_account_name'] = Accounts::select('name')->where('id', $data['supplier_parent_account_number'])->value('name');
        if (!empty($data)) {
            if ($data['updated_by'] != null && $data['updated_by'] > 0) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }
        }
        return view('admin.admin_panel_settings.index', ['data' => $data]);
    }

    public function edit()
    {
        $data = AdminPanalSettings::where('com_code', auth()->user()->com_code)->first();
        $accounts =  Accounts::where(['parent_account_number'=>0 ,'com_code'=>auth()->user()->com_code])->get();
        return view('admin.admin_panel_settings.edit', compact('data','accounts'));
    }


    public function update(AdminPanelSettingRequest $request)
    {
        $data = AdminPanalSettings::where('com_code', auth()->user()->com_code)->first();

        $data->system_name = $request->system_name;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->customer_parent_account_number = $request->customer_parent_account_number;
        $data->supplier_parent_account_number = $request->supplier_parent_account_number;
        $data->general_alert = $request->general_alert;
        $data->updated_by = auth()->guard('admin')->id();
        $data->updated_at = date("Y-m-d H:i:s");

        if ($request->hasFile('photo')) {

            $request->validate([
                'photo' => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);

            if (!empty($data->photo)) {

                $oldPath = public_path('assets/admin/uploads/' . $data->photo);

                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // upload new photo
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/admin/uploads'), $filename);

            $data->photo = $filename;
        }

        $data->save();

        return redirect()
            ->route('admin.adminpanelsettings.index');
    }
}