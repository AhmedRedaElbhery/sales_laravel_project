<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batche extends Model
{
    use HasFactory;
    protected $table='batches';
    protected $fillable = [
        'auto_serial',
        'store_id',
        'item_code',
        'unit_id',
        'unit_price',
        'quantity',
        'total_cost',
        'production_date',
        'end_date',
        'com_code',
        'added_by',
        'updated_by',
        'is_archived',
    ];
}