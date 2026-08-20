<?php

namespace App\Enums;

enum AccountTypes: int
{
    case Supplier = 2;
    case Customer = 3;
    case Delegate = 4;
}