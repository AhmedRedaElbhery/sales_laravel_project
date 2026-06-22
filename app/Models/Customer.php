<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers";
    protected $fillable = [
        'name',
        'address',
        'account_number',
        'start_balance',
        'start_balance_status',
        'current_balance',
        'city_id',
        'customer_code',
        'added_by',
        'updated_by',
        'date',
        'active',
        'com_code',
        'notes'
    ];
}