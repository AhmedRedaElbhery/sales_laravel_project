<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMaterialType extends Model
{
    use HasFactory;
    protected $table='sales_material_types';
    protected $fillable = [
        'name',
        'added_by',
        'updated_by',
        'com_code',
        'active',
        'date',
        'created_at',
        'updated_at',
    ];
}