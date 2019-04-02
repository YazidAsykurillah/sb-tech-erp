<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreBankAccountRequest;
use App\Http\Requests\UpdateBankAccountRequest;

use App\BankAccount;
use App\User;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bankaccount.index');
        /*if(\Auth::user()->can('index-bank-account')){
            return view('bankaccount.index');    
        }
        return abort(403);*/
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_role = \Auth::user()->roles->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM'){
            $user_opts = User::lists('name', 'id');
            return view('bankaccount.create_for_admin')
                ->with('user_opts', $user_opts);
        }
        else{
            return view('bankaccount.create');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankAccountRequest $request)
    {
        $data = [
            'user_id'=>$request->user_id,
            'name'=>$request->name,
            'account_number'=>$request->account_number,
           
        ];
        $save = BankAccount::create($data);
        return redirect('bank-account')
            ->with('successMessage', "Bank has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank_account = BankAccount::findOrFail($id);
        return view('bankaccount.show')
            ->with('bank_account', $bank_account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank_account = BankAccount::findOrFail($id);
        $user_role = \Auth::user()->roles->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM'){
            $user_opts = User::lists('name', 'id');
            return view('bankaccount.edit_for_admin')
                ->with('bank_account', $bank_account)
                ->with('user_opts', $user_opts);
        }else{
            return view('bankaccount.edit')
                ->with('bank_account', $bank_account);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankAccountRequest $request, $id)
    {
        $bank_account = BankAccount::findOrFail($id);
        $bank_account->user_id = $request->user_id;
        $bank_account->name = $request->name;
        $bank_account->account_number = $request->account_number;
        $bank_account->save();
        return redirect('bank-account/'.$id)
            ->with('successMessage', "Bank Account has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->bank_account_id;
        $bank_account = BankAccount::findOrFail($id);
        $bank_account->delete();
        return redirect('bank-account')
            ->with('successMessage', "Bank account has been deleted");

    }
}
