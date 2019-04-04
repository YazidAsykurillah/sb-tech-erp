<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\QuotationCustomer;
use App\QuotationVendor;
use App\PurchaseRequest;
use App\PurchaseOrderCustomer;
use App\PurchaseOrderVendor;
use App\Project;
use App\BankAccount;
use App\Configuration;
use App\AssetCategory;

class Select2Controller extends Controller
{
    //Blok Select2 Customers
    public function select2Customer(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("customers")
                ->select("id","name")
                ->where('name','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("customers")
                    ->select("id","name")
                    ->get();
            
        }
        return response()->json($data);
    }
    //ENDBlok Select2 Customers


    //Block Select2 Users
    public function select2User(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("users")
                ->select("id","name")
                ->where('name','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("users")
                    ->select("id","name")
                    ->get();
            
        }
        return response()->json($data);
    }
    //ENDBlock Select2 Users

    //select2UserForCashbond
    public function select2UserForCashbond(Request $request)
    {
        $user_role = \Auth::user()->roles->first()->code;
        $data = [];
        if($user_role == 'SUP' || $user_role== 'ADM'){
            if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("users")
                ->select("id","name")
                ->where('name','LIKE',"%$search%")
                ->get();
            }else{
                $search = $request->q;
                $data = \DB::table("users")
                        ->select("id","name")
                        ->get();
                
            }
        }else{
            $data = \DB::table("users")
                ->select("id","name")
                ->where('id','=',\Auth::user()->id)
                ->get();
        }
        
        return response()->json($data);
    }
    //ENDselect2UserForCashbond

    //select2UserForCashbondSite
    public function select2UserForCashbondSite(Request $request)
    {
        $user_role = \Auth::user()->roles->first()->code;
        $data = [];
        if($request->has('q')){
        $search = $request->q;
        $data = \DB::table("users")
            ->select("id","name")
            ->where('name','LIKE',"%$search%")
            ->where('type','=', 'outsource')
            ->get();
        }else{
            $search = $request->q;
            $data = \DB::table("users")
                    ->select("id","name")
                    ->where('type','=', 'outsource')
                    ->get();
            
        }
        
        return response()->json($data);
    }
    //ENDselect2UserForCashbondSite

    //Block Select2 Vendors
    public function select2Vendor(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("vendors")
                ->select("id","name")
                ->where('name','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("vendors")
                    ->select("id","name")
                    ->get();
            
        }
        return response()->json($data);
    }
    //ENDBlock Select2 Vendors

    //Block Select2 Purchase Requests
    public function select2PurchaseRequest(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("purchase_requests")
                ->select("id","code")
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("purchase_requests")
                    ->select("id","code")
                    ->get();
            
        }
        return response()->json($data);
    }
    //ENDBlock Select2 Purchase Requests

    //select2PurchaseRequestToCopyItems
    public function select2PurchaseRequestToCopyItems(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = PurchaseRequest::where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = PurchaseRequest::all();
            
        }
        return response()->json($data);
    }
    //ENDselect2PurchaseRequestToCopyItems

    //BLock Select2 Quotation Customer for Purchase Order Customer
    public function select2QuotationCustomerForPOCustomer(Request $request)
    {
        //Block get the boooked quotation customers
        $booked_quot_customer_ids = [];
        $get_booked_quot_customer_ids = \DB::table('purchase_order_customers')->select('quotation_customer_id')->get();
        if(count($get_booked_quot_customer_ids)){
            foreach($get_booked_quot_customer_ids as $g_b_q_c){
                $booked_quot_customer_ids[] = $g_b_q_c->quotation_customer_id;
            }
        }
        //ENDBlock get the boooked quotation customers

        //get current user role
        $user_role = \Auth::user()->roles->first()->code;

        $data = [];
        if($request->has('q')){
            $search = $request->q;
            //there is requested current_quotation_customer_id, it means we are in edit mode
            if($request->current_quotation_customer_id){
                //remove the requested current_quotation_customer_id from $booked_quot_customer_ids
               $booked_quot_customer_ids =  array_diff($booked_quot_customer_ids, [$request->current_quotation_customer_id]);
            }
            //if current user_role is SUPER ADMIN or ADMIN
            if($user_role == 'SUP' || $user_role == 'ADM'){
                $data = QuotationCustomer::with('customer')
                    ->where('status', 'submitted')
                    ->whereNotIn('id', $booked_quot_customer_ids)
                    ->where('code','LIKE',"%$search%")
                    ->orWhereHas('customer', function($query) use ($search, $booked_quot_customer_ids) {
                        $query->where("name", "like", "%$search%");
                        $query->whereNotIn('quotation_customers.id', $booked_quot_customer_ids);
                    })
                    ->get();
            }else{  //if current user_role is NOT wheter SUPER ADMIN or ADMIN
                $data = QuotationCustomer::with('customer', 'sales')
                    ->where('status', 'submitted')
                    ->whereNotIn('id', $booked_quot_customer_ids)
                    ->where('code','LIKE',"%$search%")
                    ->whereHas('sales', function($query){
                        $query->where('sales_id', '=', \Auth::user()->id);
                    })
                    ->orWhereHas('customer', function($query) use ($search, $booked_quot_customer_ids) {
                        $query->where("name", "like", "%$search%");
                        $query->whereNotIn('quotation_customers.id', $booked_quot_customer_ids);
                        $query->where('quotation_customers.sales_id', '=', \Auth::user()->id);
                    })
                    ->get();
            }
            

        }
        else{
            //there is requested current_quotation_customer_id, it means we are in edit mode
            if($request->current_quotation_customer_id){
                //remove the requested current_quotation_customer_id from $booked_quot_customer_ids
               $booked_quot_customer_ids =  array_diff($booked_quot_customer_ids, [$request->current_quotation_customer_id]);
            }
            //if current user_role is SUPER ADMIN or ADMIN
            if($user_role == 'SUP' || $user_role == 'ADM'){
                $data = QuotationCustomer::with('customer')
                    ->whereNotIn('id', $booked_quot_customer_ids)
                    ->where('status', 'submitted')
                    ->get();
            }else{
                $data = QuotationCustomer::with('customer', 'sales')
                    ->whereNotIn('id', $booked_quot_customer_ids)
                    ->where('status', 'submitted')
                    ->whereHas('sales', function($query){
                        $query->where('sales_id', '=', \Auth::user()->id);
                    })
                    ->get();
            }
            
        }
        return response()->json($data);
    }
    //ENDBLock Select2 Quotation Customer for Purchase Order Customer


    //BLock Select2 Quotation Vendor for Purchase Order Vendor
    public function select2QuotationVendorForPOvendor(Request $request)
    {

        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("quotation_vendors")
                ->select("id","code")
                ->where('purchase_order_vendored','=', FALSE)
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("quotation_vendors")
                    ->select("id","code")
                    ->where('purchase_order_vendored','=', FALSE)
                    ->get();
            
        }
        
        return response()->json($data);
    }
    //ENDBLock Select2 Quotation Vendor for Purchase Order Vendor

    //BLock Select2 Quotation Vendor for Purchase Request
    public function select2QuotationVendorForPurchaseRequest(Request $request)
    {

        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("quotation_vendors")
                ->select("id","code", "amount", "description")
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            /*$data = \DB::table("quotation_vendors")
                    ->select("id","code", "amount", "description")
                    ->get();*/
            $data = QuotationVendor::with('vendor','user')
                    ->get();
            
        }
        
        return response()->json($data);
    }
    //ENDBLock Select2 Quotation Vendor for Purchase Request

    //BLock Select2 Purchase Request for Purchase ORder Vendor
    public function select2PurchaseRequestForPOVendor(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = PurchaseRequest::with('quotation_vendor', 'quotation_vendor.vendor', 'purchase_order_vendor', 'project')
                    ->where('purchase_requests.status', 'approved')
                    ->whereDoesntHave('purchase_order_vendor')
                    ->where('purchase_requests.code', 'LIKE', "%$search%")
                    ->get();
        }
        else{
            $search = $request->q;
            $data = PurchaseRequest::with('quotation_vendor','quotation_vendor.vendor', 'purchase_order_vendor', 'project')
                    ->where('purchase_requests.status', 'approved')
                    ->whereDoesntHave('purchase_order_vendor')
                    ->get();
        }
        return response()->json($data);
    }
    //ENDBLock Select2 Purchase Request for Purchase ORder Vendor


    //BLock Select2 Purchase Order Customer For Project
    public function select2PurchaseOrderCustomerForProject(Request $request)
    {
        $booked_po_customer_ids = [];
        $get_booked_po_customer_ids = \DB::table('projects')->select('purchase_order_customer_id')->get();
        if(count($get_booked_po_customer_ids)){
            foreach($get_booked_po_customer_ids as $g_b_po_c){
                if($g_b_po_c->purchase_order_customer_id != NULL){
                    $booked_po_customer_ids[] = $g_b_po_c->purchase_order_customer_id;
                }
            }
        }

        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = PurchaseOrderCustomer::with('customer')
                    ->whereNotIn('id', $booked_po_customer_ids)
                    ->where('code', 'like', "%$search%")
                    ->orWhereHas('customer', function($query) use ($search, $booked_po_customer_ids) {
                        $query->where("name", "like", "%$search%");
                        $query->whereNotIn('purchase_order_customers.id', $booked_po_customer_ids);
                    })
                    ->get();
        }
        else{
            $data = PurchaseOrderCustomer::with('customer')
                    ->whereNotIn('id', $booked_po_customer_ids)
                    ->get();
        }
        return response()->json($data);
    }
    //ENDBLock Select2 Purchase Order Customer For Project


    //BLockSelect2 project for purchase request
    public function select2ProjectForPurchaseRequest(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("projects")
                ->select("id","code", "name")
                ->where('code','LIKE',"%$search%")
                ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("projects")
                    ->select("id","code", "name")
                    ->get();
            
        }
        return response()->json($data);
    }
    //ENDBLock Select2 project for purchase request

    //BLock Select2 Project
    public function select2Project(Request $request)
    {
        $estimated_configuration_limit = Configuration::whereName('estimated-cost-margin-limit')->first()->value;
        
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = Project::where('code','like',"%$search%")
                    ->where('enabled', TRUE)
                    ->get();

        }
        else{
            $search = $request->q;
            $projects = Project::where('enabled', TRUE)->get();
            foreach($projects as $project){
                if($project->estimated_cost_margin >= $estimated_configuration_limit){
                    array_push($data,
                        [
                            'code'=>$project->code,
                            'name'=>$project->name,
                            'id'=>$project->id,
                        ]
                    );
                }
                
            }
        }


        return response()->json($data);
    }
    //ENDSelect2 Project

    //BLock Select2 Project for Invoice Vendor
    public function select2ProjectForInvoiceVendor(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("projects")
                    ->select("id","code")
                    ->where('code','LIKE',"%$search%")
                    ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("projects")
                    ->select("id","code")
                    ->get();
        }
        return response()->json($data);
    }
    //ENDSelect2 Project for Invoice Vendor

    //BLock Select2 Purchase Order Vendor for Invoice Vendor
    public function select2PurchaseOrderVendorForInvoiceVendor(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = PurchaseOrderVendor::with('purchase_request', 'purchase_request.project')
                    ->where('purchase_order_vendors.status', '=', 'uncompleted')
                    ->where('purchase_order_vendors.code','like',"%$search%")
                    ->get();
        }
        else{
            $data = PurchaseOrderVendor::with('purchase_request', 'purchase_request.project')
                    ->where('purchase_order_vendors.status', '=', 'uncompleted')
                    ->get();
        }
        return response()->json($data);
    }
    //ENDBLock Select2 Purchase Order Vendor for Invoice Vendor


    //BLock Select2 Cash
    public function select2Cash(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("cashes")
                    ->select("id","name")
                    ->where('enabled', TRUE)
                    ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("cashes")
                    ->select("id","name")
                    ->where('enabled', TRUE)
                    ->get();
        }
        return response()->json($data);
    }
    //ENDBLock Select2 Cash

    //BLock Select2 Bank Account
    public function select2BankAccount(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("bank_accounts")
                    ->select("id","name","user_id", "account_number")
                    ->where('user_id', '=', $request->user_id)
                    ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("bank_accounts")
                    ->select("id","name", "user_id", "account_number")
                    ->where('user_id', '=', $request->user_id)
                    ->get();
        }
        return response()->json($data);
    }
    //ENDBLock Select2 Bank Account


    //Block Select2 Asset Category
    public function select2AssetCategory(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = AssetCategory::where('name','like',"%$search%")
                    ->get();

        }
        else{
            $asset_category = AssetCategory::get();
            foreach($asset_category as $ac){
               array_push($data,
                    [
                        'name'=>$ac->name,
                        'id'=>$ac->id,
                    ]
                );   
            }
        }


        return response()->json($data);
    }
    //ENDBlock Select2 Asset Category
    
}
