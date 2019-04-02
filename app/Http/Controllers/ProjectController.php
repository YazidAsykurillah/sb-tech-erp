<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use App\Project;
use App\PurchaseOrderCustomer;
use App\User;
use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('create-project')){
            $purchase_order_customer_opts = PurchaseOrderCustomer::lists('code', 'id');
            $sales_opts = User::lists('name', 'id');
            return view('project.create')
                ->with('sales_opts', $sales_opts)
                ->with('purchase_order_customer_opts', $purchase_order_customer_opts);
        }
        return abort(403);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $current_year = date('Y');
        $yearify = substr($current_year, -2);

        $next_project_code = "";
        if($request->category == "internal"){
            $next_project_code = trim(trim($request->code));
        }
        else{
            //Block build next project code
            $count_project_id = \DB::table('projects')->where('created_at', 'like', "%$current_year%")->where('code','like',"%P-%")->count();
            if($count_project_id > 0){
                $max = \DB::table('projects')->where('category', '=', 'external')->max('code');
                $int_max = ltrim(substr($max, -3), '0');
                $next_project_code = "P-".$yearify."-".str_pad(($int_max+1), 5, 0, STR_PAD_LEFT);
            }
            else{
               $next_project_code = "P-".$yearify."-".str_pad(1, 5, 0, STR_PAD_LEFT);
            }
            //ENDBlock build next project code
        }
        $project = new Project;
        $project->category = $request->category;
        $project->code = $next_project_code;
        $project->name = $request->name;
        $project->purchase_order_customer_id = $request->purchase_order_customer_id;
        $project->sales_id = $request->sales_id;
        $store = $project->save();

        if($store){
            return redirect('project')
                ->with('successMessage', 'Project has been saved');
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
        
        if(\Auth::user()->can('show-project')){
            $project = Project::findOrFail($id);
            $total_paid_invoice = $project->paid_invoice_customer();
            $total_pending_invoice = $project->pending_invoice_customer();
            $total_invoice_due = $project->invoice_customer_due();

            $total_amount_invoice_vendor = $project->total_amount_invoice_vendor();
            $total_amount_internal_request = $project->total_amount_internal_request();

            $total_expense_from_settlement = $this->get_total_expense_from_settlement($project);
            $total_expenses = $total_amount_invoice_vendor+$total_amount_internal_request+$total_expense_from_settlement;
            $purchase_order_customer_amount = ($project->purchase_order_customer ? $project->purchase_order_customer->amount : 1);
            $purchase_order_customer_amount_per_ppn = $purchase_order_customer_amount/1.1;

            $invoiced = "";
            //if project has purchase_order_customer
            if($project->purchase_order_customer){
                $po_customer_amount = $project->purchase_order_customer->amount;
                $invoiced = ($total_paid_invoice+$total_pending_invoice)/$po_customer_amount*100;
            }
            else{
               $invoiced = 0;
            }
            
            return view('project.show')
                ->with('project', $project)
                ->with('total_paid_invoice', $total_paid_invoice)
                ->with('total_amount_invoice_vendor', $total_amount_invoice_vendor)
                ->with('total_amount_internal_request', $total_amount_internal_request)
                ->with('total_expense_from_settlement', $total_expense_from_settlement)
                ->with('total_expenses', $total_expenses)
                ->with('invoiced', $invoiced)
                ->with('total_invoice_due', $total_invoice_due);
        }
        return abort(403);

        /*$project = Project::findOrFail($id);

        $paid_invoice_customer = $project->paid_invoice_customer();
        echo $paid_invoice_customer;*/
        
    }

    protected function get_total_expense_from_settlement($project)
    {
        $total_expense_from_settlement = 0;
        //check if project has already settlement
        if($project->internal_requests->count())
        {
           $settlement_amount_array = [];
           $settlement_adder_array = [];
           $settlement_subtracter_array = [];
           foreach($project->internal_requests as $internal_request){
            if(count($internal_request->settlement)){
                if($internal_request->settlement->status == 'approved' || $internal_request->settlement->status == 'pending'){
                    //$settlement_amount_array[] = $internal_request->amount - $internal_request->settlement->amount;
                    if($internal_request->amount - $internal_request->settlement->amount < 0){
                        $settlement_adder_array[] = abs($internal_request->amount - $internal_request->settlement->amount);
                    }
                    if($internal_request->amount - $internal_request->settlement->amount > 0){
                        $settlement_subtracter_array[] = $internal_request->amount - $internal_request->settlement->amount;
                    }
                }
            }

           }
           //$total_expense_from_settlement = array_sum($settlement_amount_array);
           $total_settlement_adder = array_sum($settlement_adder_array);
           $total_settlement_subtracter = array_sum($settlement_subtracter_array);
           //exit($total_settlement_subtracter);
           $total_expense_from_settlement = $total_settlement_adder - $total_settlement_subtracter;
           
        }
        return $total_expense_from_settlement;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->can('edit-project')){
            $project = Project::findOrFail($id);
            $purchase_order_customer_opts = PurchaseOrderCustomer::lists('code', 'id');
            $sales_opts = User::lists('name', 'id');
            return view('project.edit')
                ->with('sales_opts', $sales_opts)
                ->with('purchase_order_customer_opts', $purchase_order_customer_opts)
                ->with('project', $project);
        }
        return abort(403);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        if($project->category == 'internal'){
            $project->code = $request->code;
        }
        $project->name = $request->name;
        $project->purchase_order_customer_id = $request->purchase_order_customer_id;
        $project->sales_id = $request->sales_id;
        $project->enabled = $request->enabled;
        $project->save();
        return redirect('project/'.$id)
            ->with('successMessage', "Project has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $project->delete();
        return redirect('project')
            ->with('successMessage', "Project has been deleted");
    }


    public function getSalesFromPurchaseOrderCustomer(Request $request)
    {
        $purchase_order_customer_id = $request->purchase_order_customer_id;
        $purchase_order_customer = PurchaseOrderCustomer::findOrFail($purchase_order_customer_id);
        $sales_id = $purchase_order_customer->quotation_customer->sales->id;
        $sales = User::findOrFail($sales_id);
        return json_encode($sales);
    }



    
}
