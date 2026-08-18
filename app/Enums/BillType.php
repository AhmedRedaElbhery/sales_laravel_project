<?php

namespace App\Enums;

enum BillType: int
{
    case Cash = 0;
    case Credit = 1;
}