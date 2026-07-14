<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemMovementType;

class ItemMovementTypeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'=>'مشتريات' ,
            ],
            [
                'name'=>'مرتجع مشتريات باصل الفاتوره' ,
            ],
            [
                'name'=> 'مرتجع مشتريات عام',
            ],
            [
                'name'=> 'مبيعات',
            ],
            [
                'name'=> 'مرتجع مبيعات',
            ],
            [
                'name'=> 'صرف داخلى لمندوب',
            ],
            [
                'name'=> 'مرتجع صرف داخلى لمندوب',
            ],
            [
                'name'=> 'تحويل بين المخازن',
            ],
            [
                'name'=> 'مبيعات صرف مباشر لعميل',
            ],
            [
                'name'=> 'مبيعات صرف مباشر لعميل',
            ],
            [
                'name'=> 'مبيعات صرف لمندوب التوصيل',
            ],
            [
                'name'=> 'صرف خامات لخط التصنيع',
            ],
            [
                'name'=> 'رد خامات من خط التصنيع',
            ],
            [
                'name'=> 'استلام انتاج من خط التصنيع',
            ],
            [
                'name'=> 'رد انتاج لخط التصنيع',
            ],
        ];

        foreach ($data as $row) {
            ItemMovementType::create($row);
        }
    }
}