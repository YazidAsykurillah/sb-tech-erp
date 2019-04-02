<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalAllowance extends Model
{
    protected $table = 'medical_allowances';

    protected $fillable = ['period_id', 'user_id', 'amount', 'multiplier', 'total_amount'];
}
