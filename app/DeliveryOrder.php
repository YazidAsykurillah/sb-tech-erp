<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $table = 'delivery_orders';

    protected $fillable = [
    	'code', 'purchase_order_vendor_id', 'user_id'
    ];
}
