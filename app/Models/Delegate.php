<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    use HasFactory;
    protected $table = "delegates";
    protected $fillable = [
        'name',
        'address',
        'account_number',
        'start_balance',
        'start_balance_status',
        'current_balance',
        'city_id',
        'delegate_code',
        'commission_type',
        'percent_Wholesale_commission',
        'percent_half_wholesale_commission',
        'percent_retail_commission',
        'percent_collect_commission',
        'added_by',
        'updated_by',
        'date',
        'active',
        'com_code',
        'notes'
    ];
}