<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreCashbondRequest;
use App\Http\Requests\UpdateCashbondRequest;
//use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Cashbond;
use App\User;
use App\TheLog;

class CashbondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cash-bond.index');
    }

    public function getPendingCashbond()
    {
        return view('cash-bond.pending');
    }

    public function getCheckedCashbond()
    {
        return view('cash-bond.checked');
    }
    
    public function getApprovedCashbond()
    {
        return view('cash-bond.approved');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_opts = User::lists('name', 'id');
        return view('cash-bond.create')
            ->with('user_opts', $user_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashbondRequest $request)
    {

        //Block build next cashbond code
        $count_cashbond = \DB::table('cashbonds')->count();
        if($count_cashbond > 0){
            $max = \DB::table('cashbonds')->max('code');
            $int_max = ltrim(preg_replace('#[^0-9]#', '', $max),'0');
            $next_cashbond_code = str_pad(($int_max+1), 5, 0, STR_PAD_LEFT);
        }
        else{
           $next_cashbond_code = str_pad(1, 5, 0, STR_PAD_LEFT);
        }
        //ENDBlock build next cashbond code

        $cashbond = new Cashbond;
        $cashbond->code = 'CB-'.$next_cashbond_code;
        $cashbond->user_id = $request->user_id;
        $cashbond->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $cashbond->description = $request->description;
        $cashbond->cut_from_salary = $request->cut_from_salary == 'on' ? TRUE : FALSE;
        $cashbond->term = abs($request->term);
        $cashbond->save();
        $last_id = $cashbond->id;

        //register to the_logs table;
        $log = $this->register_to_the_logs('cashbond', 'create', $last_id);

        return redirect('cash-bond/'.$last_id)
            ->with('successMessage', "Cashbond has been created");
    }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cashbond = Cashbond::findOrFail($id);
        $status_opts = ['pending'=>'Pending','checked'=>'Checked', 'approved'=>'Approved', 'rejected'=>'Rejected'];

        $the_logs = TheLog::where('source', '=', 'cashbond')
                    ->where('refference_id','=', $id)->get();

        return view('cash-bond.show')
            ->with('cashbond', $cashbond)
            ->with('the_logs', $the_logs)
            ->with('status_opts', $status_opts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cashbond = Cashbond::findOrFail($id);
        $user_opts = User::lists('name', 'id');
        return view('cash-bond.edit')
            ->with('cashbond', $cashbond)
            ->with('user_opts', $user_opts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCashbondRequest $request, $id)
    {
        $cashbond = Cashbond::findOrFail($id);
        $cashbond->user_id = $request->user_id;
        $cashbond->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $cashbond->description = $request->description;
        $cashbond->cut_from_salary = $request->cut_from_salary == 'on' ? TRUE : FALSE;
        $cashbond->term = abs($request->term);
        $cashbond->save();
        return redirect('cash-bond/'.$id)
            ->with('successMessage', "Cashbond $cashbond->code has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cashbond = Cashbond::findOrFail($request->cashbond_id);
        $cashbond->delete();

        //clear from the_logs table
        \DB::table('the_logs')->where('source', '=', 'cashbond')->where('refference_id', '=', $request->cashbond_id)->delete();

        return redirect('cash-bond')
            ->with('successMessage', "Cashbond $cashbond->code has been deleted");
    }


    public function changeStatus(Request $request)
    {
        $cashbond = Cashbond::findOrFail($request->cashbond_id);
         //get old cashbond status.
        $old_status = $cashbond->status;

        $cashbond->status = $request->status;
        $cashbond->save();

         //register to the_logs table;
        $log_description = "Change status from $old_status to $request->status";
        $log = $this->register_to_the_logs('cashbond', 'update', $request->cashbond_id, $log_description );

        return redirect('cash-bond/'.$request->cashbond_id)
            ->with('successMessage', "Cashbond $cashbond->code has been changed to $request->status");
    }

    public function cutFromSalary(Request $request)
    {
        $cashbond = Cashbond::findOrFail($request->cashbond_id_to_cut_from_salary);

        $cashbond->cut_from_salary = $request->cut_from_salary;
        $cashbond->save();

        $cut_from_salary_info = $request->cut_from_salary == TRUE ? 'Yes' : 'NO';
         //register to the_logs table;
        $log_description = "Change cut from salary to $cut_from_salary_info";
        $log = $this->register_to_the_logs('cashbond', 'update', $request->cashbond_id_to_cut_from_salary, $log_description );

        return redirect('cash-bond/'.$request->cashbond_id_to_cut_from_salary)
            ->with('successMessage', "Cashbond $cashbond->code has been changed to $cut_from_salary_info");
    }


    //Cashbond datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles()->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM' || $user_role == 'FIN'){
            $cashbonds = Cashbond::with('user')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashbonds.*',
            ]);
        }
        else{
             $cashbonds = Cashbond::with('user')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashbonds.*',
            ])->where('user_id', '=', \Auth::user()->id);
        }

        $data_cashbonds = Datatables::of($cashbonds)
            ->editColumn('code', function($cashbonds){
                $link = '<a href="'.url('cash-bond/'.$cashbonds->id).'" class="btn btn-link">';
                $link .= $cashbonds->code;
                $link .= '</a>';
                return $link;
            })
            ->editColumn('user', function($cashbonds){
                if($cashbonds->user){
                    return $cashbonds->user->name;    
                }else{
                    return "";
                }
                
            })
            ->editColumn('amount', function($cashbonds){
                return number_format($cashbonds->amount, 2);
            })
            ->editColumn('accounted', function($cashbonds){
                return $cashbonds->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->editColumn('cut_from_salary', function($cashbonds){
                return $cashbonds->cut_from_salary == TRUE ? 'Yes' : 'No';
            })
            ->editColumn('payment_status', function($cashbonds){
                return $cashbonds->payment_status == TRUE ? 'Lunas' : 'Belum Lunas';
            })
            ->editColumn('created_at', function($settlements){
                return jakarta_date_time($settlements->created_at);
            })
            ->addColumn('actions', function($cashbonds){
                    $actions_html ='<a href="'.url('cash-bond/'.$cashbonds->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('cash-bond/'.$cashbonds->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this cash-bond">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-cash-bond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_cashbonds->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_cashbonds->make(true);
    }
    //END Cashbond datatables


    public function setPaymentStatusPaid(Request $request)
    {
        $counter=0;
        if(count($request->id_to_set_paid)){
            foreach($request->id_to_set_paid as $id){
                try {
                    $cashbond = Cashbond::findOrFail($id);
                    if($cashbond->status == 'approved'){
                        $cashbond->payment_status = TRUE;
                        $cashbond->save();
                        $counter++;    
                    }else{
                        $cashbond->save();
                    }
                    
                } catch (Exception $e) {
                    print_r($e);
                    exit();
                }
                
            }
        }
        return redirect()->back()
            ->with('successMessage',$counter." cashbond has been set to paid");

    }
}
