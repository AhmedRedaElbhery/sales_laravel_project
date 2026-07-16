<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesBills extends Model
{
    use HasFactory;
    protected $table= 'sales_bills';
    protected $fillable = [
        'auto_serial',
        'doc_number',
        'invoice_date',
        'delegate_code',
        'delegate_auto_invoice',
        'customer_code',
        'sales_material_type_id',
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
        'customer_balance_before_pill',
        'customer_balance_after_pill',
        'notes',
        'added_by',
        'updated_by',
        'account_number',
    ];
}