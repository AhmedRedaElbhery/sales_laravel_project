<?php

namespace App\Enums;

enum SalesType: int
{
    case WholePrice = 0;
    case HafeWholePrice = 1;
    case RetailPrice = 2;
}