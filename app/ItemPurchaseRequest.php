<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPurchaseRequest extends Model
{
   	protected $table = 'item_purchase_request';

   	protected $fillable = ['purchase_request_id', 'item', 'quantity', 'unit', 'price', 'sub_amount', 'is_received'];
}
