<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingExpense extends Model
{
    protected $table = 'accounting_expenses';

    protected $fillable = ['code', 'name'];
}
