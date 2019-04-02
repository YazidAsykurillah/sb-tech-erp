<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Event;
use App\Events\TransferInvoiceVendor;

use App\InternalRequest;
use App\InvoiceVendor;
use App\InvoiceVendorTax;
use App\Settlement;
use App\Cashbond;
use App\Cash;
use App\Transaction;
use App\TheLog;

class TransferTaskController extends Controller
{

    public function internal_request()
    {
    	return view('transfer-task.internal_request');
    }

    public function transferInternalRequest(Request $request){

    	$internal_request = InternalRequest::findOrFail($request->internal_request_id_to_transfer);
        if($internal_request->type == 'pindah_buku'){
            return $this->transferInternalRequestPindahBuku($internal_request);
        }
        else{
            //regiter to transaction
            $this->register_transaction_from_internal_request($internal_request);

            //update accounted status
            $internal_request->accounted = TRUE;
            $internal_request->transaction_date = date('Y-m-d');
            $internal_request->save();
            return redirect()->back()
                ->with('successMessage', "$internal_request->code has been transfered");
        }
        
    }

    protected function transferInternalRequestPindahBuku($internal_request)
    {
        //register transaction for the bank source // the debet

        $transaction_for_source = $this->transaction_for_source($internal_request);
        //register transaction for the bank target // the Credit
        $transaction_for_target = $this->transaction_for_target($internal_request);

        //transaction is done, now update the internal request it self
        $internal_request->accounted = TRUE;
        $internal_request->transaction_date = date('Y-m-d');
        $internal_request->settled = TRUE;
        $internal_request->save();
        return redirect()->back()
                ->with('successMessage', "$internal_request->code has been transfered");

    }

    protected function transaction_for_source($internal_request)
    {
        //get the cash model
        $cash = Cash::find($internal_request->remitter_bank_id);

        $transaction = new Transaction;
        $transaction->cash_id = $internal_request->remitter_bank_id;
        $transaction->refference = 'internal_request';
        $transaction->refference_id = $internal_request->id;
        $transaction->refference_number = $internal_request->code;
        $transaction->type = 'debet';
        $transaction->amount = $internal_request->amount;
        $transaction->notes = $internal_request->description;
        $transaction->transaction_date = date('Y-m-d');
        $transaction->reference_amount = $cash->amount - $internal_request->amount;
        $transaction->save();

        //now fix the cash amount,
        if($cash){
            $cash->amount = $cash->amount - $internal_request->amount;
            $cash->save();
        }
    }

    protected function transaction_for_target($internal_request)
    {

        $cash = Cash::find($internal_request->bank_target_id);

        $transaction = new Transaction;
        $transaction->cash_id = $internal_request->bank_target_id;
        $transaction->refference = 'internal_request';
        $transaction->refference_id = $internal_request->id;
        $transaction->refference_number = $internal_request->code;
        $transaction->type = 'credit';
        $transaction->amount = $internal_request->amount;
        $transaction->notes = $internal_request->description;
        $transaction->transaction_date = date('Y-m-d');
        $transaction->reference_amount = $cash->amount + $internal_request->amount;
        $transaction->save();

        //now fix the cash amount id,
        
        if($cash){
            $cash->amount = $cash->amount + $internal_request->amount;
            $cash->save();
        }
    }


    public function approveInternalRequest(Request $request)
    {
        $internal_request = InternalRequest::findOrFail($request->internal_request_id_to_approve);
        $internal_request->remitter_bank_id = $request->remitter_bank_id;
        $internal_request->beneficiary_bank_id = $request->beneficiary_bank_id;
        $internal_request->accounted_approval = 'approved';
        $internal_request->save();
        return redirect()->back()
            ->with('successMessage', "Internal Request $internal_request->code has been approved to be transfered");
    }

    public function approveInternalRequestMultiple(Request $request)
    {
        $internal_request_multiple = $request->internal_request_multiple;
        $count = count($internal_request_multiple);
        foreach($internal_request_multiple as $internal_request){
            $ir = InternalRequest::findOrFail($internal_request);
            if($ir->accounted_approval == 'pending'){
                $ir->remitter_bank_id = $request->remitter_bank_id_multiple;
                $ir->beneficiary_bank_id = $request->beneficiary_bank_id_multiple;
                $ir->accounted_approval = 'approved';
                $ir->save();
            }
           
        }
        return redirect()->back()
            ->with('successMessage', "$count Internal Request(s) has been approved to be transfered");
    }

    protected function register_transaction_from_internal_request($internal_request)
    {
        //get the cash model
        $cash = Cash::find($internal_request->remitter_bank_id);


        $transaction = new Transaction;
        $transaction->cash_id = $internal_request->remitter_bank_id;
        $transaction->refference = 'internal_request';
        $transaction->refference_id = $internal_request->id;
        $transaction->refference_number = $internal_request->code;
        $transaction->type = 'debet';
        $transaction->amount = $internal_request->amount;
        $transaction->transaction_date = date('Y-m-d');
        $transaction->notes = $internal_request->description;

        //reference amount is taken from the operation result between curren cash amount, transaction type and the transaction amount it self
        //since it comes from internal request, it is always subtracting the cash amount
        $transaction->reference_amount = $cash->amount - $internal_request->amount;
        $transaction->save();

        //now fix the cash amount id,
        
        if($cash){
            $cash->amount = $cash->amount - $internal_request->amount;
            $cash->save();
        }

    }


    public function approveInternalRequestPindahBuku(Request $request)
    {
        $internal_request = InternalRequest::findOrFail($request->internal_request_pindah_buku_id_to_approve);
        //remittter_bank_id is bank_source_id input
        $internal_request->remitter_bank_id = $request->bank_source_id;
        $internal_request->bank_target_id = $request->bank_target_id;
        $internal_request->accounted_approval = 'approved';
        $internal_request->save();
        return redirect()->back()
            ->with('successMessage', "Internal Request $internal_request->code has been approved to be transfered");
    }


    //return transfer task invoice vendor lists page
    public function invoice_vendor()
    {
        return view('transfer-task.invoice_vendor');
    }

    

    public function approveInvoiceVendor(Request $request)
    {
        $invoice_vendor = InvoiceVendor::findOrFail($request->invoice_vendor_id_to_approve);
        //remittter_bank_id is bank_source_id input
        $invoice_vendor->cash_id = $request->remitter_bank_id;
        $invoice_vendor->accounted_approval = 'approved';
        $invoice_vendor->save();

        //register to the_logs table;
        $log_description = "approved invoice vendor to be registered to transfer task";
        $log = $this->register_to_the_logs('invoice_vendor', 'update', $request->invoice_vendor_id_to_approve, $log_description );

        return redirect()->back()
            ->with('successMessage', "Internal Request $invoice_vendor->code has been approved to be transfered");
    }


    public function approveInvoiceVendorMultiple(Request $request)
    {

        $force_transfer = $request->force_transfer;
        
        $invoice_vendor_multiple = $request->invoice_vendor_multiple;

        if($force_transfer == 'on'){
            //first, approve them
            foreach($invoice_vendor_multiple as $invoice_vendor){
                $iv = InvoiceVendor::findOrFail($invoice_vendor);
                if($iv->accounted_approval == 'pending'){
                    $iv->cash_id = $request->remitter_bank_id_multiple;
                    $iv->accounted_approval = 'approved';
                    $iv->save();
                    //register to the_logs table;
                    $log_description = "approved invoice vendor to be registered to transfer task";
                    $log = $this->register_to_the_logs('invoice_vendor', 'update', $invoice_vendor, $log_description );
                }
               
            }
            //now run force transfer
            $this->forceTransferInvoiceVendorMultiple($invoice_vendor_multiple);
            return redirect()->back()
            ->with('successMessage', "Invoice vendor(s) has been force transfered");
        }
        else{
            $count = count($invoice_vendor_multiple);
            foreach($invoice_vendor_multiple as $invoice_vendor){
                $iv = InvoiceVendor::findOrFail($invoice_vendor);
                if($iv->accounted_approval == 'pending'){
                    $iv->cash_id = $request->remitter_bank_id_multiple;
                    $iv->accounted_approval = 'approved';
                    $iv->save();
                    //register to the_logs table;
                    $log_description = "approved invoice vendor to be registered to transfer task";
                    $log = $this->register_to_the_logs('invoice_vendor', 'update', $invoice_vendor, $log_description );
                }
               
            }
            return redirect()->back()
            ->with('successMessage', "$count Invoice Vendor(s) has been approved to be transfered");
        }
       
        
        
    }


    protected function forceTransferInvoiceVendorMultiple($forced_invoice_vendors = array())
    {
        $invoice_vendor_multiple = $forced_invoice_vendors;
        
        $count = 0;
        foreach($invoice_vendor_multiple as $iv){
            $invoice_vendor = InvoiceVendor::findOrFail($iv);
            // transaction registration
            
            if($invoice_vendor->accounted_approval =='approved' && $invoice_vendor->cash_id!=NULL){
                /*echo $invoice_vendor->code;
                echo '</br>';*/
                $transaction_registration = $this->register_transaction_from_invoice_vendor($invoice_vendor);
                if($transaction_registration == TRUE){
                    $count++;
                    //Block register to tax lists
                    if($invoice_vendor->vat !=0){
                        $this->register_to_tax_list_from_vat($invoice_vendor);
                    }
                    if($invoice_vendor->wht_amount !=0){
                        $this->register_to_tax_list_from_wht($invoice_vendor);
                    }
                    //ENDBlock register to tax lists

                    //set status to paid and accounted status of invoice vendor to TRUE;
                    $invoice_vendor->status = 'paid';
                    $invoice_vendor->accounted = TRUE;
                    $invoice_vendor->save();

                    //register to the_logs table;
                    $log_description = "Transfered to vendor";
                    $log = $this->register_to_the_logs('invoice_vendor', 'update', $invoice_vendor, $log_description );

                    //Fire the event transver invoice vendor
                    Event::fire(new TransferInvoiceVendor($invoice_vendor));
                    
                   
                }
                
            }
            
        }
        
        
    }

    public function transferInvoiceVendor(Request $request)
    {
        $invoice_vendor = InvoiceVendor::findOrFail($request->invoice_vendor_id_to_transfer);
        
        // transaction registration
        $transaction_registration = $this->register_transaction_from_invoice_vendor($invoice_vendor);
        
        if($transaction_registration == TRUE){

            //Block register to tax lists
            if($invoice_vendor->vat !=0){
                $this->register_to_tax_list_from_vat($invoice_vendor);
            }
            if($invoice_vendor->wht_amount !=0){
                $this->register_to_tax_list_from_wht($invoice_vendor);
            }
            //ENDBlock register to tax lists

            //set status to paid and accounted status of invoice vendor to TRUE;
            $invoice_vendor->status = 'paid';
            $invoice_vendor->accounted = TRUE;
            $invoice_vendor->save();

            //register to the_logs table;
            $log_description = "Transfered to vendor";
            $log = $this->register_to_the_logs('invoice_vendor', 'update', $request->invoice_vendor_id_to_transfer, $log_description );

            //Fire the event transver invoice vendor
            Event::fire(new TransferInvoiceVendor($invoice_vendor));
            
            return redirect()->back()
                ->with('successMessage', "Invoice vendor has $invoice_vendor->code has been transfered");
        }
        return abort(500);
        
        
    }

    public function transferInvoiceVendorMultiple(Request $request)
    {
        $invoice_vendor_multiple = $request->invoice_vendor_multiple;
        $count = 0;
        foreach($invoice_vendor_multiple as $iv){
            $invoice_vendor = InvoiceVendor::findOrFail($iv);
            // transaction registration
            
            if($invoice_vendor->accounted_approval =='approved' && $invoice_vendor->cash_id!=NULL){
                /*echo $invoice_vendor->code;
                echo '</br>';*/
                $transaction_registration = $this->register_transaction_from_invoice_vendor($invoice_vendor);
                if($transaction_registration == TRUE){
                    $count++;
                    //Block register to tax lists
                    if($invoice_vendor->vat !=0){
                        $this->register_to_tax_list_from_vat($invoice_vendor);
                    }
                    if($invoice_vendor->wht_amount !=0){
                        $this->register_to_tax_list_from_wht($invoice_vendor);
                    }
                    //ENDBlock register to tax lists

                    //set status to paid and accounted status of invoice vendor to TRUE;
                    $invoice_vendor->status = 'paid';
                    $invoice_vendor->accounted = TRUE;
                    $invoice_vendor->save();

                    //register to the_logs table;
                    $log_description = "Transfered to vendor";
                    $log = $this->register_to_the_logs('invoice_vendor', 'update', $invoice_vendor, $log_description );

                    //Fire the event transver invoice vendor
                    Event::fire(new TransferInvoiceVendor($invoice_vendor));
                    
                   
                }
                
            }
            
        }
        return redirect()->back()
            ->with('successMessage', "$count Invoice vendor(s) has been transfered");
        
    }


    protected function register_to_tax_list_from_vat($invoice_vendor){
        $invoice_vendor_tax = new InvoiceVendorTax;
        $invoice_vendor_tax->tax_number = $invoice_vendor->tax_number;
        $invoice_vendor_tax->invoice_vendor_id = $invoice_vendor->id;
        $invoice_vendor_tax->source = 'vat';
        $invoice_vendor_tax->percentage = $invoice_vendor->vat;
        $invoice_vendor_tax->amount = $invoice_vendor->vat_amount;
        $invoice_vendor_tax->save();
    }

     protected function register_to_tax_list_from_wht($invoice_vendor){
        $invoice_vendor_tax = new InvoiceVendorTax;
        $invoice_vendor_tax->tax_number = $invoice_vendor->tax_number;
        $invoice_vendor_tax->invoice_vendor_id = $invoice_vendor->id;
        $invoice_vendor_tax->source = 'wht';
        $invoice_vendor_tax->amount = $invoice_vendor->wht_amount;
        $invoice_vendor_tax->save();
    }

    protected function register_transaction_from_invoice_vendor($invoice_vendor)
    {
        $cash = Cash::find($invoice_vendor->cash_id);

        $transaction = new Transaction;
        $transaction->cash_id = $invoice_vendor->cash_id;
        $transaction->refference = 'invoice_vendor';
        $transaction->refference_id = $invoice_vendor->id;
        $transaction->refference_number = $invoice_vendor->code;
        $transaction->type = 'debet';
        $transaction->amount = $invoice_vendor->amount;
        $transaction->notes = "";
        $transaction->transaction_date = date('Y-m-d');
        $transaction->reference_amount = $cash->amount - $invoice_vendor->amount;
        $transaction->save();

        //now fix the cash amount id,
        
        if($cash){
            $cash->amount = $cash->amount - $invoice_vendor->amount;
            $cash->save();
        }
        return TRUE;
    }


    //loging method
    protected function register_to_the_logs($source = NULL,  $mode = NULL, $refference_id = NULL, $description = NULL)
    {
        $the_log = new TheLog;
        $the_log->source = $source;
        $the_log->mode = $mode;
        $the_log->refference_id = $refference_id;
        $the_log->user_id = \Auth::user()->id;
        $the_log->description = $description;
        $the_log->save();
       
    }



    //return transfer task settlement lists page
    public function settlement()
    {
        return view('transfer-task.settlement');
    }


    public function approveSettlement(Request $request)
    {
        $settlement = Settlement::findOrFail($request->settlement_id_to_approve);
        
        //remittter_bank_id
        $settlement->remitter_bank_id = $request->remitter_bank_id;
        $settlement->accounted_approval = 'approved';
        $settlement->save();

        //register to the_logs table;
        $log_description = "approved to be registered to transfer task";
        $log = $this->register_to_the_logs('settlement', 'update', $request->settlement_id_to_approve, $log_description );

        return redirect()->back()
            ->with('successMessage', "Settlement $settlement->code has been approved to be transfered");
    }


    public function transferSettlement(Request $request)
    {
        $settlement = Settlement::findOrFail($request->settlement_id_to_transfer);
        // transaction registration
        $transaction_registration = $this->register_transaction_from_settlement($settlement);
        if($transaction_registration == TRUE){
            //set accounted status of settlement to TRUE;
            
            $settlement->accounted = TRUE;
            $settlement->save();

            //register to the_logs table;
            $log_description = "Transfered";
            $log = $this->register_to_the_logs('settlement', 'update', $request->settlement_id_to_transfer, $log_description );

            return redirect()->back()
                ->with('successMessage', "$settlement->code has been transfered");
        }
        return abort(500);
        
    }

    protected function register_transaction_from_settlement($settlement)
    {
        $cash = Cash::find($settlement->remitter_bank_id);

        $transaction = new Transaction;
        $transaction->cash_id = $settlement->remitter_bank_id;
        $transaction->refference = 'settlement';
        $transaction->refference_id = $settlement->id;
        $transaction->refference_number = $settlement->code;
        $transaction->notes = $settlement->description;
        $transaction->transaction_date = date('Y-m-d');
        $balance = $settlement->internal_request->amount - $settlement->amount;

        if($balance > 0){
            $transaction->type = 'credit';    
        }else{
            $transaction->type = 'debet';
        }
        
        //count balance to be transfered
        $transaction->amount = abs($balance);
        if($balance > 0){
            $transaction->reference_amount = $cash->amount + abs($balance);
        }else{
            $transaction->reference_amount = $cash->amount - abs($balance);
        }
        
        $transaction->save();

        //now fix the cash amount id,
        
        if($balance > 0){
            $cash->amount = $cash->amount + abs($balance);
            $cash->save();
        }
        else{
            $cash->amount = $cash->amount - abs($balance);
            $cash->save();
        }
        return TRUE;
    }


    //return transfer task cashbond lists page
    public function cashbond()
    {
        return view('transfer-task.cashbond');
    }


    public function approveCashbond(Request $request)
    {
        $cashbond = Cashbond::findOrFail($request->cashbond_id_to_approve);
        
        //remittter_bank_id
        $cashbond->remitter_bank_id = $request->remitter_bank_id;
        $cashbond->accounted_approval = 'approved';
        $cashbond->save();

        //register to the_logs table;
        $log_description = "approved to be registered to transfer task";
        $log = $this->register_to_the_logs('cashbond', 'update', $request->cashbond_id_to_approve, $log_description );

        return redirect()->back()
            ->with('successMessage', "cashbond $cashbond->code has been approved to be transfered");
    }

    public function transferCashbond(Request $request)
    {
        $cashbond = cashbond::findOrFail($request->cashbond_id_to_transfer);
        // transaction registration
        $transaction_registration = $this->register_transaction_from_cashbond($cashbond);
        if($transaction_registration == TRUE){
            //set accounted status of cashbond to TRUE;
            $cashbond->transaction_date =  date('Y-m-d');
            $cashbond->accounted = TRUE;
            $cashbond->save();

            //register to the_logs table;
            $log_description = "Transfered";
            $log = $this->register_to_the_logs('cashbond', 'update', $request->cashbond_id_to_transfer, $log_description );

            return redirect()->back()
                ->with('successMessage', "$cashbond->code has been transfered");
        }
        return abort(500);
        
    }


    protected function register_transaction_from_cashbond($cashbond)
    {
        $cash = Cash::find($cashbond->remitter_bank_id);

        $transaction = new Transaction;
        $transaction->cash_id = $cashbond->remitter_bank_id;
        $transaction->refference = 'cashbond';
        $transaction->refference_id = $cashbond->id;
        $transaction->refference_number = $cashbond->code;
        $transaction->notes = $cashbond->description;
        $transaction->transaction_date = $cashbond->transaction_date;
        $transaction->type = 'debet';
        $transaction->amount = abs($cashbond->amount);
        $transaction->reference_amount = $cash->amount - abs($cashbond->amount);
        $transaction->save();

        //now fix the cash amount id,
        
        if($cash){
            $cash->amount = $cash->amount - abs($cashbond->amount);
            $cash->save();
        }
        return TRUE;
    }


}
