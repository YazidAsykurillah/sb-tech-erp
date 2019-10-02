<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreSettlementRequest;
use App\Http\Requests\UpdateSettlementRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Settlement;
use App\InternalRequest;
use App\Category;
use App\SubCategory;
use App\TheLog;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settlement.index');
    }


    public function getPendingSettlement()
    {
        return view('settlement.pending');
    }

    public function getCheckedSettlement()
    {
        return view('settlement.checked');
    }

    public function getApprovedSettlement()
    {
        return view('settlement.approved');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $internal_request = InternalRequest::findOrFail($request->internal_request_id);
        $category_opts = Category::lists('name', 'id');
        $sub_category_opts = SubCategory::lists('name', 'id');
        $result_opts = ['clear'=>'Clear', 'additional'=>'Additional'];
        return view('settlement.create')
            ->with('category_opts', $category_opts)
            ->with('sub_category_opts', $sub_category_opts)
            ->with('result_opts', $result_opts)
            ->with('internal_request', $internal_request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettlementRequest $request)
    {
        //first get the internal request model.
        $internal_request = InternalRequest::findOrFail($request->internal_request_id);

        $settlement = new Settlement;
        $settlement->code = 'SET-'.$internal_request->code;
        $settlement->internal_request_id = $request->internal_request_id;
        $settlement->transaction_date = $request->transaction_date;
        $settlement->description = $request->description;
        $settlement->category_id = $request->category_id;
        $settlement->sub_category_id = $request->sub_category_id;
        $settlement->amount =floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $settlement->last_updater_id = \Auth::user()->id;
        $settlement->result = $request->result;
        $settlement->save();
        $last_id = $settlement->id;

        //update the internal request settled to TRUE
        $internal_request->settled = true;
        $internal_request->save();

        /*
        //remove the user_id from lock configurations table create_internal_request facility name
        $this->unlock_create_internal_request($internal_request->requester_id);
        */
        
        //register to the_logs table;
        $log = $this->register_to_the_logs('settlement', 'create', $last_id);

        return redirect('settlement/'.$last_id)
            ->with('successMessage', "Settlement has been registered");
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

    public function unlock_create_internal_request($requester_id)
    {
        $check = \DB::table('lock_configurations')
                ->select('id')
                ->where('user_id', '=', $requester_id)
                ->where('facility_name','=', 'create_internal_request')
                ->get();
        if(count($check)){
            $unlock = \DB::table('lock_configurations')
                    ->where('id','=', $check[0]->id)->delete();
            return($unlock);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $settlement = Settlement::findOrFail($id);
        $status_opts = ['pending'=>'Pending', 'checked'=>'Checked', 'approved'=>'Approved', 'rejected'=>'Rejected'];

        $the_logs = TheLog::where('source', '=', 'settlement')
                    ->where('refference_id','=', $id)->get();
        return view('settlement.show')
            ->with('status_opts', $status_opts)
            ->with('the_logs', $the_logs)
            ->with('settlement', $settlement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settlement = Settlement::findOrFail($id);
        $category_opts = Category::lists('name', 'id');
        $sub_category_opts = SubCategory::lists('name', 'id');
        $result_opts = ['clear'=>'Clear', 'additional'=>'Additional'];
        return view('settlement.edit')
            ->with('settlement', $settlement)
            ->with('category_opts', $category_opts)
            ->with('sub_category_opts', $sub_category_opts)
            ->with('result_opts', $result_opts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettlementRequest $request, $id)
    {
        $settlement = Settlement::findOrFail($id);
        $settlement->internal_request_id = $request->internal_request_id;
        $settlement->transaction_date = $request->transaction_date;
        $settlement->description = $request->description;
        $settlement->category_id = $request->category_id;
        $settlement->sub_category_id = $request->sub_category_id;
        $settlement->amount =floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $settlement->last_updater_id = \Auth::user()->id;
        $settlement->result = $request->result;
        $settlement->save();
        return redirect('settlement/'.$id)
            ->with('successMessage', "Settlement $settlement->code has been updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $settlement = Settlement::findOrFail($request->settlement_id);
        $settlement->delete();

        //clear from the_logs table
        \DB::table('the_logs')->where('source', '=', 'settlement')->where('refference_id', '=', $request->settlement_id)->delete();
        return redirect('settlement')
            ->with('successMessage', "Settlement $settlement->code has been deleted");
    }


    public function changeSettlementStatus(Request $request)
    {
        $settlement = Settlement::findOrFail($request->settlement_id);

        
        

        //get old settlement status.
        $old_status = $settlement->status;

        $settlement->status = $request->status;
        $settlement->save();

        //register to the_logs table;
        $log_description = "Change status from $old_status to $request->status";
        $log = $this->register_to_the_logs('settlement', 'update', $request->settlement_id, $log_description );

        //find the internal request of this settlement
        $internal_request = $settlement->internal_request;
        //remove the user_id from lock configurations table create_internal_request facility name if the status change is checked or approved
        if($request->status == 'checked' || $request->status == 'approved'){
            $this->unlock_create_internal_request($internal_request->requester_id);    
        }


        return redirect('settlement/'.$request->settlement_id)
            ->with('successMessage', "Settlement status has been chaged to $request->status");
    }


    public function approveMultiple(Request $request)
    {
        $approved = 0;
        $settlement_multiple = $request->settlement_multiple;
        foreach($settlement_multiple as $set){
            $settlement = Settlement::findOrFail($set);
            //find the internal request of this settlement
            $internal_request = $settlement->internal_request;

            if($settlement->status == 'pending' || $settlement->status == 'checked' ){
                $settlement->status = 'approved';
                $settlement->save();
                //register to the_logs table;
                $log_description = "Change status from $settlement->status to approved";
                $log = $this->register_to_the_logs('settlement', 'update', $settlement->id, $log_description);
                //remove the user_id from lock configurations table create_internal_request facility name if the status change is checked or approved
                $this->unlock_create_internal_request($internal_request->requester_id);
                $approved++;
            }
        }

        return redirect()->back()
            ->with('successMessage', "$approved settlement(s) has been approved");
    }


    //Settlement datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM' || $user_role == 'FIN'){
            $settlements = Settlement::with('internal_request', 'internal_request.requester', 'internal_request.project' ,'category', 'sub_category', 'last_updater')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'settlements.*',
            ]);
        }
        else{
            $settlements = Settlement::with('internal_request', 'internal_request.project', 'category', 'sub_category', 'last_updater')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'settlements.*',
            ])
            ->whereHas('internal_request', function($query){
                $query->where('requester_id', '=', \Auth::user()->id);
            });
        }
        

        $data_settlements = Datatables::of($settlements)
            ->editColumn('internal_request', function($settlements){
                if($settlements->internal_request){
                    return $settlements->internal_request->code;
                }else{
                    return NULL;
                }
            })
            ->editColumn('project', function($settlements){
                if($settlements->internal_request){
                    return $settlements->internal_request->project ? $settlements->internal_request->project->code : NULL;
                }else{
                    return NULL;
                }
            })
            ->addColumn('member_name', function($settlements){
                if($settlements->internal_request){
                    return $settlements->internal_request->requester->name;
                }
            })
            ->editColumn('category', function($settlements){
                return $settlements->category->name;
            })
            ->editColumn('sub_category', function($settlements){
                return $settlements->sub_category ? $settlements->sub_category->name : NULL;
            })
            ->editColumn('amount', function($settlements){
                return number_format($settlements->amount, 2);
            })
            ->addColumn('balance', function($settlements){
                if($settlements->internal_request){
                    return number_format($settlements->internal_request->amount - $settlements->amount, 2);
                }else{
                    return NULL;
                }
            })
            ->editColumn('accounted', function($settlements){
                return $settlements->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->editColumn('created_at', function($settlements){
                return jakarta_date_time($settlements->created_at);
            })
            ->addColumn('actions', function($settlements){
                    $actions_html ='<a href="'.url('settlement/'.$settlements->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($settlements->status != 'approved'){
                        $actions_html .='<a href="'.url('settlement/'.$settlements->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this settlement">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';
                    }
                    

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_settlements->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_settlements->make(true);
    }
    //END Settlement datatables
}
