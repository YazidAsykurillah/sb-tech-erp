<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreBankAdministrationRequest;
use App\Http\Requests\UpdateBankAdministrationRequest;
use App\Http\Controllers\Controller;

use App\BankAdministration;
use App\Cash;

class BankAdministrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bank-administration.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cash_opts = Cash::where('type', '=', 'bank')->lists('name', 'id');
        return view('bank-administration.create')
            ->with('cash_opts', $cash_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankAdministrationRequest $request)
    {
        //Block build next bank_administration code
        $count_bank_administration_id = \DB::table('bank_administrations')->count();
        if($count_bank_administration_id > 0){
            $max = \DB::table('bank_administrations')->max('code');
            $int_max = ltrim(preg_replace('#[^0-9]#', '', $max),'0');
            $next_bank_administration_code = str_pad(($int_max+1), 5, 0, STR_PAD_LEFT);
        }
        else{
           $next_bank_administration_code = str_pad(1, 5, 0, STR_PAD_LEFT);
        }
        //ENDBlock build next bank_administration code
        $bank_administration = new BankAdministration;
        $bank_administration->code = "BAD-".$next_bank_administration_code;
        $bank_administration->cash_id = $request->cash_id;
        $bank_administration->refference_number = $request->refference_number;
        $bank_administration->description = $request->description;
        $bank_administration->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $bank_administration->save();
        $last_id = $bank_administration->id;
        return redirect('bank-administration')
            ->with('successMessage', "Bank Administration has been created");

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
        $bank_administration = BankAdministration::findOrFail($id);
        return view('bank-administration.edit')
            ->with('bank_administration', $bank_administration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankAdministrationRequest $request, $id)
    {
        $bank_administration = BankAdministration::findOrFail($id);
        $bank_administration->cash_id = $request->cash_id;
        $bank_administration->refference_number = $request->refference_number;
        $bank_administration->description = $request->description;
        $bank_administration->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $bank_administration->save();
        return redirect('bank-administration')
            ->with('successMessage', "Bank Administration has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $bank_administration = BankAdministration::findOrFail($request->bank_administration_id);
        $bank_administration->delete();
        return redirect('bank-administration')
            ->with('successMessage', 'Deleted 1 bank administration');
    }
}
