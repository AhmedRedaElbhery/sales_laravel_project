<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin_panal_settings;

class AdminPanelSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $setting = new Admin_panal_settings();
        $setting->system_name = 'company name';
        $setting->photo = '';
        $setting->active = 1;
        $setting->general_alert = '';
        $setting->address = 'Cairo';
        $setting->phone = '0123456789';
        $setting->added_by = 1;
        $setting->updated_by = 0;
        $setting->com_code = 1;
        $setting->updated_at = null;
        $setting->save();
    }
}