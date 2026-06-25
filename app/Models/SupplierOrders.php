<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrders extends Model
{
    use HasFactory;
    protected $table= 'suppliers_orders';
    protected $fillable = [
        'order_type',
        'auto_serial',
        'doc_number',
        'order_date',
        'supplier_code',
        'is_approved',
        'com_code',
        'total_before_discount',
        'discount_type',
        'discount_percent',
        'discount_value',
        'tax_percent',
        'tax_value',
        'total_cost',
        'money_for_account',
        'pill_type',
        'what_paid',
        'what_remain',
        'treasuries_transaction_id',
        'supplier_balance_before_pill',
        'supplier_balance_after_pill',
        'notes',
        'added_by',
        'updated_by',
        'account_number',
    ];
}