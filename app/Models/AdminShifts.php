<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminShifts extends Model
{
    use HasFactory;
    protected $table='admin_shifts';
    protected $fillable = [
        'admin_id',
        'treasuries_id',
        'treasuries_start_balance',
        'treasuries_end_balance',
        'start_shift',
        'end_shift',
        'is_finished',
        'is_delivered',
        'delivered_to_shift_id',
        'delivered_to_treasuries_id',
        'money_should_delivered',
        'what_alredy_delivered',
        'money_status',
        'money_status_value',
        'receive_on_the_same_treasuries',
        'review_receive_date',
        'treasuries_transaction_id',
        'added_by',
        'com_code',
        'notes',
        'date',
    ];
}