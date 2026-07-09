<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuriesTransaction extends Model
{
    use HasFactory;
    protected $table='treasuries_transaction';
    protected $fillable = [
        'treasuries_id',
        'move_type',
        'bill_code',
        'account_number',
        'from_account',
        'is_approved',
        'shift_id',
        'money_for_account',
        'money',
        'byan',
        'added_by',
        'updated_by',
        'date',
        'com_code',
        'isal_number',
    ];
}