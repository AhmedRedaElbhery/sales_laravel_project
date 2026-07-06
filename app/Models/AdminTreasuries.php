<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminTreasuries extends Model
{
    use HasFactory;
    protected $table = 'admin_treasuries';
    protected $fillable = [
        'admin_id',
        'treasuries_id',
        'active',
        'added_by',
        'com_code',
        'updated_by',
        'date',
    ];
}