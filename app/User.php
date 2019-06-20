<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Role;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','profile_picture', 'status', 'salary', 'man_hour_rate', 'number_id', 'nik', 'type',
        'eat_allowance', 'transportation_allowance', 'medical_allowance', 'bpjs_tk', 'bpjs_ke', 'incentive', 'position', 'work_activation_date', 'has_workshop_allowance', 'workshop_allowance_amount', 'additional_allowance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function roles(){

        return $this->belongsToMany('App\Role');
    }

    //----Authorization blocks--
    public function hasRole($role)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        if (is_string($role)) {
            return $this->role->contains('name', $role);
        }
        return !! $this->roles->intersect($role)->count();
    }

    public function isSuperAdmin()
    {
       if ($this->roles->contains('name', 'Super Admin')) {
            return true;
        }
        return false;
    }
    //----ENDAuthorization blocks---


    public function time_reports()
    {
        return $this->belongsToMany('App\TimeReport', 'time_report_user')
            ->withPivot('period_id', 'incentive', 'allowance', 'non_allowance', 'off_allowance', 'normal_time', 'overtime_one', 'overtime_two', 'overtime_three', 'overtime_four');
    }

    public function cashbonds()
    {
        return $this->hasMany('App\Cashbond', 'user_id');
    }

    public function bank_accounts()
    {
        return $this->hasMany('App\BankAccount', 'user_id');
    }

    
    //Leaves
    public function leaves()
    {
        return $this->hasMany('App\Leave', 'user_id');
    }

}
