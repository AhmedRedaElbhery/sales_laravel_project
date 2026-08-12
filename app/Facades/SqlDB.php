<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SqlDB extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Database\DB::class;
    }
}