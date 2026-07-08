<?php

namespace Database\Seeders;

use App\Models\AccountType;
use App\Models\MoveType;
use Illuminate\Database\Seeder;

class MoveTypeSeeder extends Seeder
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
                'name' => 'مراحعه واستلام نقديه شفت على نفس الخزنه',
                'in_screen'=> '1',
                'is_private_internal'=> '1',
            ],
            [
                'name' => 'مراحعه واستلام نقديه شفت على خزنه اخرى',
                'in_screen'=> '1',
                'is_private_internal'=> '1',
            ],
            [
                'name' => 'صرف مبلغ لحساب مالى',
                'in_screen'=> '0',
                'is_private_internal'=> '0',
            ],
            [
                'name' => 'صرف مبلغ من حساب مالى',
                'in_screen'=> '0',
                'is_private_internal'=> '0',
            ],
            [
                'name' => 'تحصيل ايراد مبيعات',
                'in_screen'=> '1',
                'is_private_internal'=> '0',
            ],
            [
                'name' => 'صرف نظير مرتجع مبيعات',
                'in_screen'=> '0',
                'is_private_internal'=> '0',
            ],
            [
                'name' => 'صرف سلفه على راتب موظف',
                'in_screen'=> '0',
                'is_private_internal'=> '1',
            ],
            [
                'name' => 'صرف نظير مشتريات من مورد',
                'in_screen'=> '0',
                'is_private_internal'=> '0',
            ],
            [
                'name' => 'تحصيل نظير مرتجع مشتريات من مورد',
                'in_screen'=> '1',
                'is_private_internal'=> '0',
            ],

            [
                'name' => 'ايراد زياده راس المال',
                'in_screen'=> '1',
                'is_private_internal'=> '0',
            ],

            [
                'name' => 'مصاريف شراء',
                'in_screen'=> '0',
                'is_private_internal'=> '0',
            ],
            [
                'name' => 'صرف بنكى',
                'in_screen'=> '0',
                'is_private_internal'=> '0',
            ],
            [
                'name' => 'رد سلفه على راتب موظف',
                'in_screen'=> '1',
                'is_private_internal'=> '1',
            ],
            [
                'name' => 'تحصيل خصومات الموظفين',
                'in_screen'=> '1',
                'is_private_internal'=> '1',
            ],
            [
                'name' => 'صرف مرتب لموظف',
                'in_screen'=> '0',
                'is_private_internal'=> '1',
            ],
            [
                'name' => 'سحب من البنك',
                'in_screen'=> '1',
                'is_private_internal'=> '0',
            ],
            [
                'name' => 'صرف ايراد لراس مال',
                'in_screen'=> '0',
                'is_private_internal'=> '0',
            ],
        ];

        foreach ($data as $row) {
            MoveType::create($row);
        }
    }
}