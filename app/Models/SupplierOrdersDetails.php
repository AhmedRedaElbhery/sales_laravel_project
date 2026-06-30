<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrdersDetails extends Model
{
    use HasFactory;
    protected $table = "suppliers_orders_details";
    protected $fillable = [
        'supplier_auto_serial',
        'order_type',
        'com_code',
        'delivered_quantity',
        'isparentunit',
        'unit_id',
        'unit_price',
        'total_price',
        'order_date',
        'added_by',
        'updated_by',
        'item_code',
        'batch_id',
        'end_date',
        'production_date',
        'item_card_type',
    ];
}