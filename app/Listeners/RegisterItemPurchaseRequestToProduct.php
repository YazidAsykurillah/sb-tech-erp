<?php

namespace App\Listeners;

use App\Events\ItemPurchaseRequestIsReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Product;
class RegisterItemPurchaseRequestToProduct
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ItemPurchaseRequestIsReceived  $event
     * @return void
     */
    public function handle(ItemPurchaseRequestIsReceived $event)
    {
        $itemPurchaseRequest = $event->itemPurchaseRequest;
        $itemPurchaseRequest_name = $itemPurchaseRequest->item;
        //check if there's a product name in the table
        $is_product_exist = Product::where('name','=',$itemPurchaseRequest_name)->count();
        if($is_product_exist ==0){
            $product = new Product;
            $product->code = 'PRD-'.time();
            $product->name = $itemPurchaseRequest_name;
            $product->initial_stock = 0;
            $product->stock = $itemPurchaseRequest->quantity;
            $product->unit = $itemPurchaseRequest->unit;
            $product->price = $itemPurchaseRequest->price;
            $product->save();
        }else{
            $product = Product::where('name','=',$itemPurchaseRequest_name)->firstOrFail();
            if($product){
                $new_stock = $product->stock+$itemPurchaseRequest->quantity;
                //update product stock
                $product->stock = $new_stock;
                $product->save();
            }

        }
        

    }
}
