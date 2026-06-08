<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasuryDelivery extends Model
{
    use HasFactory;
    public $table= 'treasuries_delivery';
    public $fillable = ['treasuries_id','treasuries_can_delivery_id','com_code','added_by','updated_by'];
}