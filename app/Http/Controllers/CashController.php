<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreCashRequest;
use App\Http\Requests\UpdateCashRequest;
use App\Http\Controllers\Controller;

use App\Cash;
use App\AccountingExpense;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cash.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type_opts = ['bank'=>'Bank', 'cash'=>'Cash'];
        return view('cash.create')
            ->with('type_opts', $type_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashRequest $request)
    {
        $cash = new Cash;
        $cash->type = $request->type;
        $cash->name = $request->name;
        $cash->account_number = $request->account_number;
        $cash->description = $request->description;
        $cash->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $cash->save();
        $last_id = $cash->id;
        return redirect('cash/'.$last_id)
            ->with('successMessage', "Cash $request->name has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cash = Cash::findOrFail($id);
        $year_opts = [];
        for ($i=2010; $i <= date('Y-m-d'); $i++) { 
            $year_opts[$i] = $i;
        }
        $month_opts = [
            "01"=>'January', 
            "02"=>'February', 
            "03"=>'March', 
            "04"=>'April', 
            "05"=>'May',
            "06"=>'June',
            "07"=>'July',
            "08"=>'August',
            "09"=>'September',
            "10"=>'October',
            "11"=>'November',
            "12"=>'December',
        ];
        
        $accountingExpenseOpts = AccountingExpense::lists('name', 'id');

        return view('cash.show')
            ->with('year_opts', $year_opts)
            ->with('month_opts',$month_opts)
            ->with('accountingExpenseOpts',$accountingExpenseOpts)
            ->with('cash', $cash);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cash = Cash::findOrFail($id);
        $type_opts = ['bank'=>'Bank', 'cash'=>'Cash'];
        return view('cash.edit')
            ->with('cash', $cash)
            ->with('type_opts', $type_opts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCashRequest $request, $id)
    {
        $cash = Cash::findOrFail($id);
        $cash->type = $request->type;
        $cash->name = $request->name;
        $cash->account_number = $request->account_number;
        $cash->description = $request->description;
        $cash->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $cash->enabled = $request->enabled;
        $cash->save();
        return redirect('cash/'.$id)
            ->with('successMessage', 'Cash has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cash = Cash::findOrFail($request->cash_id);
        $cash->delete();
        return redirect('cash')
            ->with('successMessage', "Deleted 1 cash");
    }
}
