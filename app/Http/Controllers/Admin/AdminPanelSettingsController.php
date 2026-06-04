<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Admin_panal_settings;
use App\Http\Requests\AdminPanelSettingRequest;

class AdminPanelSettingsController extends Controller
{
    public function index()
    {
        $data = Admin_panal_settings::where('com_code', auth()->user()->com_code)->first();
        if (!empty($data)) {
            if ($data['updated_by'] != null && $data['updated_by'] > 0) {
                $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
            }
        }
        return view('admin.admin_panel_settings.index', ['data' => $data]);
    }

    public function edit()
    {
        $data = Admin_panal_settings::where('com_code', auth()->user()->com_code)->first();
        return view('admin.admin_panel_settings.edit', ['data' => $data]);
    }


    public function update(AdminPanelSettingRequest $request)
    {
        $data = Admin_panal_settings::where('com_code', auth()->user()->com_code)->first();

        $data->system_name = $request->system_name;
        $data->address = $request->address;
        $data->phone = $request->phone;
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