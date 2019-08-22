<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\InternalRequest;
use App\BankAccount;
use App\Project;
use App\User;
use App\Cash;

class InternalRequest extends Model
{
    protected $table = 'internal_requests';

    protected $fillable = [
                            'code', 'description', 'amount', 'remitter_bank_id',
                            'beneficiary_bank_id', 'bank_target_id', 'project_id', 'requester_id', 'status', 'approver_id', 'transaction_date', 'settled', 'is_petty_cash',
                            'vendor_id'
                        ];

    public function remitter_bank()
    {
    	return $this->belongsTo('App\Cash', 'remitter_bank_id');
    }

    public function beneficiary_bank()
    {
        return $this->belongsTo('App\BankAccount', 'beneficiary_bank_id');
    }

    public function bank_target()
    {
        return $this->belongsTo('App\Cash', 'bank_target_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function requester()
    {
        return $this->belongsTo('App\User', 'requester_id');
    }

    public function settlement()
    {
        return $this->hasOne('App\Settlement');
    }

    public function vendor(){
        return $this->belongsTo('App\Vendor');
    }
}
