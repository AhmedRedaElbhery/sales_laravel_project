<?php

namespace App\Enums;

enum OrderType: int
{
    case PurchaseInvoice = 1;
    case PurchaseReturnInvoice = 2;
}