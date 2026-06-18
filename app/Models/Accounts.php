<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;
    protected $table="accounts";
    protected $fillable = ['name','account_type ','parent_account_number',
    'account_number','start_balance','current_balance','added_by','updated_by',
    'date','is_archived','com_code','notce','other_table_fk','is_parent'];

}