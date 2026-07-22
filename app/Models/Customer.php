<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
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