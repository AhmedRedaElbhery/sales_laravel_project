<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCategory extends Model
{
    use HasFactory;
    protected $table='suppliercategory';
    protected $fillable = [
        'name',
        'added_by',
        'updated_by',
        'com_code',
        'active',
        'date',
    ];
}