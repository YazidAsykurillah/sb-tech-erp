<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreQuotationVendorRequest;
use App\Http\Requests\StoreQuotationVendorFromPurchaseRequest;
use App\Http\Requests\UpdateQuotationVendorRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\QuotationVendor;
use App\PurchaseRequest;
use App\Vendor;

class QuotationVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quotation-vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$purchase_request_opts = PurchaseRequest::lists('code', 'id');
        $vendor_opts = Vendor::lists('name', 'id');
        return view('quotation-vendor.create')
            //->with('purchase_request_opts', $purchase_request_opts)
            ->with('vendor_opts', $vendor_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuotationVendorRequest $request)
    {
        $quotation_vendor = new QuotationVendor;
        //$quotation_vendor->purchase_request_id = $request->purchase_request_id;
        $quotation_vendor->code = $request->code;
        $quotation_vendor->vendor_id = $request->vendor_id;
        $quotation_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $quotation_vendor->description = $request->description;
        $quotation_vendor->user_id = \Auth::user()->id;
        $quotation_vendor->received_date = $request->received_date;
        $quotation_vendor->save();
        $last_id = $quotation_vendor->id;
        return redirect('quotation-vendor/'.$last_id)
            ->with('successMessage', "Quotation Vendor has been created");
    }

    public function saveFromPurchaseRequest(StoreQuotationVendorFromPurchaseRequest $request)
    {

        $quotation_vendor = new QuotationVendor;
        //$quotation_vendor->purchase_request_id = $request->purchase_request_id;
        $quotation_vendor->code = $request->quotation_vendor_code;
        $quotation_vendor->vendor_id = $request->the_vendor_id;
        $quotation_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->quotation_vendor_amount));
        $quotation_vendor->description = $request->quotation_vendor_description;
        $quotation_vendor->received_date = $request->quotation_vendor_received_date;
        $quotation_vendor->user_id = \Auth::user()->id;
        $quotation_vendor->save();
        $last_id = $quotation_vendor->id;

        return json_encode(QuotationVendor::where('id', $last_id)->get()->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation_vendor = QuotationVendor::findOrFail($id);
        return view('quotation-vendor.show')
            ->with('quotation_vendor', $quotation_vendor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation_vendor = QuotationVendor::findOrFail($id);
        $purchase_request_opts = PurchaseRequest::lists('code', 'id');
        $vendor_opts = Vendor::lists('name', 'id');
        return view('quotation-vendor.edit')
            ->with('quotation_vendor', $quotation_vendor)
            ->with('purchase_request_opts', $purchase_request_opts)
            ->with('vendor_opts', $vendor_opts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateQuotationVendorRequest $request, $id)
    {
        $quotation_vendor = QuotationVendor::findOrFail($id);
        $quotation_vendor->code = $request->code;
        $quotation_vendor->vendor_id = $request->vendor_id;
        $quotation_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $quotation_vendor->description = $request->description;
        $quotation_vendor->received_date = $request->received_date;
        $quotation_vendor->save();
        return redirect('quotation-vendor/'.$id)
            ->with('successMessage', "Quotation vendor has been updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $quotation_vendor = QuotationVendor::findOrFail($request->quotation_vendor_id);
        $quotation_vendor->delete();
        return redirect('quotation-vendor')
            ->with('successMessage', "Deleted 1 quotation vendor");
    }


    //Quotation Vendor dataTables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $quotation_vendors = QuotationVendor::with('vendor', 'purchase_request', 'user')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'quotation_vendors.*',
        ]);

        $data_quotation_vendors = Datatables::of($quotation_vendors)
            ->editColumn('purchase_request', function($quotation_vendors){
                if($quotation_vendors->purchase_request){
                    return $quotation_vendors->purchase_request->code;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('vendor', function($quotation_vendors){
                return $quotation_vendors->vendor->name;
            })
            ->editColumn('amount', function($quotation_vendors){
                return number_format($quotation_vendors->amount, 2);
            })
            ->editColumn('description', function($quotation_vendors){
                if(strlen($quotation_vendors->description) > 100){
                    return nl2br(substr($quotation_vendors->description, 0, 100))." ...";
                }else{
                    return $quotation_vendors->description;
                }
            })
            ->editColumn('user', function($quotation_vendors){
                return $quotation_vendors->user ? $quotation_vendors->user->name : "";
            })
            ->addColumn('actions', function($quotation_vendors){
                    $actions_html ='<a href="'.url('quotation-vendor/'.$quotation_vendors->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('quotation-vendor/'.$quotation_vendors->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this quotation">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-quotation-vendor" data-id="'.$quotation_vendors->id.'" data-text="'.$quotation_vendors->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_quotation_vendors->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_quotation_vendors->make(true);
    }
    //END Quotation Vendor dataTables
}
