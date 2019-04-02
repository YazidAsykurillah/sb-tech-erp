<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreQuotationVendorRequest;
use App\Http\Requests\StoreQuotationVendorFromPurchaseRequest;
use App\Http\Requests\UpdateQuotationVendorRequest;

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
}
