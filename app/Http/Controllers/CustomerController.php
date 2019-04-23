<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Customer;
use App\PurchaseOrderCustomer;
use App\Project;
use App\InvoiceCustomer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = [
            'name'=>$request->name,
            'contact_number'=>$request->contact_number,
            'address'=>$request->address,
        ];
        $store = Customer::create($data);
        $customer_id = $store->id;
        return redirect('customer/'.$customer_id)
            ->with('successMessage', "$request->name has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        
        //count how many projects from this customer
        $project_array = [];
        if(count($customer->projects)){
            foreach($customer->projects as $project){
                $project_array[] = $project->id;
            }
        }
        
        if(count($project_array)){
            $invoice_customers = InvoiceCustomer::whereIn('project_id', $project_array)->get();
        }
        else{
            $invoice_customers = [];
        }
        return view('customer.show')
            ->with('invoice_customers', $invoice_customers)
            ->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit')
            ->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->contact_number = $request->contact_number;
        $customer->address = $request->address;
        $customer->save();
        return redirect('customer/'.$id)
            ->with('successMessage', "Customer has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);
        $customer->delete();
        return redirect('customer')
            ->with('successMessage', "Customer has been deleted");
    }



    //CUSTOMER datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $customers = Customer::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'contact_number',
            'address',
            'created_at',
            'updated_at',
        ]);

        $data_customers = Datatables::of($customers)
            ->addColumn('actions', function($customers){
                    $actions_html ='<a href="'.url('customer/'.$customers->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('customer/'.$customers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this customer">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-customer" data-id="'.$customers->id.'" data-text="'.$customers->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_customers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_customers->make(true);
    }
    //END CUSTOMER datatables
    
}
