<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCard extends Model
{
    use HasFactory;
    protected $table = 'itemcards';
    protected $fillable = [
        'name',
        'item_type',
        'categories_id',
        'parent_id',
        'has_retail_unit',
        'retail_unit_id',
        'parent_unit_id',
        'retail_unit_to_parent',
        'price',
        'Wholesale_price',
        'half_Wholesale_price',
        'retail_price',
        'retail_Wholesale_price',
        'retail_half_Wholesale_price',
        'cost_price',
        'retail_cost_price',
        'has_fixed_price',
        'quantity',
        'retail_quantity',
        'all_retail_quantity',
        'added_by',
        'updated_by',
        'active',
        'date',
        'com_code',
        'item_code',
        'barcode',
    ];
}