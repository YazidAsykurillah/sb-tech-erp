<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreAccountingExpenseRequest;
use App\Http\Requests\UpdateAccountingExpenseRequest;

use App\AccountingExpense;
class AccountingExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accounting-expense.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting-expense.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountingExpenseRequest $request)
    {
        $accountingExpense = new AccountingExpense;
        $accountingExpense->code = $request->code;
        $accountingExpense->name = $request->name;
        $accountingExpense->save();
        return redirect('master-data/accounting-expense');
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
        $accountingExpense = AccountingExpense::find($id);
        return view('accounting-expense.edit')
        	->with('accountingExpense', $accountingExpense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountingExpenseRequest $request, $id)
    {
        $accountingExpense = AccountingExpense::find($id);
        $accountingExpense->code = $request->code;
        $accountingExpense->name = $request->name;
        $accountingExpense->save();
        return redirect('master-data/accounting-expense')
        	->with('successMessage', "Accounting expense has been updated");
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
}
