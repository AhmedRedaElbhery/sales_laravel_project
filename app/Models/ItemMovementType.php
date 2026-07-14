<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMovementType extends Model
{
    use HasFactory;
    protected $table='item_movement_types';
    protected $fillable = [
        'name',
    ];
}