<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\StoreCashbondSiteRequest;
use App\Http\Requests\UpdateCashbondSiteRequest;
//use App\Http\Controllers\Controller;

use App\CashbondSite;
use App\User;
use App\TheLog;
use Carbon\Carbon;
use App\Transaction;
use App\Cash;

class CashbondSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cash-bond-site.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cash-bond-site.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashbondSiteRequest $request)
    {
        //Block build next cashbond_site code
        $count_cashbond_site = \DB::table('cashbond_sites')->count();
        if($count_cashbond_site > 0){
            $max = \DB::table('cashbond_sites')->max('code');
            $int_max = ltrim(preg_replace('#[^0-9]#', '', $max),'0');
            $next_cashbond_site_code = str_pad(($int_max+1), 5, 0, STR_PAD_LEFT);
        }
        else{
           $next_cashbond_site_code = str_pad(1, 5, 0, STR_PAD_LEFT);
        }
        //ENDBlock build next cashbond_site code

        $cashbond_site = new CashbondSite;
        $cashbond_site->code = 'CBS-'.$next_cashbond_site_code;
        $cashbond_site->user_id = $request->user_id;
        $cashbond_site->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $cashbond_site->description = $request->description;
        $cashbond_site->accounted = TRUE;
        $cashbond_site->transaction_date = $request->transaction_date;
        $cashbond_site->cash_id = $request->cash_id;
        $cashbond_site->save();
        $last_id = $cashbond_site->id;

        //register to transsaction table
        $register_to_transaction = $this->register_to_transaction($last_id);
        

        return redirect('cash-bond-site/'.$last_id)
            ->with('successMessage', "Cashbond site has been created");
    }


    public function register_to_transaction($cashbond_site_id)
    {
        
        //find the cashbond site
        $cashbond_site = CashbondSite::findOrFail($cashbond_site_id);

        //find the cash
        $cash = Cash::findOrFail($cashbond_site->cash_id);

        $transaction = new Transaction;
        $transaction->cash_id = $cash->id;
        $transaction->refference = 'cashbond-site';
        $transaction->refference_id = $cashbond_site->id;
        $transaction->refference_number = $cashbond_site->code;
        $transaction->amount = abs($cashbond_site->amount);
        $transaction->type = 'debet';
        //set the reference amount from the cash amount
        $transaction->reference_amount = $cash->amount - $cashbond_site->amount;
        $transaction->notes = $cashbond_site->description;
        $transaction->transaction_date = $cashbond_site->transaction_date;
        $transaction->save();

        //last inserted transaction id
        $transaction_id = $transaction->id;
        //synchronize the cash
        $this->synchronize_cash_from_cashbond_site($cash, Transaction::findOrFail($transaction_id));
        
    }

    protected function synchronize_cash_from_cashbond_site($cash, $transaction)
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cashbond_site = CashbondSite::findOrFail($id);

        return view('cash-bond-site.show')
            ->with('cashbond_site', $cashbond_site);
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
    public function destroy(Request $request)
    {
        $CashbondSite = CashbondSite::findOrFail($request->cashbond_site_id);
        $CashbondSite->delete();
        return redirect()->back()
            ->with('successMessage', "one item has been deleted");
    }
}
