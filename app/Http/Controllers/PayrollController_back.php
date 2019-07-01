<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePayrollRequest;

use Carbon\Carbon;
use Yajra\Datatables\Datatables;

use Event;
use App\Events\PayrollIsDeleted;
use App\Events\PayrollIsCreated;

use App\Payroll;
use App\User;
use App\Ets;
use App\Period;
use App\Allowance;
use App\AllowanceItem;
use App\MedicalAllowance;
use App\CompetencyAllowance;
use App\Cashbond;
use App\CashbondInstallment;
use App\Settlement;
use App\InternalRequest;
use App\ExtraPayrollPayment;
use App\IncentiveWeekDay;
use App\IncentiveWeekEnd;
use App\BpjsKesehatan;
use App\BpjsKetenagakerjaan;

class PayrollController_back extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payroll.index');
    }

    //Payroll datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $payrolls = Payroll::with(['period', 'user'])->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'payrolls.*',
        ]);
        if($request->get('filter_period')){
            $period_id = $request->get('filter_period');
            $payrolls->where('period_id','=',$period_id);
        }
        if($request->get('filter_user_type')){
            $user_type = $request->get('filter_user_type');
            $payrolls->whereHas('user', function($q) use ($user_type){
                $q->where('users.type','=',$user_type);
            });
        }
        
        $data_payrolls = Datatables::of($payrolls)
            ->editColumn('period_id', function($payrolls){
                return $payrolls ? $payrolls->period->code : NULL;
            })
            ->editColumn('user_id', function($payrolls){
                return $payrolls->user ? $payrolls->user->name : NULL;
            })
            ->editColumn('thp_amount', function($payrolls){
                return number_format($payrolls->thp_amount, 2);
            })
            ->addColumn('actions', function($payrolls){
                    $actions_html ='<a href="'.url('payroll/'.$payrolls->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-payroll" data-id="'.$payrolls->id.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        
        if ($keyword = $request->get('search')['value']){
            $data_payrolls->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_payrolls->make(true);
    }
    //END Payroll datatables

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $period_opts = Period::orderBy('start_date', 'DESC')->lists('code', 'id');
        return view('payroll.create')
            ->with('period_opts', $period_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayrollRequest $request)
    {
        $payroll = new Payroll;
        $payroll->user_id = $request->user_id;
        $payroll->period_id = $request->period_id;
        $payroll->save();
        //Fire the event payroll is created
        Event::fire(new PayrollIsCreated($payroll));
        return redirect('payroll/'.$payroll->id)
            ->with('successMessage', "Payroll has been created, now you can calculate the salary");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    

    public function show($id)
    {
        $payroll = Payroll::findOrFail($id);
        $period = $payroll->period;
        $user = $payroll->user;

        //initiate needed variables
        $man_hour_total=0;
        $basic_salary = $user->salary;

        $ets_lists = Ets::where('user_id','=', $user->id)->where('period_id', $period->id)->get();
        
        $normal_count = Ets::where('user_id','=', $user->id)->where('period_id', $period->id)->sum('normal');
        $normal_total = $normal_count*1;

        $I_count = Ets::where('user_id','=', $user->id)->where('period_id', $period->id)->sum('I');
        $I_total = $I_count*1.5;

        $II_count = Ets::where('user_id','=', $user->id)->where('period_id', $period->id)->sum('II');
        $II_total = $II_count*2;

        $III_count = Ets::where('user_id','=', $user->id)->where('period_id', $period->id)->sum('III');
        $III_total = $III_count*3;

        $IV_count = Ets::where('user_id','=', $user->id)->where('period_id', $period->id)->sum('IV');
        $IV_total = $IV_count*4;

        //incentives builder
        //WeekDay
        $weekday_ets = Ets::where('user_id','=', $user->id)
                                    ->where('period_id', $period->id)
                                    ->where('has_incentive_week_day','=',TRUE)
                                    ->get()->count();
        $total_amount_incentive_weekday = $weekday_ets*$user->incentive_week_day;
        if($payroll->incentive_weekday){
            $incentive_weekday = IncentiveWeekDay::where('payroll_id','=',$id)->update(
                ['multiplier'=>$weekday_ets,'total_amount'=>$total_amount_incentive_weekday]
            );
            $incentive_weekday = $payroll->incentive_weekday;
            
        }else{
            $incentive_weekday = new IncentiveWeekDay;
            $incentive_weekday->payroll_id = $id;
            $incentive_weekday->amount = $user->incentive_week_day;
            $incentive_weekday->multiplier = $weekday_ets;
            $incentive_weekday->total_amount = $total_amount_incentive_weekday;
            $incentive_weekday->save();
            
        }
        //WeekEnd
        $weekend_ets = Ets::where('user_id','=', $user->id)
                                    ->where('period_id', $period->id)
                                    ->where('has_incentive_week_end','=',TRUE)
                                    ->get()->count();
        $total_amount_incentive_weekend = $weekend_ets*$user->incentive_week_end;
        if($payroll->incentive_weekend){
            $incentive_weekend = IncentiveWeekEnd::where('payroll_id','=',$id)->update(
                ['multiplier'=>$weekend_ets,'total_amount'=>$total_amount_incentive_weekend]
            );
            $incentive_weekend = $payroll->incentive_weekend;
            
        }else{
            $incentive_weekend = new IncentiveWeekEnd;
            $incentive_weekend->payroll_id = $id;
            $incentive_weekend->amount = $user->incentive_week_end;
            $incentive_weekend->multiplier = $weekend_ets;
            $incentive_weekend->total_amount = $total_amount_incentive_weekend;
            $incentive_weekend->save();
            
        }

        if($user->type =='office'){
            $man_hour_total = $I_total+$II_total+$III_total+$IV_total;
        }
        elseif($user->type =='outsource' && $basic_salary >0){
            $man_hour_total = $I_total+$II_total+$III_total+$IV_total;
        }
        else{
            $man_hour_total = $normal_total+$I_total+$II_total+$III_total+$IV_total;    
        }
        

        $total_man_hour_salary = $user->man_hour_rate * $man_hour_total;

        //check allowance
        $check_allowances = $this->check_allowances($user, $period);

        $allowances = Allowance::where('user_id', $user->id)
                        ->where('period_id', $period->id)
                        ->get();
        /*dd($allowances);
        exit();*/
        //check medical allowance
        $check_medical_allowance = $this->check_medical_allowance($user, $period);
        $medical_allowance = MedicalAllowance::where('user_id', $user->id)
                        ->where('period_id', $period->id)
                        ->get();


        
        //get user's cashbonds
        $cashbonds = Cashbond::select('id')->where('user_id', '=', $user->id)->get();
        $cashbond_ids = [];
        $cash_advances = [];
        if(count($cashbonds)){
            $cashbond_ids = array_flatten($cashbonds->toArray());
        }
        if(count($cashbond_ids)){
            $cash_advances =  CashbondInstallment::whereIn('cashbond_id',$cashbond_ids)
                            ->whereBetween('installment_schedule', [$period->start_date, $period->end_date])
                            ->where('cashbond_installments.status', '=', 'unpaid')
                            ->get();
        }
        
        //get user's settlements
        $end_period_date = Carbon::parse($period->end_date)->addDay(3);
        $settlements = Settlement::with('internal_request')
            ->where('status','=','approved')
            ->where('accounted', FALSE)
            ->whereBetween('transaction_date', [$period->start_date, $end_period_date->format('Y-m-d')])
            ->whereHas('internal_request', function($query) use($user, $period){
                $query->where('requester_id', '=', $user->id);
                //$query->whereBetween('transaction_date', [$period->start_date, $period->end_date]);
            })->get();



        //get or create competency allowance
        if($payroll->competency_allowance){
            $competency_allowance = $payroll->competency_allowance;
        }else{
            $competency_allowance = new CompetencyAllowance;
            $competency_allowance->payroll_id = $id;
            $competency_allowance->amount = $user->competency_allowance;
            $competency_allowance->save();
        }

        //Get Adder extra payroll payment
        $extra_payroll_payments_adder = ExtraPayrollPayment::where('payroll_id','=',$id)
                                        ->where('type','=', 'adder')
                                        ->get();
        //Get Substractor extra payroll payment
        $extra_payroll_payments_substractor = ExtraPayrollPayment::where('payroll_id','=',$id)
                                        ->where('type','=', 'substractor')
                                        ->get();
        //Bpjs Kesehatan
        //get or create
        if($payroll->bpjs_kesehatan){
            $bpjs_kesehatan = $payroll->bpjs_kesehatan;
        }else{
            $newBpjsKesehatan = new BpjsKesehatan;
            $newBpjsKesehatan->payroll_id = $id;
            $newBpjsKesehatan->amount = $user->bpjs_ke;
            $newBpjsKesehatan->save();
            $bpjs_kesehatan = BpjsKesehatan::find($newBpjsKesehatan);

        }

        //Bpjs Ketenagakerjaan
        //get or create
        if($payroll->bpjs_ketenagakerjaan){
            $bpjs_ketenagakerjaan = $payroll->bpjs_ketenagakerjaan;
        }else{
            $newBpjsKetenagakerjaan = new BpjsKetenagakerjaan;
            $newBpjsKetenagakerjaan->payroll_id = $id;
            $newBpjsKetenagakerjaan->amount = $user->bpjs_ke;
            $newBpjsKetenagakerjaan->save();
            $bpjs_ketenagakerjaan = BpjsKetenagakerjaan::find($newBpjsKetenagakerjaan);

        }

        //if user type is site show payroll page for site
        //otherwise show payroll page for office
        if($user->type == 'outsource'){
            return view('payroll.show')
            ->with('ets_lists', $ets_lists)
            ->with('normal_count', $normal_count)
            ->with('normal_total', $normal_total)
            
            ->with('I_count', $I_count)
            ->with('I_total', $I_total)

            ->with('II_count', $II_count)
            ->with('II_total', $II_total)

            ->with('III_count', $III_count)
            ->with('III_total', $III_total)

            ->with('IV_count', $IV_count)
            ->with('IV_total', $IV_total)

            ->with('man_hour_total', $man_hour_total)

            ->with('basic_salary', $basic_salary)
            
            ->with('total_man_hour_salary', $total_man_hour_salary)

            ->with('allowances', $allowances)

            ->with('medical_allowance', $medical_allowance)

            ->with('cash_advances', $cash_advances)
            ->with('settlements', $settlements)
            ->with('user', $user)
            ->with('competency_allowance', $competency_allowance)
            ->with('extra_payroll_payments_adder', $extra_payroll_payments_adder)
            ->with('extra_payroll_payments_substractor', $extra_payroll_payments_substractor)
            ->with('bpjs_kesehatan', $bpjs_kesehatan)
            ->with('bpjs_ketenagakerjaan', $bpjs_ketenagakerjaan)
            ->with('payroll', $payroll);    
        }else{
            return view('payroll.show_for_office')
            ->with('ets_lists', $ets_lists)
            ->with('normal_count', $normal_count)
            ->with('normal_total', $normal_total)
            ->with('I_count', $I_count)
            ->with('I_total', $I_total)

            ->with('II_count', $II_count)
            ->with('II_total', $II_total)

            ->with('III_count', $III_count)
            ->with('III_total', $III_total)

            ->with('IV_count', $IV_count)
            ->with('IV_total', $IV_total)

            ->with('man_hour_total', $man_hour_total)

            ->with('basic_salary', $basic_salary)
            
            ->with('total_man_hour_salary', $total_man_hour_salary)

            ->with('allowances', $allowances)

            ->with('medical_allowance', $medical_allowance)

            ->with('cash_advances', $cash_advances)
            ->with('settlements', $settlements)
            ->with('user', $user)
            ->with('competency_allowance', $competency_allowance)
            ->with('extra_payroll_payments_adder', $extra_payroll_payments_adder)
            ->with('extra_payroll_payments_substractor', $extra_payroll_payments_substractor)
            ->with('incentive_weekday', $incentive_weekday)
            ->with('incentive_weekend', $incentive_weekend)
            ->with('bpjs_kesehatan', $bpjs_kesehatan)
            ->with('bpjs_ketenagakerjaan', $bpjs_ketenagakerjaan)
            ->with('payroll', $payroll);
        }

        

    }


    protected function check_medical_allowance($user, $period){
        $medical_allowance = MedicalAllowance::where('user_id', $user->id)
                        ->where('period_id', $period->id)
                        ->get();

        if(count($medical_allowance) == 0){
            $this->register_medical_allowance($user, $period);
        }
    }

    protected function register_medical_allowance($user, $period)
    {
        \DB::table('medical_allowances')->where('user_id', '=', $user->id)->where('period_id', '=', $period->id)->delete();
        $totalAmountMedAllowance = 0;
        $multiplier = \DB::table('ets')
                            ->where('period_id',$period->id)
                            ->where('user_id',$user->id)
                            ->count('id');
        if($multiplier >=14){
            $totalAmountMedAllowance = $user->medical_allowance;
        }else{
            $totalAmountMedAllowance = $user->medical_allowance/2;
        }
        
        $medical_allowance = [
            'user_id'=>$user->id,
            'period_id'=>$period->id,
            'amount'=>$user->medical_allowance,
            'multiplier'=>$multiplier,
            'total_amount'=>$totalAmountMedAllowance
        ];
        \DB::table('medical_allowances')->insert($medical_allowance);
    }


    protected function check_allowances($user, $period){
        
        
        $allowances = Allowance::where('user_id', $user->id)
                        ->where('period_id', $period->id)
                        ->get();

        if(count($allowances) == 0){
            $this->register_allowance($user, $period);
        }


    }

    protected function register_allowance($user, $period){
        $allowance_names = [
            'local', 'non-local'
        ];
        
        if($user && $period){
            foreach($allowance_names as $name){
                $allowance = new Allowance;
                $allowance->period_id = $period->id;
                $allowance->user_id = $user->id;
                $allowance->name = $name;
                $allowance->save();
                $allowance_id = $allowance->id;
                //build allowance items
                $this->register_allowance_items($allowance_id, $user, $name);
            }
        }
        return TRUE;
    }


    //Back 2019-05-30
    /*protected function register_allowance_items($allowance_id, $user){
        \DB::table('allowance_items')->where('allowance_id', $allowance_id)->delete();

        $data = [
            ['allowance_id'=>$allowance_id, 'type'=>'transportation', 'amount'=>$user->transportation_allowance, 'multiplier'=>0, 'total_amount'=>0],
            ['allowance_id'=>$allowance_id, 'type'=>'meal', 'amount'=>$user->eat_allowance, 'multiplier'=>0, 'total_amount'=>0]
        ];

        return \DB::table('allowance_items')->insert($data);

    }*/

    protected function register_allowance_items($allowance_id, $user, $name){
        \DB::table('allowance_items')->where('allowance_id', $allowance_id)->delete();

        //get allowance object
        $allowance = Allowance::findOrFail($allowance_id);
        $period_id = $allowance->period_id;
        

        $transportation_allowance = $user->transportation_allowance;
        $eat_allowance = $user->eat_allowance;
        
        $localMultiplier = \DB::table('ets')
                            ->where('period_id',$period_id)
                            ->where('user_id',$user->id)
                            ->where('location','site-local')
                            ->count('id');
       
        $nonLocalMultiplier = \DB::table('ets')
                            ->where('period_id',$period_id)
                            ->where('user_id',$user->id)
                            ->where('location','site-non-local')
                            ->count('id');


        if($name == 'local'){
            $data = [
                ['allowance_id'=>$allowance_id, 'type'=>'transportation', 'amount'=>$transportation_allowance, 'multiplier'=>$localMultiplier, 'total_amount'=>$transportation_allowance*$localMultiplier],
                ['allowance_id'=>$allowance_id, 'type'=>'meal', 'amount'=>$eat_allowance, 'multiplier'=>$localMultiplier, 'total_amount'=>$eat_allowance*$localMultiplier]
            ];

            \DB::table('allowance_items')->insert($data);
        }elseif ($name == 'non-local') {
            $data = [
                ['allowance_id'=>$allowance_id, 'type'=>'transportation', 'amount'=>$transportation_allowance, 'multiplier'=>$nonLocalMultiplier, 'total_amount'=>$transportation_allowance*$nonLocalMultiplier],
                ['allowance_id'=>$allowance_id, 'type'=>'meal', 'amount'=>$eat_allowance, 'multiplier'=>$nonLocalMultiplier, 'total_amount'=>$eat_allowance*$nonLocalMultiplier]
            ];

            \DB::table('allowance_items')->insert($data);
        }
        

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
        return $id;
    }


    public function deletePayroll(Request $request)
    {
        $payroll = Payroll::findOrFail($request->payroll_id_to_delete);
        $period_id = $payroll->period->id;
        $user_id = $payroll->user->id;


        //Delete payroll model
        $payroll->delete();
        //Fire the event payroll is deleted
        Event::fire(new PayrollIsDeleted($payroll));
        
        return redirect()->back()
            ->with('successMessage', "Payroll has been deleted");
    }

    public function update_thp_amount(Request $request)
    {
        $thp_amount = 0;
        $total_salary = 0;

        $payroll = Payroll::findOrFail($request->payroll_id);
        $user = User::findOrFail($payroll->user->id);
        $period = Period::findOrFail($payroll->period->id);

        //get basic salary 
        $basic_salary = $user->salary;
        $total_man_hour_salary = $request->total_man_hour_salary;


        // Define total salary
        //if user type is outsource and has basic salary,
        // total salary is achived only by the total manhour salary
        $total_salary = $basic_salary+$total_man_hour_salary;
        
        //collect allowances
        $total_amount_from_allowances = 0;
        $allowances = Allowance::where('user_id','=',$user->id)
                                ->where('period_id', '=',$period->id)
                                ->get();
        if(count($allowances)){
            $allowance_ids = [];
            foreach($allowances as $allowance){
                $allowance_ids[] = $allowance->id;
            }
            $total_amount_from_allowances = AllowanceItem::whereIn('allowance_id', $allowance_ids)->sum('total_amount');
        }

        //collect total_amount from medical allowance
        $total_amount_from_medical_allowance = 0;
        $medical_allowance = MedicalAllowance::where('user_id', '=',$user->id)->where('period_id', '=', $period->id)->get();
        if(count($medical_allowance)){
            $total_amount_from_medical_allowance = $medical_allowance->first()->total_amount;
        }


        //collect_total_amount from CashbondInstallments
        $total_amount_from_cashbond_installments = 0;
        $cashbonds = Cashbond::select('id')->where('user_id', '=', $user->id)->get();
        $cashbond_ids = [];
        if(count($cashbonds)){
            $cashbond_ids = array_flatten($cashbonds->toArray());
        }
        if(count($cashbond_ids)){
            $total_amount_from_cashbond_installments =  CashbondInstallment::whereIn('cashbond_id',$cashbond_ids)
                            ->whereBetween('installment_schedule', [$period->start_date, $period->end_date])
                            ->where('cashbond_installments.status', '=', 'unpaid')
                            ->sum('amount');
        }


        //Collect balance from settlement
        $end_period_date = Carbon::parse($period->end_date)->addDay(3);
        $settlement_balance = 0;
        $settlements = Settlement::with('internal_request')
            ->where('status','=','approved')
            ->where('accounted', FALSE)
            ->whereBetween('transaction_date', [$period->start_date, $end_period_date->format('Y-m-d')])
            ->whereHas('internal_request', function($query) use($user, $period){
                $query->where('requester_id', '=', $user->id);
                //$query->whereBetween('transaction_date', [$period->start_date, $period->end_date]);
            })->get();

        if($settlements->count()){
            foreach($settlements as $settlement){
                $balance = $settlement->internal_request->amount - $settlement->amount;
                $settlement_balance+=$balance;
            }
        }

        //Collect workshop allowance amount
        $workshop_allowance_amount = 0;
        if($payroll->workshop_allowance){
            $workshop_allowance_amount = $payroll->workshop_allowance->total_amount;
        }
        
        //Collect Competency Allowance
        $competency_allowance = $payroll->competency_allowance ? $payroll->competency_allowance->amount :0;

        //Collect extra payroll payment adder amount
        $epp_adder = ExtraPayrollPayment::where('payroll_id','=',$payroll->id)
                            ->where('type','=','adder')
                            ->sum('amount');
        //Collect extra payroll payment substractor amount
        $epp_substractor = ExtraPayrollPayment::where('payroll_id','=',$payroll->id)
                            ->where('type','=','substractor')
                            ->sum('amount');
        //build extra payroll payment substractor
        $epp_balance = $epp_adder - $epp_substractor;

        //Collect incentive weekday
        $incentive_weekday_amount = $payroll->incentive_weekday ? $payroll->incentive_weekday->total_amount :0;
        //Collect incentive weekend
        $incentive_weekend_amount = $payroll->incentive_weekend ? $payroll->incentive_weekend->total_amount :0;
        $total_from_incentive =$incentive_weekday_amount+$incentive_weekend_amount;

        //Collect Bpjs Kesehatan
        $bpjs_kesehatan = $payroll->bpjs_kesehatan ? $payroll->bpjs_kesehatan->amount : 0;
        //Collect Bpjs Ketenagakerjaan
        $bpjs_ketenagakerjaan = $payroll->bpjs_ketenagakerjaan ? $payroll->bpjs_ketenagakerjaan->amount : 0;

        //count total cut from BPJS
        $cut_amount_from_bpjs = $bpjs_kesehatan+$bpjs_ketenagakerjaan;

        $thp_amount = $total_salary+$total_amount_from_allowances+$total_amount_from_medical_allowance+$workshop_allowance_amount - $total_amount_from_cashbond_installments+$competency_allowance+$epp_balance+$total_from_incentive-$cut_amount_from_bpjs;
        //update thp amount of this payroll
        if($settlement_balance < 0){
            $thp_amount = $thp_amount+(abs($settlement_balance));
        }else{
            $thp_amount = $thp_amount-$settlement_balance;
        }
        $payroll->thp_amount = $thp_amount;
        $payroll->save();

        return response()->json(
            ['thp_amount'=>number_format($thp_amount,2)]
        );

    }


    public function setStatusCheck(Request $request)
    {
        if($request->has('id_to_check')){
            //multiple approval
            if(is_array($request->id_to_check)){
                $counter = 0;
                foreach($request->id_to_check as $id){
                    $payroll = Payroll::findOrFail($id);
                    $payroll->status = 'checked';
                    $payroll->save();
                    $counter++;
                }
                return redirect()->back()
                    ->with('successMessage', "$counter has been checked");
            }
            //single approval
            else{

            }
        }else{
            return redirect()->back()
                ->with('errorMessage', "There are no selected purchase request");
        }
    }

    public function setStatusApprove(Request $request)
    {
        if($request->has('id_to_approve')){
            //multiple approval
            if(is_array($request->id_to_approve)){
                $counter = 0;
                foreach($request->id_to_approve as $id){
                    $payroll = Payroll::findOrFail($id);
                    $payroll->status = 'approved';
                    $payroll->save();
                    $counter++;
                }
                return redirect()->back()
                    ->with('successMessage', "$counter has been approved");
            }
            //single approval
            else{

            }
        }else{
            return redirect()->back()
                ->with('errorMessage', "There are no selected purchase request");
        }
    }

    public function changeStatus(Request $request)
    {
        //dd($request->all());
        $payroll = Payroll::findOrFail($request->payroll_id_to_change);
        $payroll->status = $request->new_payroll_status;
        $payroll->save();
        return redirect()->back();
    }

}
