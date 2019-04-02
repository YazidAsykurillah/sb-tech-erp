<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllowanceItem extends Model
{
    protected $table = 'allowance_items';

    protected $fillable = ['allowance_id', 'type', 'amount', 'multiplier', 'total_amount'];
}
