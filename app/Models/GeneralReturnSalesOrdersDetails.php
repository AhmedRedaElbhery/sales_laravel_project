<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralReturnSalesOrdersDetails extends Model
{
    use HasFactory;
    protected $table = "general_return_sales_orders_details";
    protected $fillable = [
        'com_code',
        'quantity',
        'isparentunit',
        'unit_id',
        'unit_price',
        'total_price',
        'invoice_date',
        'end_date',
        'production_date',
        'added_by',
        'updated_by',
        'item_code',
        'item_card_type',
        'batch_id',
        'sale_type',
        'normal_sale',
        'bill_auto_serial',
    ];
}