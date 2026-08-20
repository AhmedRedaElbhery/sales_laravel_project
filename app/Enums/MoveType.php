<?php

namespace App\Enums;

enum MoveType: int
{
    case MoneyCollection = 9; // تحصيل نظير مرتجع مشتريات من مورد
    case MoneyForSale = 5; // تحصيل ايراد مبيعات
    case MoneyForBuy = 8; //صرف نظير مشتريات من مورد
}