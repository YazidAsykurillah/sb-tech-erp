<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Vendor;
use App\InvoiceVendor;

//use Yajra\Datatables\Datatables;

class TheVendorController extends Controller
{
    
    public function index()
    {
        return view('the-vendor.index');
    }

    
    public function create()
    {
        return view('the-vendor.create');
    }

    
    public function store(StoreVendorRequest $request)
    {
        $data = [
            'name'=>$request->name,
            'product_name'=>$request->product_name,
            'bank_account'=>$request->bank_account,
        ];

        $store = Vendor::create($data);
        $vendor_id = $store->id;
        return redirect('the-vendor/'.$vendor_id)
            ->with('successMessage', "$request->name has been created");
    }

    
    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        /*$invoice_vendors = InvoiceVendor::with(['purchase_order_vendor'=>function($query) use ($id) {
            $query->where('vendor_id','=', $id);
        }])->where('vendor_id',1)->get();*/
        //print_r($vendor->invoice_vendors);exit();

        return view('the-vendor.show')
            ->with('vendor', $vendor);
    }



    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('the-vendor.edit')
            ->with('vendor', $vendor);
    }

    public function update(UpdateVendorRequest $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->name = $request->name;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->product_name = $request->product_name;
        $vendor->bank_account = $request->bank_account;
        $vendor->payment_term_days = $request->payment_term_days;
        $vendor->save();
        return redirect('the-vendor/'.$id)
            ->with('successMessage', "Vendor has been updated");
    }


    public function destroy(Request $request)
    {
        $vendor = Vendor::findOrFail($request->vendor_id);
        $vendor->delete();
        return redirect('the-vendor')
            ->with('successMessage', "$vendor->name has been deleted");
    }


    //VENDOR datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $vendors = Vendor::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'phone',
            'address',
            'product_name',
            'bank_account',
            'created_at',
            'updated_at',
        ]);

        $data_vendors = Datatables::of($vendors)
            ->addColumn('actions', function($vendors){
                    $actions_html ='<a href="'.url('the-vendor/'.$vendors->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('the-vendor/'.$vendors->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this vendor">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-vendor" data-id="'.$vendors->id.'" data-text="'.$vendors->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_vendors->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_vendors->make(true);
    }
    //END VENDOR datatables
}
