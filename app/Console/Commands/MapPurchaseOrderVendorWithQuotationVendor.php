<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\PurchaseOrderVendor;
use App\PurchaseRequest;
use App\QuotationVendor;

class MapPurchaseOrderVendorWithQuotationVendor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase-order-vendor:fix-zero-quotation-vendor-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to fix purchase order vendor which has zero quotation vendor id, quotation order vendor id should be based on purchase request relation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Preparing');
        $this->info('Getting purchase order vendor to fix');
        //Get purchase order vendor which quotation vendor is empty or zero
        $purchase_order_vendors = PurchaseOrderVendor::where('quotation_vendor_id', '=', 0)->get();
        $count = $purchase_order_vendors->count();
        if($count){
            $povCounter =0;
            foreach($purchase_order_vendors as $pov){
                $pov = PurchaseOrderVendor::findOrFail($pov->id);
                if($pov->purchase_request){
                    $purchase_request = PurchaseRequest::findOrFail($pov->purchase_request->id);
                    $quotation_vendor_id = $purchase_request->quotation_vendor ? $purchase_request->quotation_vendor->id : NULL;
                    if($quotation_vendor_id){
                        $pov->quotation_vendor_id = $quotation_vendor_id;
                    }
                }
                $pov->save();
                $povCounter++;
            }
            $this->info($povCounter);
        }else{

        }
    }
}
