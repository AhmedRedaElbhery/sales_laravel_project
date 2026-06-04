<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = new Admin();
        $admin->name = 'admin';
        $admin->email = 'test@a';
        $admin->username = 'admin';
        $admin->password = bcrypt('admin');
        $admin->com_code = 1;
        $admin->save();
    }
}