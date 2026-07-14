<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMovement extends Model
{
    use HasFactory;
    protected $table='item_movement';
    protected $fillable = [
        'item_code',
        'movement_type',
        'table_code',
        'table_details_code',
        'quantity_before_movement',
        'quantity_after_movement',
        'added_by',
        'com_code',
        'date',
        'byan',
    ];
}