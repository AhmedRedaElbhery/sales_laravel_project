<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "suppliers";
    protected $fillable = [
        'name',
        'address',
        'account_number',
        'start_balance',
        'start_balance_status',
        'current_balance',
        'city_id',
        'supplier_code',
        'supplier_category_id',
        'added_by',
        'updated_by',
        'date',
        'active',
        'com_code',
        'notes'
    ];
}