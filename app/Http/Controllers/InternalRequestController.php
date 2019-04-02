<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreInternalRequestRequest;
use App\Http\Requests\UpdateInternalRequestRequest;


use App\InternalRequest;
use App\BankAccount;
use App\Project;
use App\User;
use App\Cash;
use App\TheLog;
use App\Vendor;

class InternalRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('internal-request.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_role = \Auth::user()->roles->first();
        
        $checker = \DB::table('lock_configurations')->select('user_id')
                ->where('facility_name', '=', 'create_internal_request')
                ->where('user_id','=', \Auth::user()->id)
                ->get();
        $internal_request_lock_state = count($checker);
        /*echo $internal_request_lock_state;
        exit();*/
        
        $remitter_bank_opts = Cash::lists('name', 'id');
        $beneficiary_bank_opts = BankAccount::lists('name', 'id');
        $requester_opts = User::lists('name', 'id');
        $project_opts = Project::lists('code', 'id');
        if($user_role->code == 'FIN'){
            $type_opts = ['operational'=>'Operational', 'pindah_buku'=>'Pindah Buku'];       
        }
        else if($user_role->code == 'ADM'){
            $type_opts = ['operational'=>'Operational', 'material'=>'Material', 'pindah_buku'=>'Pindah Buku'];
            if($internal_request_lock_state != 0){       //apply condition based on locked internal request, if the user is locked, only show the material selection
                unset($type_opts['operational']);
            }
        }
        else if($user_role->code == 'SUP'){
            $type_opts = ['operational'=>'Operational', 'pindah_buku'=>'Pindah Buku', 'material'=>'Material'];       
        }
        else{
            $type_opts = ['operational'=>'Operational', 'material'=>'Material'];
            if($internal_request_lock_state != 0){       //apply condition based on locked internal request, if the user is locked, only show the material selection
                unset($type_opts['operational']);
            }
        }
        

        return view('internal-request.create')
            ->with('remitter_bank_opts', $remitter_bank_opts)
            ->with('beneficiary_bank_opts', $beneficiary_bank_opts)
            ->with('requester_opts', $requester_opts)
            ->with('project_opts', $project_opts)
            ->with('internal_request_lock_state', $internal_request_lock_state)
            ->with('type_opts', $type_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInternalRequestRequest $request)
    {
        //Block build next internal_request code
        $count_internal_request_id = \DB::table('internal_requests')->count();
        if(count($count_internal_request_id)){
            $max = \DB::table('internal_requests')->max('code');
            $int_max = ltrim(preg_replace('#[^0-9]#', '', $max),'0');
            $next_internal_request_code = str_pad(($int_max+1), 5, 0, STR_PAD_LEFT);
        }
        else{
           $next_internal_request_code = str_pad(1, 5, 0, STR_PAD_LEFT);
        }
        //ENDBlock build next internal_request code
        $internal_request = new InternalRequest;
        $internal_request->code = 'IR-'.$next_internal_request_code;
        $internal_request->description = $request->description; 
        $internal_request->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $internal_request->is_petty_cash = $request->is_petty_cash == 'on' ? TRUE : FALSE;
        
        $internal_request->project_id = $request->project_id;
        $internal_request->type = $request->type;
        $internal_request->vendor_id = $request->vendor_id;
        //$internal_request->requester_id = \Auth::user()->id;
        $internal_request->requester_id = $request->requester_id;
        $internal_request->save();
        $last_id = $internal_request->id;

        //internal request has been saved, now, lock the requester to create next internal request for temporary if the internal request type is OPERATIONAL only
        if($request->type == 'operational'){
            $lock = \DB::table('lock_configurations')->insert(['facility_name'=>'create_internal_request', 'user_id'=>$request->requester_id]);
        }
        

        //register to the_logs table;
        $log = $this->register_to_the_logs('internal_request', 'create', $last_id);
        return redirect('internal-request/'.$last_id)
            ->with('successMessage', 'Internal Request has been created');
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
        $internal_request = InternalRequest::findOrFail($id);
        $status_opts = ['pending'=>'Pending','checked'=>'Checked', 'approved'=>'Approved', 'rejected'=>'Rejected'];
        $the_logs = TheLog::where('source', '=', 'internal_request')
                    ->where('refference_id','=', $id)->get();
        return view('internal-request.show')
            ->with('status_opts', $status_opts)
            ->with('internal_request', $internal_request)
            ->with('the_logs', $the_logs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_role = \Auth::user()->roles->first();
        $internal_request = InternalRequest::findOrFail($id);
        $remitter_bank_opts = Cash::lists('name', 'id');
        $beneficiary_bank_opts = BankAccount::lists('name', 'id');
        $requester_opts = User::lists('name', 'id');
        $project_opts = Project::lists('code', 'id');
        $type_opts = ['operational'=>'Operational', 'material'=>'Material'];
        if($user_role->code == 'FIN' || $user_role->code == 'SUP'){
            $type_opts = ['operational'=>'Operational', 'pindah_buku'=>'Pindah Buku', 'material'=>'Material'];       
        }
        return view('internal-request.edit')
            ->with('internal_request', $internal_request)
            ->with('remitter_bank_opts', $remitter_bank_opts)
            ->with('beneficiary_bank_opts', $beneficiary_bank_opts)
            ->with('requester_opts', $requester_opts)
            ->with('type_opts', $type_opts)
            ->with('project_opts', $project_opts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInternalRequestRequest $request, $id)
    {
        $internal_request = InternalRequest::findOrFail($id);
        $internal_request->description = $request->description;
        $internal_request->is_petty_cash = $request->is_petty_cash == 'on' ? TRUE : FALSE;
        $internal_request->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $internal_request->vendor_id = $request->vendor_id;
        $internal_request->requester_id = $request->requester_id;
        $internal_request->type = $request->type;
        $internal_request->project_id = $request->project_id;
        $internal_request->save();
        return redirect('internal-request/'.$id)
            ->with('successMessage', "Internal Request $internal_request->code has been updated");
    }

    public function destroy(Request $request)
    {
        $internal_request = InternalRequest::findOrFail($request->internal_request_id);
        $internal_request->delete();

        //clear from the_logs table
        \DB::table('the_logs')->where('source', '=', 'internal_request')->where('refference_id', '=', $request->internal_request_id)->delete();
        return redirect('internal-request')
            ->with('successMessage', "Internal Request $internal_request->code has been deleted");

    }


    public function approveMultiple(Request $request)
    {
        $approved = 0;
        $internal_request_multiple = $request->internal_request_multiple;
        foreach($internal_request_multiple as $internal_request){
            $ir = InternalRequest::findOrFail($internal_request);
            if($ir->status=='pending'){
                $ir->status ='approved';
                $ir->save();
                //register to the_logs table;
                $log_description = "Change status from pending to approved";
                $log = $this->register_to_the_logs('internal_request', 'update', $ir->id, $log_description );

                $approved++;
            }
        }
        return redirect()->back()
            ->with('successMessage', "$approved Internal request(s) has been approved");
    }

    public function changeInternalRequestStatus(Request $request)
    {
        $id = $request->internal_request_id;
        $internal_request = InternalRequest::findOrFail($id);
        //get old internal request status.
        $old_status = $internal_request->status;

        $internal_request->status = $request->status;
        $internal_request->save();

        //register to the_logs table;
        $log_description = "Change status from $old_status to $request->status";
        $log = $this->register_to_the_logs('internal_request', 'update', $id, $log_description );

        return redirect()->back()
            ->with('successMessage', "Internal request status has been changed to $request->status");
    }


    public function getPendingIR()
    {
        return view('internal-request.pending');
    }

    public function getCheckedIR()
    {
        return view('internal-request.checked');
    }

    public function getApprovedIR()
    {
        return view('internal-request.approved');
    }

}
