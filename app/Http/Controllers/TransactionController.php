<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\ExportTransactionRequest;

use Carbon\Carbon;
use App\Transaction;
use App\Cash;
use App\InternalRequest;
use App\Settlement;
use App\Cashbond;
use App\InvoiceCustomer;
use App\InvoiceVendor;
use App\BankAdministration;
use App\InvoiceCustomerTax;
use App\CashbondSite;
use App\AccountingExpense;
use App\CashbondInstallment;
use App\Period;

//User Maatwebsite Excel package
use Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "You are calling transaction controller index";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cash = Cash::findOrFail($request->cash_id);
        $refference_opts = [
            'internal_request'=>'Internal Request', 'settlement'=>'Settlement', 'cashbond'=>'Cash Bond',
            'invoice_customer'=>'Invoice Customer', 'invoice_vendor'=>'Invoice Vendor', 
            'bank_administration'=>'Bank Administration', 'manual'=>'Manual Transaction', 
            'site_internal_request'=>'Site Internal Request', 
            //'site_settlement'=>'Site Settlement'
        ];
        $internal_request_opts = InternalRequest::lists('code', 'id');
        $settlement_opts = Settlement::lists('code', 'id');
        $cashbond_opts = Cashbond::lists('code', 'id');
        $invoice_customer_opts = InvoiceCustomer::lists('code', 'id');
        $invoice_vendor_opts = InvoiceVendor::lists('code', 'id');
        $bank_administration_opts = BankAdministration::lists('code', 'id');
        $accountingExpenseOpts = AccountingExpense::lists('name', 'id');
        return view('transaction.create')
            ->with('cash', $cash)
            ->with('refference_opts', $refference_opts)
            ->with('internal_request_opts', $internal_request_opts)
            ->with('settlement_opts', $settlement_opts)
            ->with('cashbond_opts', $cashbond_opts)
            ->with('invoice_customer_opts', $invoice_customer_opts)
            ->with('invoice_vendor_opts', $invoice_vendor_opts)
            ->with('bank_administration_opts', $bank_administration_opts)
            ->with('accountingExpenseOpts', $accountingExpenseOpts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function register_cashbond_installment($obj)
    {
        $cashbond = $obj;

        $current_year = date('Y');
        $current_month = date('m');
        $period = Period::where('end_date', 'LIKE', "%$current_year-$current_month%")->get()->first();
        
        $first_installment_schedule = $period->end_date;
        $next_installment_schedule_arr = [ $first_installment_schedule ];

        $amount_per_installment = $cashbond->amount / $cashbond->term;

        if($cashbond->term > 1){
            
            for($i = 1;$i<$cashbond->term;$i++){
                $next_installment_schedule =  Carbon::parse($first_installment_schedule)->addMonth($i)->format('Y-m-d');
                $next_installment_schedule_arr[] = $next_installment_schedule;
            }
            
        }

        if(count($next_installment_schedule_arr)){
            //clear all the instalment related to cashbond id at first
            \DB::table('cashbond_installments')->where('cashbond_id', '=', $cashbond->id)->delete();
            foreach($next_installment_schedule_arr as $nisa){
                $cashbond_installment = new CashbondInstallment;
                $cashbond_installment->cashbond_id = $cashbond->id;
                $cashbond_installment->amount = $amount_per_installment;
                $cashbond_installment->installment_schedule = $nisa;
                $cashbond_installment->save();
            }
        }

    }

    public function store(StoreTransactionRequest $request)
    {
        $cash = Cash::findOrFail($request->cash_id);

    
        //block transaction saving handling
        $transaction = new Transaction;
        $transaction->cash_id = $request->cash_id;
        $transaction->refference = $request->refference;
        
        if($request->refference == 'internal_request'){
            $transaction->refference_id = $request->internal_request_id;
            $transaction->refference_number = InternalRequest::findOrFail($request->internal_request_id)->code;
        }
        if($request->refference == 'settlement'){
            $transaction->refference_id = $request->settlement_id;
            $transaction->refference_number = Settlement::findOrFail($request->settlement_id)->code;
        }
        if($request->refference == 'cashbond'){
            $cashbond = Cashbond::find($request->cashbond_id);
            $this->register_cashbond_installment($cashbond);
            
            $transaction->refference_id = $request->cashbond_id;
            $transaction->refference_number = Cashbond::findOrFail($request->cashbond_id)->code;
        }
        if($request->refference == 'invoice_customer'){
            $transaction->refference_id = $request->invoice_customer_id;
            $transaction->refference_number = InvoiceCustomer::findOrFail($request->invoice_customer_id)->code;
        }
        if($request->refference == 'invoice_vendor'){
            $transaction->refference_id = $request->invoice_vendor_id;
            $transaction->refference_number = InvoiceVendor::findOrFail($request->invoice_vendor_id)->code;
        }
        if($request->refference == 'bank_administration'){
            $transaction->refference_id = $request->bank_administration_id;
            $transaction->refference_number = BankAdministration::findOrFail($request->bank_administration_id)->code;
        }
        if($request->refference == 'site_internal_request'){
            $transaction->refference_number = 'SIR-'.time();
        }

        $transaction->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $transaction->notes = $request->notes;
        $transaction->type = $request->type;
        $transaction->accounting_expense_id = $request->accounting_expense_id;
        //set the reference amount from the cash amount
        $transaction->reference_amount = $request->type == 'debet' ? ($cash->amount - $transaction->amount) : ($cash->amount + $transaction->amount);
        $transaction->transaction_date = $request->transaction_date;
        $transaction->save();

        //ENDblock transaction saving handling

        //get latest transaction id
        $transaction_id = $transaction->id;

        // Synchronize the cash amount and update the accounted status for each accounted model based on refference request
       
        //incase refference is internal request
        if($request->refference == 'internal_request'){
            $this->synchronize_cash_from_internal_request($cash, InternalRequest::findOrFail($request->internal_request_id));
        }
        //incase refference is settlement
        if($request->refference == 'settlement'){
            $this->synchronize_cash_from_settlement($cash, Settlement::findOrFail($request->settlement_id));
        }
        //incase refference is cashbond
        if($request->refference == 'cashbond'){
            $this->synchronize_cash_from_cashbond($cash, Cashbond::findOrFail($request->cashbond_id));
        }
        //incase refference is invoice_customer
        if($request->refference == 'invoice_customer'){
            $this->synchronize_cash_from_invoice_customer($cash, InvoiceCustomer::findOrFail($request->invoice_customer_id));
        }
        //incase refference is invoice_vendor
        if($request->refference == 'invoice_vendor'){
            $this->synchronize_cash_from_invoice_vendor($cash, InvoiceVendor::findOrFail($request->invoice_vendor_id));
        }

        //incase refference is bank_administration
        if($request->refference == 'bank_administration'){
            $this->synchronize_cash_from_bank_administration($cash, BankAdministration::findOrFail($request->bank_administration_id), $request->type);
        }

        //incase refference is manual
        if($request->refference == 'manual'){
            $this->synchronize_cash_from_manual($cash, Transaction::findOrFail($transaction_id), $request->type);
        }

        //incase refference is site_internal_request
        if($request->refference == 'site_internal_request'){
            $this->synchronize_cash_from_site_internal_request($cash, Transaction::findOrFail($transaction_id), $request->type);
        }


        
        //all job done, now return to the cash page
        return redirect('cash/'.$request->cash_id)
            ->with('successMessage', "Transaction has been created");

    }

    protected function synchronize_cash_from_site_internal_request($cash, $transaction, $type)
    {

        $current_cash_amount = $cash->amount;
        $transaction_amount = $transaction->amount;

        //now update the cash_amount
        if($type == 'debet'){
            $cash->amount = $current_cash_amount - $transaction_amount;
        }else{
            $cash->amount = $current_cash_amount + $transaction_amount;
        }
        $cash->save();

    }

    protected function synchronize_cash_from_manual($cash, $transaction, $type)
    {

        $current_cash_amount = $cash->amount;
        $transaction_amount = $transaction->amount;

        //now update the cash_amount
        if($type == 'debet'){
            $cash->amount = $current_cash_amount - $transaction_amount;
        }else{
            $cash->amount = $current_cash_amount + $transaction_amount;
        }
        $cash->save();

    }

    protected function synchronize_cash_from_bank_administration($cash, $bank_administration, $type)
    {
        $current_cash_amount = $cash->amount;

        //update bank administration's accounted to TRUE
        $bank_administration->accounted = true;
        $bank_administration->save();
        //find bank_administration amount
        $bank_administration_amount = $bank_administration->amount;
        
        //now update the cash_amount
        if($type == 'debet'){
            $cash->amount = $current_cash_amount - $bank_administration_amount;
        }else{
            $cash->amount = $current_cash_amount + $bank_administration_amount;
        }
        
        $cash->save();
    }

    protected function synchronize_cash_from_invoice_vendor($cash, $invoice_vendor)
    {
        $current_cash_amount = $cash->amount;

        //update invoice vendor's status to PAID  accounted to TRUE
        $invoice_vendor->accounted = true;
        $invoice_vendor->status = 'paid';
        $invoice_vendor->save();
        //find invoice_vendor amount
        $invoice_vendor_amount = $invoice_vendor->amount;
        
        //now update the cash_amount
        $cash->amount = $current_cash_amount - $invoice_vendor_amount;
        $cash->save();
    }

    protected function synchronize_cash_from_invoice_customer($cash, $invoice_customer)
    {
        $current_cash_amount = $cash->amount;

        //update cashbond accounted status to true
        $invoice_customer->accounted = true;
        $invoice_customer->save();
        //find invoice_customer amount
        $invoice_customer_amount = $invoice_customer->amount;
        
        //now update the cash_amount
        $cash->amount = $current_cash_amount + $invoice_customer_amount;
        $cash->save();
    }

    protected function synchronize_cash_from_internal_request($cash, $internal_request)
    {
        
        //update internal_request accounted status to true and set the transaction_date
        $internal_request->accounted = true;
        $internal_request->transaction_date = date('Y-m-d');
        $internal_request->save();
        //find internal_request amount
        $ir_amount = $internal_request->amount;
        
        //now update the cash_amount
        $current_cash_amount = $cash->amount;
        $cash->amount = $current_cash_amount - $ir_amount;
        $cash->save();
    }


    protected function synchronize_cash_from_settlement($cash, $settlement)
    {
        //first find current cash amount;
        $current_cash_amount = $cash->amount;

        //update settlement accounted to true
        $settlement->accounted = true;
        $settlement->save();

        //find settlement amount
        $settlement_amount = $settlement->amount;
        //find internal request amount of this settlement
        $ir_amount = $settlement->internal_request->amount;
        
        $difference = $ir_amount - $settlement_amount;
        
        
        if($difference == 0){ //there is no difference between settlement and IR, do nothing to current cash amount

        }
        else if($difference < 0){ //settlement amount is GREATER than ir amount ( $difference is negative)
            $amount_to_spend = abs($difference);
            //subtract current cash amount based on amount to be SPENT
            $cash->amount = $current_cash_amount - $amount_to_spend;
            $cash->save();
        }
        else if( $difference > 0){ //settlement amount is LOWER than ir amount ( $difference is positive)
            $amount_to_add = abs($difference);
            //add current cash amount based on amount to be ADDED
            $cash->amount = $current_cash_amount + $amount_to_add;
            $cash->save();
        }
        
    }

    protected function synchronize_cash_from_cashbond($cash, $cashbond)
    {
        $current_cash_amount = $cash->amount;
        //update cashbond accounted status to true and set the transaction_date
        $cashbond->accounted = true;
        $cashbond->transaction_date = date('Y-m-d');
        $cashbond->save();
        //find cashbond amount
        $cashbond_amount = $cashbond->amount;
        
        //now update the cash_amount
        
        $cash->amount = $current_cash_amount - $cashbond_amount;
        $cash->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function selectInternalRequest(Request $request)
    {
        $remitter_bank_id = $request->remitter_bank_id;
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("internal_requests")
                ->select("id","code", "amount")
                ->where('remitter_bank_id', $remitter_bank_id)
                ->where('accounted', '=', TRUE)
                ->where('accounted_approval', '=', TRUE)
                ->where('status', '=', 'approved')
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("internal_requests")
                    ->select("id","code", "amount")
                    ->where('remitter_bank_id', $remitter_bank_id)
                    ->where('accounted', '=', TRUE)
                    ->where('accounted_approval', '=', TRUE)
                    ->where('status', '=', 'approved')
                    ->get();
        }
        
        return response()->json($data);
    }

    public function selectSettlement(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("settlements")
                ->select("id","code")
                ->where('accounted', '=', false)
                ->where('status', '=', 'approved')
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("settlements")
                    ->select("id","code")
                    ->where('accounted', '=', false)
                    ->where('status', '=', 'approved')
                    ->get();
            
        }
        
        return response()->json($data);
    }

    public function selectCashbond(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("cashbonds")
                ->select("id","code")
                ->where('accounted', '=', false)
                ->where('status', '=', 'approved')
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("cashbonds")
                    ->select("id","code")
                    ->where('accounted', '=', false)
                    ->where('status', '=', 'approved')
                    ->get();
            
        }
        
        return response()->json($data);
    }


    public function selectInvoiceCustomer(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("invoice_customers")
                ->select("id","code")
                ->where('accounted', '=', false)
                ->where('status', '=', 'paid')
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("invoice_customers")
                    ->select("id","code")
                    ->where('accounted', '=', false)
                    ->where('status', '=', 'paid')
                    ->get();
            
        }
        
        return response()->json($data);
    }


    public function selectInvoiceVendor(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("invoice_vendors")
                ->select("id","code")
                ->where('accounted', '=', false)
                ->where('status', '=', 'pending')
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("invoice_vendors")
                    ->select("id","code")
                    ->where('accounted', '=', false)
                    ->where('status', '=', 'pending')
                    ->get();
            
        }
        
        return response()->json($data);
    }

    public function selectBankAdministration(Request $request)
    {
        $cash_id = $request->cash_id;
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("bank_administrations")
                ->select("id","code")
                ->where('cash_id', $cash_id)
                ->where('accounted', '=', false)
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("bank_administrations")
                    ->select("id","code")
                    ->where('cash_id', $cash_id)
                    ->where('accounted', '=', false)
                    ->get();
            
        }
        
        return response()->json($data);
    }

    public function getInternalRequestData(Request $request)
    {
        $internal_request = InternalRequest::findOrFail($request->internal_request_id);
        return json_encode($internal_request);
    }

    public function getSettlementData(Request $request)
    {
        $settlement = Settlement::findOrFail($request->settlement_id);
        $settlement_amount = $settlement->amount;
        $settlement_array = $settlement->toArray();
        //get internal request amount of this settlement
        $ir_amount = $settlement->internal_request->amount;
        //get the difference amount of the settlement from it's internal request
        $difference = $ir_amount - $settlement_amount;
        $settlement_array['difference'] = $difference;

        if($difference == 0){  // there is no difference, it will be assumend as debet
            $settlement_array['transaction_type'] = 'debet';
        }else if ($difference < 0 ){ // the settlement is GREATER than it's IR amount
            $settlement_array['transaction_type'] = 'debet';
        }
        else if( $difference > 0){ //the settlement is LOWER than it's IR amount
            $settlement_array['transaction_type'] = 'credit';
        }
        else{  //this is undefined condition
             $settlement_array['transaction_type'] = 'debet';
        }
        return json_encode($settlement_array);
    }

    public function getCashbondData(Request $request)
    {
        $cashbond = Cashbond::findOrFail($request->cashbond_id);
        return json_encode($cashbond);
    }

    public function getInvoiceCustomerData(Request $request)
    {
        $invoice_customer = InvoiceCustomer::findOrFail($request->invoice_customer_id);
        return json_encode($invoice_customer);
    }

    public function getInvoiceVendorData(Request $request)
    {
        $invoice_vendor = InvoiceVendor::findOrFail($request->invoice_vendor_id);
        return json_encode($invoice_vendor);
    }

    public function getBankAdministrationData(Request $request)
    {
        $bank_administration = BankAdministration::findOrFail($request->bank_administration_id);
        return json_encode($bank_administration);
    }



    public function deleteTransaction(Request $request){
        $transaction = Transaction::findOrFail($request->transaction_id);
        //get the refference
        $refference = $transaction->refference;
        //rollback properties of the related model to this transaction
        if($refference == 'internal_request'){
            $this->rollback_related_models_from_internal_request($transaction);
        }
        elseif($refference == 'settlement'){
            $this->rollback_related_models_from_settlement($transaction);
        }
        elseif($refference == 'cashbond'){
            $this->rollback_related_models_from_cashbond($transaction);
        }
        elseif($refference == 'invoice_customer'){
            $this->rollback_related_models_from_invoice_customer($transaction);
        }
        elseif($refference == 'invoice_vendor'){
            $this->rollback_related_models_from_invoice_vendor($transaction);
        }
        elseif($refference == 'bank_administration'){
            $this->rollback_related_models_from_bank_administration($transaction);
        }
        elseif($refference == 'invoice_vendor_tax'){
            $this->rollback_related_models_from_invoice_vendor_tax($transaction);
        }
        elseif($refference == 'invoice_customer_tax'){
            $this->rollback_related_models_from_invoice_customer_tax($transaction);
        }
        elseif ($refference == 'manual') {
            $this->rollback_related_models_from_manual($transaction);
        }
        elseif ($refference == 'site_internal_request') {
            $this->rollback_related_models_from_site_internal_request($transaction);
        }
        elseif ($refference == 'site_settlement') {
            $this->rollback_related_models_from_site_settlement($transaction);
        }
        elseif ($refference == 'cashbond-site') {
            $this->rollback_related_models_from_cashbond_site($transaction);
        }
        else{
            echo $refference;
            exit();
        }
        //delete this transaction from the list
        $transaction->delete();
        return redirect()->back()
            ->with('successMessage', "Deleted $transaction->refference_number from transaction list");
    }


    protected function rollback_related_models_from_cashbond_site($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
        //delete the CashbondSite object
            $cashbond_site = CashbondSite::find($transaction->refference_id);
            $cashbond_site->delete();
    }

    protected function rollback_related_models_from_site_settlement($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
    }

    protected function rollback_related_models_from_site_internal_request($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
    }

    protected function rollback_related_models_from_manual($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
    }

    protected function rollback_related_models_from_invoice_customer_tax($transaction){
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
           //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
            //rollback invoice customer tax model state
            $invoice_customer_tax = InvoiceCustomerTax::find($transaction->refference_id);
            if($invoice_customer_tax){
                $invoice_customer_tax->approval = 'pending';
                $invoice_customer_tax->save();
            }
    }


    protected function rollback_related_models_from_invoice_vendor_tax($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
    }
    

    protected function rollback_related_models_from_bank_administration($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
    }

    
    protected function rollback_related_models_from_invoice_vendor($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
        //rolback invoice_vendor model status and accounted
            $invoice_vendor = InvoiceVendor::find($transaction->refference_id);
            $invoice_vendor->status = 'pending';
            $invoice_vendor->accounted = FALSE;
            $invoice_vendor->accounted_approval = 'pending';
            $invoice_vendor->save();
    }


    protected function rollback_related_models_from_invoice_customer($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }

        //rollback invoice customer model, change status back to pending, change accounted status back to false
        $invoice_customer = InvoiceCustomer::findOrFail($transaction->refference_id);
        $invoice_customer->status = 'pending';
        $invoice_customer->accounted = false;
        $invoice_customer->save();
    }

    protected function rollback_related_models_from_cashbond($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
        //rollback cashbond model state
            $cashbond = Cashbond::find($transaction->refference_id);
            if($cashbond){
                $cashbond->accounted = FALSE;
                $cashbond->accounted_approval = 'pending';
                $cashbond->save();
            }
    }

    protected function rollback_related_models_from_settlement($transaction)
    {
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
        //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
        //rollback settlement model state
            $settlement = Settlement::find($transaction->refference_id);
            if($settlement){
                $settlement->accounted = FALSE;
                $settlement->accounted_approval = 'pending';
                $settlement->save();
            }
    }


    protected function rollback_related_models_from_internal_request($transaction){
        //get transaction properties
        $tr_cash_id = $transaction->cash_id;
        $tr_type = $transaction->type;
        $tr_amount = $transaction->amount;
           //rollback cash model state
            $cash = Cash::findOrFail($transaction->cash_id);
            if($tr_type == 'debet'){
                $cash->amount = $cash->amount+$tr_amount;
                $cash->save();
            }else{
                $cash->amount = $cash->amount-$tr_amount;
                $cash->save();
            }
            //rollback internal request model state
            $internal_request = InternalRequest::find($transaction->refference_id);
            if($internal_request){
                $internal_request->accounted = FALSE;
                $internal_request->accounted_approval = 'pending';
                $internal_request->save();
            }
    }



    public function exportExcel(ExportTransactionRequest $request)
    {
        
        $cash = Cash::findOrFail($request->cash_id);
        //$data = Transaction::select('cash_id','refference','refference_id','refference_number','type', 'amount', 'notes')->where('cash_id',$cash->id)->get();
        $data = Transaction::select('cash_id','refference','refference_id','refference_number','type', 'amount', 'notes', 'transaction_date')->where('cash_id',$cash->id)->get();
        return Excel::create('transaction_report_'.$cash->name.'', function($excel) use ($data) {
            $excel->sheet('Sheet-01', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }


    public function importExcel(Request $request)
    {
        /*print_r($request->cash_id);
        exit();*/
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    //get the cash model
                    $cash = Cash::findOrFail($value->cash_id);
                    $current_cash_amount = $cash->amount;

                    $insert[] = [
                                    'cash_id' => $value->cash_id,
                                    'refference' => $value->refference,
                                    'refference_id' => $value->refference_id,
                                    'refference_number' => $value->refference_number,
                                    'type' => $value->type,
                                    'amount' => $value->amount,
                                    'created_at'=> date('Y-m-d H:i:s'),
                                    'notes' => $value->notes,
                                    //'reference_amount'=> $saldo,
                                    'transaction_date'=>Carbon::parse($value->transaction_date)->format('Y-m-d'),
                                    'reference_amount'=> $value->type == 'debet' ? ($current_cash_amount - $value->amount) : ($current_cash_amount+$value->amount),
                                ];

                    $transaction_amount = $value->amount;
                    //now update the cash_amount
                    if($value->type == 'debet'){
                        $cash->amount = $current_cash_amount - abs($transaction_amount);
                    }else{
                        $cash->amount = $current_cash_amount + abs($transaction_amount);
                    }
                    $cash->save();
                }

                if(!empty($insert)){
                    \DB::table('transactions')->insert($insert);
                    //dd('Insert Record successfully.');
                }
            }
            return back()
            ->with('successMessage', "Data has been imported");
        }
        else{
            return redirect()->back()
            ->with('errorMessage', "No file to be imported");
        }
        
    }


    public function updateTransactionDate(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id_to_update);
        $transaction->transaction_date = Carbon::parse($request->transaction_date)->format('Y-m-d');
        $transaction->save();
        return redirect()->back()
            ->with('successMessage', "Transaction date has been changed to $request->transaction_date");
    }


    public function storeSiteSettlement(Request $request)
    {
        
        

        //find the site internal request
        $site_ir = Transaction::findOrFail($request->transaction_id_to_settled);
        $site_ir_reference = $site_ir->refference_number;
        $site_ir_amount = $site_ir->amount;

        //find the cash
        $cash = Cash::findOrFail($site_ir->cash_id);

        //compose the transaction parameter to be inserted
        $site_settlement_amount = floatval(preg_replace('#[^0-9.]#', '', $request->site_settlement_amount));
        $transaction_amount = abs($site_ir_amount - $site_settlement_amount);
        if($site_settlement_amount > $site_ir_amount || $site_settlement_amount == $site_ir_amount){
            $transaction_type = 'debet';
            $transaction_refference_amount = $cash->amount - $transaction_amount;
        }else{
            $transaction_type = 'credit';
            $transaction_refference_amount = $cash->amount + $transaction_amount;
        }
        
        // echo $transaction_refference_amount;
        // exit();
        

        //now save the transaction from this site settlement
        $transaction = new Transaction;
        $transaction->cash_id = $cash->id;
        $transaction->refference = 'site_settlement';
        $transaction->refference_id = $site_ir->id;
        $transaction->refference_number = 'SSET-'.$site_ir_reference;
        $transaction->amount = $transaction_amount;
        $transaction->type = $transaction_type;
        //set the reference amount from the cash amount
        $transaction->reference_amount = $transaction_refference_amount;
        $transaction->notes = $request->site_settlement_notes;
        $transaction->transaction_date = Carbon::parse($request->transaction_date_site_settlement)->format('Y-m-d');
        $transaction->save();

        //last inserted transaction id
        $transaction_id = $transaction->id;
        //synchronize the cash
        $this->synchronize_cash_from_site_settlement($cash, Transaction::findOrFail($transaction_id));

        //all job done, now return to the cash page
        return redirect('cash/'.$cash->id)
            ->with('successMessage', "Transaction has been created");

    }

    protected function synchronize_cash_from_site_settlement($cash, $transaction)
    {

        $current_cash_amount = $cash->amount;
        $transaction_amount = $transaction->amount;
        $transaction_type = $transaction->type;

        //now update the cash_amount
        if($transaction_type == 'debet'){
            $cash->amount = $current_cash_amount - $transaction_amount;
        }else{
            $cash->amount = $current_cash_amount + $transaction_amount;
        }
        $cash->save();
    }
    
    public function registerAccountingExpense(Request $request){
        $transaction = Transaction::findOrFail($request->transaction_id_to_register_accounting_expense);
        $transaction->accounting_expense_id = $request->accounting_expense_id;
        $transaction->save();
        return redirect()->back()
        ->with('successMessage', "Transaction updated");
    }
}
