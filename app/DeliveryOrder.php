<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $table = 'delivery_orders';

    protected $fillable = [
    	'code', 'project_id', 'user_id', 'sender_id', 'status', 'receiver_name'
    ];
    
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    public function creator()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function sender()
    {
    	return $this->belongsTo('App\User', 'sender_id');
    }
}
