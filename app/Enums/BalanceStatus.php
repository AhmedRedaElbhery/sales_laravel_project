<?php

namespace App\Enums;

enum BalanceStatus: int
{
    case Balanced = 0; // متزن
    case Creditor = 1; // دائن
    case Debtor = 2; // مدين
}