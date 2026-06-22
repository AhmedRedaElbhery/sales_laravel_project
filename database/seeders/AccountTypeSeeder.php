<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'راس المال',
                'relatedinternalaccounts' => 0,
                'active' => 1,
            ],
            [
                'name' => 'مورد',
                'relatedinternalaccounts' => 1,
                'active' => 1,
            ],
            [
                'name' => 'عميل',
                'relatedinternalaccounts' => 1,
                'active' => 1,
            ],
            [
                'name' => 'مندوب',
                'relatedinternalaccounts' => 1,
                'active' => 1,
            ],
            [
                'name' => 'موظف',
                'relatedinternalaccounts' => 1,
                'active' => 1,
            ],
            [
                'name' => 'بنكى',
                'relatedinternalaccounts' => 0,
                'active' => 1,
            ],
            [
                'name' => 'مصروفات',
                'relatedinternalaccounts' => 0,
                'active' => 1,
            ],
            [
                'name' => 'قسم داخلى',
                'relatedinternalaccounts' => 1,
                'active' => 1,
            ],
            [
                'name' => 'عام',
                'relatedinternalaccounts' => 0,
                'active' => 1,
            ],
        ];

        foreach ($data as $row) {
            AccountType::create($row);
        }
    }
}