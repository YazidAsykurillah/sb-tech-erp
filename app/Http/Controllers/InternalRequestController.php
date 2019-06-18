<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreInternalRequestRequest;
use App\Http\Requests\UpdateInternalRequestRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

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
        if($count_internal_request_id){
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


    //INTERNAL REQUEST datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles()->first()->code; 
        if( $user_role == 'SUP' || $user_role == 'ADM' || $user_role == 'FIN'){
            $internal_requests = InternalRequest::with('remitter_bank', 'beneficiary_bank', 'project', 'requester', 'vendor', 'settlement')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'internal_requests.*',
            ]);
        }
        else{
            $internal_requests = InternalRequest::where('requester_id','=',\Auth::user()->id)->with('remitter_bank', 'beneficiary_bank', 'project', 'requester', 'vendor', 'settlement')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'internal_requests.*',
            ]);
        }

        $data_internal_requests = Datatables::of($internal_requests)
            ->editColumn('code', function($internal_requests){
                $link  = '<a href="'.url('internal-request/'.$internal_requests->id).'">';
                $link .=    $internal_requests->code;
                $link .= '</a>';
                return $link;
            })
            ->addColumn('vendor', function($internal_requests){
                if($internal_requests->vendor){
                    return $internal_requests->vendor->name;
                }else{
                    return NULL;
                }
            })
            ->editColumn('remitter_bank', function($internal_requests){
                if($internal_requests->remitter_bank){
                    return $internal_requests->remitter_bank->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('beneficiary_bank', function($internal_requests){
                if($internal_requests->type != 'pindah_buku'){
                    if($internal_requests->beneficiary_bank){
                        return $internal_requests->beneficiary_bank->name;
                    }else{
                        return NULL;
                    }    
                }
                else{
                    if($internal_requests->bank_target){
                        return $internal_requests->bank_target->name;
                    }else{
                        return NULL;
                    }   
                }
                
            })
            ->editColumn('description', function($internal_requests){
                return substr($internal_requests->description, 0, 20)."...<p><i>[Click icon detail for more information</i></p>";
            })
            ->editColumn('amount', function($internal_requests){
                return number_format($internal_requests->amount);
            })
            ->editColumn('is_petty_cash', function($internal_requests){
                $is_petty_cash_disp = "";
                if($internal_requests->is_petty_cash == TRUE){
                    $is_petty_cash_disp = '<i class="fa fa-check"></i>';
                }else{
                    $is_petty_cash_disp = '<i class="fa fa-times"></i>';
                }
                return $is_petty_cash_disp;
            })
            ->editColumn('project', function($internal_requests){
                if($internal_requests->project){
                    return $internal_requests->project->code;
                }
                
            })
            ->editColumn('requester', function($internal_requests){
                return $internal_requests->requester->name;
            })
            ->editColumn('status', function($internal_requests){
                return ucwords($internal_requests->status);
            })
            ->editColumn('settled', function($internal_requests){
                $returned = '';
                if($internal_requests->settled == true){
                    $returned = "Ada";
                }else{
                    $returned = "Tidak Ada";
                }
                /*if($internal_requests->type == 'pindah_buku'){

                }else{
                    if($internal_requests->settlement){
                    $returned  = '<p>';
                    $returned .=    'Ada';
                    //$returned .=    '['.$internal_requests->settlement->result.']';
                    $returned .= '</p>';
                    }
                    else{
                        $returned = 'Tidak Ada';
                    }
                }*/
                
                return $returned;
            })
            ->addColumn('settlement_status', function($internal_requests){
                if($internal_requests->settlement){
                    return $internal_requests->settlement->status;
                }
                return NULL;
            })
            ->editColumn('accounted', function($internal_requests){
                return $internal_requests->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($internal_requests){
                    $actions_html ='<a href="'.url('internal-request/'.$internal_requests->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($internal_requests->status == 'pending' || $internal_requests->status == 'rejected'){
                        $actions_html .='<a href="'.url('internal-request/'.$internal_requests->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this internal-request">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';    
                    }
                    if($internal_requests->status != 'approved'){
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';
                    }
                    

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_internal_requests->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_internal_requests->make(true);
    }
    //END INTERNAL REQUEST datatables
}
