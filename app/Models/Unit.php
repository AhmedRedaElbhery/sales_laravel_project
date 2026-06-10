<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table='units';
    protected $fillable = [
        'name',
        'is_master',
        'added_by',
        'updated_by',
        'com_code',
        'active',
        'date',
        'created_at',
        'updated_at',
    ];
}