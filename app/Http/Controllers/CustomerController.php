<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

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

    
}
