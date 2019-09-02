<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

use Carbon\Carbon;

use App\User;
use App\Role;
use App\Permission;
use App\BankAccount;
use App\Customer;
use App\Vendor;
use App\PurchaseOrderCustomer;
use App\Project;
use App\PurchaseRequest;
use App\InvoiceCustomer;
use App\InvoiceVendor;
use App\PurchaseOrderVendor;
use App\InternalRequest;
use App\Category;
use App\QuotationCustomer;
use App\QuotationVendor;
use App\Settlement;
use App\Cashbond;
use App\Cash;
use App\Transaction;
use App\BankAdministration;
use App\Period;
use App\InvoiceCustomerTax;
use App\InvoiceVendorTax;
use App\CashbondSite;
use App\AccountingExpense;
use App\Payroll;
use App\AssetCategory;
use App\Asset;

class DatatablesController extends Controller
{

	//BANK ACCOUNT datatables
    public function getBankAccounts(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));

        $user_role = \Auth::user()->roles->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM'){
            $bank_accounts = BankAccount::with('owner')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'bank_accounts.*'
            ]);
        }else{
            $bank_accounts = BankAccount::with('owner')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'bank_accounts.*'
            ])->where('user_id', '=', \Auth::user()->id);
        }
        

        $data_bank_accounts = Datatables::of($bank_accounts)
            ->editColumn('owner', function($bank_accounts){
                return $bank_accounts->owner->name;
            })
            ->addColumn('actions', function($bank_accounts){
                    $actions_html ='<a href="'.url('bank-account/'.$bank_accounts->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('bank-account/'.$bank_accounts->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this bank-account">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-bank-account" data-id="'.$bank_accounts->id.'" data-text="'.$bank_accounts->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_bank_accounts->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_bank_accounts->make(true);
    }
    //END BANK ACCOUNT datatables

    

    


    //Permission datatables
    public function getPermissions(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $permissions = Permission::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'permissions.*'
        ]);
        $data_permissions = Datatables::of($permissions)
            ->addColumn('actions', function($permissions){
                    $actions_html ='<a href="'.url('permission/'.$permissions->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('permission/'.$permissions->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this permission">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_permissions->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_permissions->make(true);
    }
    //END Permission datatables

    //Build roles data
    public function getRoles(Request $request){

        \DB::statement(\DB::raw('set @rownum=0'));
        $roles = Role::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
        ])->where('name','!=', 'Super Admin');
        $datatables = Datatables::of($roles)

            ->addColumn('actions', function($roles){
                    $actions_html ='<a href="'.url('role/'.$roles->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('role/'.$roles->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this role">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
    }
    //ENDBuild roles data

    


    


    //PURCHASE REQUEST datatables
    public function getPurchaseRequests(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM' || $user_role =='FIN'){
           $purchase_requests = PurchaseRequest::with('project', 'project.purchase_order_customer.customer', 'user', 'quotation_vendor', 'quotation_vendor.vendor', 'purchase_order_vendor')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_requests.*',
            ]);
       }else{
            //exit();
            $purchase_requests = PurchaseRequest::with('project', 'project.purchase_order_customer.customer', 'user', 'quotation_vendor', 'quotation_vendor.vendor', 'purchase_order_vendor')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_requests.*',
            ])->where('purchase_requests.user_id', \Auth::user()->id);
       }
        

        $data_purchase_requests = Datatables::of($purchase_requests)
            ->addColumn('user', function($purchase_requests){
                if($purchase_requests->user){
                    return $purchase_requests->user->name;
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('code', function($purchase_requests){
                $link  = '';
                $link .= '<a href="'.url('purchase-request/'.$purchase_requests->id.'').'">';
                $link .=    $purchase_requests->code;
                $link .= '</a>';
                return $link;
            })
            ->editColumn('project_id', function($purchase_requests){
                if($purchase_requests->project){
                    return $purchase_requests->project->code;
                }
                
            })
            ->addColumn('quotation_vendor', function($purchase_requests){
                if($purchase_requests->quotation_vendor){
                    return $purchase_requests->quotation_vendor->code;
                }else{
                    return NULL;
                }
            })
            ->addColumn('vendor_name', function($purchase_requests){
                if($purchase_requests->quotation_vendor){
                    return $purchase_requests->quotation_vendor->vendor->name;
                }else{
                    return NULL;
                }
            })
            ->editColumn('description', function($purchase_requests){
                return str_limit($purchase_requests->description, 50);
            })
            ->editColumn('amount', function($purchase_requests){
                return number_format($purchase_requests->amount);
            })
            ->editColumn('created_at', function($settlements){
                return jakarta_date_time($settlements->created_at);
            })
            ->addColumn('purchase_order_vendor', function($purchase_requests){
                if($purchase_requests->purchase_order_vendor){
                    return $purchase_requests->purchase_order_vendor->code;    
                }
                return NULL;
                
            })
            ->addColumn('actions', function($purchase_requests){
                    $actions_html ='<a href="'.url('purchase-request/'.$purchase_requests->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($purchase_requests->status == 'pending'){
                        $actions_html .='<a href="'.url('purchase-request/'.$purchase_requests->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this purchase-request">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-request" data-id="'.$purchase_requests->id.'" data-text="'.$purchase_requests->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';    
                    }

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_purchase_requests->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_purchase_requests->make(true);
    }
    //END PURCHASE REQUEST datatables

    //INVOICE CUSTOMER datatables
    public function getInvoiceCustomers(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_customers = InvoiceCustomer::with('project','project.purchase_order_customer', 'project.purchase_order_customer.customer')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_customers.*',
        ]);


        $data_invoice_customers = Datatables::of($invoice_customers)
            ->editColumn('project_id', function($invoice_customers){

                //return $invoice_customers->project->code;return $invoice_customers->project->code;
                if($invoice_customers->project){
                    return $invoice_customers->project->code;
                }

            })
            ->addColumn('po_customer', function($invoice_customers){
                if($invoice_customers->project){
                    return $invoice_customers->project->purchase_order_customer ? $invoice_customers->project->purchase_order_customer->code : null;
                }
                
            })
            ->addColumn('customer_name', function($invoice_customers){
                if($invoice_customers->project){
                    if($invoice_customers->project->purchase_order_customer){
                        return $invoice_customers->project->purchase_order_customer->customer ? $invoice_customers->project->purchase_order_customer->customer->name : '';
                    }
                    return null;
                    
                }
            })
            ->editColumn('sub_amount', function($invoice_customers){
                return number_format($invoice_customers->sub_amount);
            })
            ->editColumn('amount', function($invoice_customers){
                return number_format($invoice_customers->amount);
            })
            ->editColumn('accounted', function($invoice_customers){
                return $invoice_customers->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($invoice_customers){
                    $actions_html ='<a href="'.url('invoice-customer/'.$invoice_customers->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($invoice_customers->status !='paid'){
                        $actions_html .='<a href="'.url('invoice-customer/'.$invoice_customers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this invoice-customer">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-invoice-customer" data-id="'.$invoice_customers->id.'" data-text="'.$invoice_customers->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_customers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_customers->make(true);
    }
    //END INVOICE CUSTOMER datatables


    //INVOICE CUSTOMER IN WEEK OVERDUE datatables
    public function getInvoiceCustomersInWeekOverDue(Request $request)
    {
        $now_date = Carbon::now();
        $from = $now_date->toDateString();
        $next_week = $now_date->addDays(7)->toDateString();

        \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_customers = InvoiceCustomer::with('project','project.purchase_order_customer', 'project.purchase_order_customer.customer')
        ->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_customers.*',
        ])
        ->whereBetween('due_date',[$from, $next_week])
        ->where('invoice_customers.status','pending');

        $data_invoice_customers = Datatables::of($invoice_customers)
            ->editColumn('project_id', function($invoice_customers){
                return $invoice_customers->project->code;
            })
            ->addColumn('po_customer', function($invoice_customers){
                return $invoice_customers->project->purchase_order_customer->code;
            })
            ->addColumn('customer_name', function($invoice_customers){
                return $invoice_customers->project->purchase_order_customer->customer->name;
            })
            ->editColumn('amount', function($invoice_customers){
                return number_format($invoice_customers->amount);
            })
            ->addColumn('actions', function($invoice_customers){
                    $actions_html ='<a href="'.url('invoice-customer/'.$invoice_customers->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($invoice_customers->status !='paid'){
                        $actions_html .='<a href="'.url('invoice-customer/'.$invoice_customers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this invoice-customer">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-invoice-customer" data-id="'.$invoice_customers->id.'" data-text="'.$invoice_customers->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_customers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_customers->make(true);
    }
    //END INVOICE CUSTOMER IN WEEK OVERDUE datatables

    //INVOICE CUSTOMER OVER LAST WEEK OVERDUE datatables
    public function getInvoiceCustomersOverLastWeekOverDue(Request $request)
    {
        $now_date = Carbon::now();
        $from = $now_date->toDateString();
        $last_week = $now_date->subWeek(1)->toDateString();

        \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_customers = InvoiceCustomer::with('project','project.purchase_order_customer', 'project.purchase_order_customer.customer')
        ->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_customers.*',
        ])
        ->where('due_date', '<', $from)
        ->where('invoice_customers.status','pending');

        $data_invoice_customers = Datatables::of($invoice_customers)
            ->editColumn('project_id', function($invoice_customers){
                return $invoice_customers->project->code;
            })
            ->addColumn('po_customer', function($invoice_customers){
                return $invoice_customers->project->purchase_order_customer->code;
            })
            ->addColumn('customer_name', function($invoice_customers){
                return $invoice_customers->project->purchase_order_customer->customer->name;
            })
            ->editColumn('amount', function($invoice_customers){
                return number_format($invoice_customers->amount);
            })
            ->addColumn('actions', function($invoice_customers){
                    $actions_html ='<a href="'.url('invoice-customer/'.$invoice_customers->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($invoice_customers->status !='paid'){
                        $actions_html .='<a href="'.url('invoice-customer/'.$invoice_customers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this invoice-customer">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-invoice-customer" data-id="'.$invoice_customers->id.'" data-text="'.$invoice_customers->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_customers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_customers->make(true);
    }
    //END INVOICE CUSTOMER OVER LAST WEEK OVERDUE datatables


    



    


    //INVOICE VENDOR IN WEEK OVERDUE datatables
    public function getInvoiceVendorsInWeekOverdue(Request $request)
    {
        $now_date = Carbon::now();
        $from = $now_date->toDateString();
        $next_week = $now_date->addDays(7)->toDateString();

        \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_vendors = InvoiceVendor::with('project', 'purchase_order_vendor', 'purchase_order_vendor.vendor')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_vendors.*',
        ])
        ->whereBetween('due_date',[$from, $next_week])
        ->where('status','pending');

        $data_invoice_vendors = Datatables::of($invoice_vendors)
            ->editColumn('project_id', function($invoice_vendors){
                return $invoice_vendors->project->code;
            })
            ->editColumn('purchase_order_vendor_id', function($invoice_vendors){
                 if($invoice_vendors->purchase_order_vendor){
                    return $invoice_vendors->purchase_order_vendor->code;
                }
            })
            ->addColumn('vendor', function($invoice_vendors){
                if($invoice_vendors->purchase_order_vendor){
                    return $invoice_vendors->purchase_order_vendor->vendor->name;
                }
                
            })
            ->addColumn('actions', function($invoice_vendors){
                    $actions_html ='<a href="'.url('invoice-vendor/'.$invoice_vendors->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('invoice-vendor/'.$invoice_vendors->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this invoice-vendor">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_vendors->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_vendors->make(true);
    }
    //END INVOICE VENDOR IN WEEK OVERDUE datatables



    

    //PENDING INTERNAL REQUEST datatables
    public function getPendingInternalRequests(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $internal_requests = InternalRequest::with('remitter_bank', 'beneficiary_bank', 'project', 'requester')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'internal_requests.*',
        ])
        ->where('internal_requests.status', '=', 'pending');

        $data_internal_requests = Datatables::of($internal_requests)
            ->editColumn('remitter_bank', function($internal_requests){
                if($internal_requests->remitter_bank){
                    return $internal_requests->remitter_bank->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('beneficiary_bank', function($internal_requests){
                if($internal_requests->beneficiary_bank){
                    return $internal_requests->beneficiary_bank->name;
                }else{
                    return NULL;
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
            ->editColumn('settled', function($internal_requests){
                $returned = '';
                if($internal_requests->settled == 1){
                    $returned  = '<p>';
                    $returned .=    'Ada';
                    //$returned .=    '['.$internal_requests->settlement->result.']';
                    $returned .= '</p>';
                }
                else{
                    $returned = 'Tidak Ada';
                }
                return $returned;
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
                    
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_internal_requests->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_internal_requests->make(true);
    }
    //END PENDING INTERNAL REQUEST datatables


    //CHECKED INTERNAL REQUEST datatables
    public function getCheckedInternalRequests(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $internal_requests = InternalRequest::with('remitter_bank', 'beneficiary_bank', 'project', 'requester')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'internal_requests.*',
        ])
        ->where('internal_requests.status', '=', 'checked');

        $data_internal_requests = Datatables::of($internal_requests)
            ->editColumn('remitter_bank', function($internal_requests){
                if($internal_requests->remitter_bank){
                    return $internal_requests->remitter_bank->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('beneficiary_bank', function($internal_requests){
                if($internal_requests->beneficiary_bank){
                    return $internal_requests->beneficiary_bank->name;
                }else{
                    return NULL;
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
            ->editColumn('settled', function($internal_requests){
                $returned = '';
                if($internal_requests->settled == 1){
                    $returned  = '<p>';
                    $returned .=    'Ada';
                    //$returned .=    '['.$internal_requests->settlement->result.']';
                    $returned .= '</p>';
                }
                else{
                    $returned = 'Tidak Ada';
                }
                return $returned;
            })
            ->editColumn('accounted', function($internal_requests){
                return $internal_requests->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($internal_requests){
                    $actions_html ='<a href="'.url('internal-request/'.$internal_requests->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_internal_requests->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_internal_requests->make(true);
    }
    //END CHECKED INTERNAL REQUEST datatables


    //APPROVED INTERNAL REQUEST datatables
    public function getApprovedInternalRequests(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $internal_requests = InternalRequest::with('remitter_bank', 'beneficiary_bank', 'project', 'requester')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'internal_requests.*',
        ])
        ->where('internal_requests.status', '=', 'approved');

        $data_internal_requests = Datatables::of($internal_requests)
            ->editColumn('remitter_bank', function($internal_requests){
                if($internal_requests->remitter_bank){
                    return $internal_requests->remitter_bank->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('beneficiary_bank', function($internal_requests){
                if($internal_requests->beneficiary_bank){
                    return $internal_requests->beneficiary_bank->name;
                }else{
                    return NULL;
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
            ->editColumn('settled', function($internal_requests){
                $returned = '';
                if($internal_requests->settled == 1){
                    $returned  = '<p>';
                    $returned .=    'Ada';
                    //$returned .=    '['.$internal_requests->settlement->result.']';
                    $returned .= '</p>';
                }
                else{
                    $returned = 'Tidak Ada';
                }
                return $returned;
            })
            ->editColumn('accounted', function($internal_requests){
                return $internal_requests->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($internal_requests){
                    $actions_html ='<a href="'.url('internal-request/'.$internal_requests->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_internal_requests->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_internal_requests->make(true);
    }
    //END APPROVED INTERNAL REQUEST datatables



    //CATEGORY datatables
    public function getCategories(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $categories = Category::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'categories.*',
        ]);

        $data_categories = Datatables::of($categories)
            ->addColumn('actions', function($categories){
                    $actions_html ='<a href="'.url('master-data/category/'.$categories->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('master-data/category/'.$categories->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this master-data/category">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-category" data-id="'.$categories->id.'" data-text="'.$categories->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_categories->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_categories->make(true);
    }
    //END CATEGORY datatables


    // Pending Settlement datatables
    public function getPendingSettlements(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $settlements = Settlement::with('internal_request', 'category', 'sub_category', 'last_updater')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'settlements.*',
            ])
        ->whereIn('status', ['pending']);
        

        $data_settlements = Datatables::of($settlements)
            ->editColumn('internal_request', function($settlements){
                if($settlements->internal_request){
                    return $settlements->internal_request->code;
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('category', function($settlements){
                return $settlements->category->name;
            })
            ->editColumn('sub_category', function($settlements){
                return $settlements->sub_category->name;
            })
            ->editColumn('amount', function($settlements){
                return number_format($settlements->amount, 2);
            })
            ->addColumn('balance', function($settlements){
                if($settlements->internal_request){
                    return number_format($settlements->internal_request->amount - $settlements->amount, 2);
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('accounted', function($settlements){
                return $settlements->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($settlements){
                    $actions_html ='<a href="'.url('settlement/'.$settlements->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('settlement/'.$settlements->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this settlement">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_settlements->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_settlements->make(true);
    }
    //END  Pending Settlement datatables


    //CHECKED Settlement datatables
    public function getCheckedSettlements(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $settlements = Settlement::with('internal_request', 'category', 'sub_category', 'last_updater')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'settlements.*',
            ])
        ->whereIn('settlements.status', ['checked']);
        
        $data_settlements = Datatables::of($settlements)
            ->editColumn('internal_request', function($settlements){
                if($settlements->internal_request){
                    return $settlements->internal_request->code;
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('category', function($settlements){
                return $settlements->category->name;
            })
            ->editColumn('sub_category', function($settlements){
                return $settlements->sub_category->name;
            })
            ->editColumn('amount', function($settlements){
                return number_format($settlements->amount, 2);
            })
            ->addColumn('balance', function($settlements){
                if($settlements->internal_request){
                    return number_format($settlements->internal_request->amount - $settlements->amount, 2);
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('accounted', function($settlements){
                return $settlements->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($settlements){
                    $actions_html ='<a href="'.url('settlement/'.$settlements->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_settlements->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_settlements->make(true);
    }
    //END CHECKED Settlement datatables

    //Approved Settlement datatables
    public function getApprovedSettlements(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $settlements = Settlement::with('internal_request', 'category', 'sub_category', 'last_updater')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'settlements.*',
            ])
        ->whereIn('settlements.status', ['approved']);
        
        $data_settlements = Datatables::of($settlements)
            ->editColumn('internal_request', function($settlements){
                if($settlements->internal_request){
                    return $settlements->internal_request->code;
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('category', function($settlements){
                return $settlements->category->name;
            })
            ->editColumn('sub_category', function($settlements){
                return $settlements->sub_category->name;
            })
            ->editColumn('amount', function($settlements){
                return number_format($settlements->amount, 2);
            })
            ->addColumn('balance', function($settlements){
                if($settlements->internal_request){
                    return number_format($settlements->internal_request->amount - $settlements->amount, 2);
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('accounted', function($settlements){
                return $settlements->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($settlements){
                    $actions_html ='<a href="'.url('settlement/'.$settlements->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_settlements->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_settlements->make(true);
    }
    //END Approved Settlement datatables

    


    //Pending Cashbond datatables
    public function getPendingCashbonds(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $cashbonds = Cashbond::with('user')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashbonds.*',
            ])
        ->where('status', '=', 'pending');

        $data_cashbonds = Datatables::of($cashbonds)
            ->editColumn('user', function($cashbonds){
                if($cashbonds->user){
                    return $cashbonds->user->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('amount', function($cashbonds){
                return number_format($cashbonds->amount, 2);
            })
            ->editColumn('accounted', function($cashbonds){
                return $cashbonds->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($cashbonds){
                    $actions_html ='<a href="'.url('cash-bond/'.$cashbonds->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('cash-bond/'.$cashbonds->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this cash-bond">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-cash-bond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_cashbonds->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_cashbonds->make(true);
    }
    //END Pending Cashbond datatables

    //Checked Cashbond datatables
    public function getCheckedCashbonds(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $cashbonds = Cashbond::with('user')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashbonds.*',
            ])
        ->where('cashbonds.status', '=', 'checked');

        $data_cashbonds = Datatables::of($cashbonds)
            ->editColumn('user', function($cashbonds){
                if($cashbonds->user){
                    return $cashbonds->user->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('amount', function($cashbonds){
                return number_format($cashbonds->amount, 2);
            })
            ->editColumn('accounted', function($cashbonds){
                return $cashbonds->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($cashbonds){
                    $actions_html ='<a href="'.url('cash-bond/'.$cashbonds->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_cashbonds->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_cashbonds->make(true);
    }
    //END Checked Cashbond datatables


    //APPROVED Cashbond datatables
    public function getApprovedCashbonds(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $cashbonds = Cashbond::with('user')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashbonds.*',
            ])
        ->where('cashbonds.status', '=', 'approved');

        $data_cashbonds = Datatables::of($cashbonds)
            ->editColumn('user', function($cashbonds){
                if($cashbonds->user){
                    return $cashbonds->user->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('amount', function($cashbonds){
                return number_format($cashbonds->amount, 2);
            })
            ->editColumn('accounted', function($cashbonds){
                return $cashbonds->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($cashbonds){
                    $actions_html ='<a href="'.url('cash-bond/'.$cashbonds->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_cashbonds->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_cashbonds->make(true);
    }
    //END APPROVED Cashbond datatables

    //Cash datatables
    public function getCashes(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        if(\Auth::user()->can('index-cash')){       //show all cashes , wheter the type is bank or petty cash
            $cashes = Cash::select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashes.*',
            ]);    
        }
        else{           //show only petty cash
            $cashes = Cash::select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashes.*',
            ])
            ->where('type', 'cash'); 
        }
        

        $data_cashes = Datatables::of($cashes)
            ->editColumn('amount', function($cashes){
                return number_format($cashes->amount, 2);
            })
            ->addColumn('actions', function($cashes){
                    $actions_html ='<a href="'.url('cash/'.$cashes->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('cash/'.$cashes->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this cash">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-cash" data-id="'.$cashes->id.'" data-text="'.$cashes->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_cashes->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_cashes->make(true);
    }
    //END Cash datatables


    //Transaction datatables
    public function getTransactions(Request $request)
    {
        $total_debet = Transaction::where('type', 'debet')->where('cash_id', $request->cash_id)->sum('amount');
        $total_credit = Transaction::where('type', 'credit')->where('cash_id', $request->cash_id)->sum('amount');

        \DB::statement(\DB::raw('set @rownum=0'));
        if($request->has('date_from') && $request->has('date_to')){
            $transactions = Transaction::with('accounting_expense')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'transactions.*',
            ])
            ->whereBetween('transaction_date',[$request->date_from, $request->date_to])
            ->where('cash_id', $request->cash_id)->get();
        }else{
            $transactions = Transaction::with('accounting_expense')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'transactions.*',
            ])
            ->where('cash_id', $request->cash_id)->get();    
        }
        

        $data_transactions = Datatables::of($transactions)
            ->with('total_debet', $total_debet)
            ->with('total_credit', $total_credit)
            ->editColumn('refference', function($transactions){
                $refference = ucwords(str_replace('_', ' ', $transactions->refference));
                return $refference;
            })
            ->editColumn('refference_number', function($transactions){
                $link = '';
                if($transactions->refference == 'internal_request'){
                    $link = '<a href="'.url('internal-request/'.$transactions->refference_id).'">'.$transactions->refference_number.'</a>';
                }
                if($transactions->refference == 'settlement'){
                    $link = '<a href="'.url('settlement/'.$transactions->refference_id).'">'.$transactions->refference_number.'</a>';
                }
                if($transactions->refference == 'cashbond'){
                    $link = '<a href="'.url('cash-bond/'.$transactions->refference_id).'">'.$transactions->refference_number.'</a>';
                }
                if($transactions->refference == 'invoice_customer'){
                    $link = '<a href="'.url('invoice-customer/'.$transactions->refference_id).'">'.$transactions->refference_number.'</a>';
                }
                if($transactions->refference == 'invoice_vendor'){
                    $link = '<a href="'.url('invoice-vendor/'.$transactions->refference_id).'">'.$transactions->refference_number.'</a>';
                }
                if($transactions->refference == 'bank_administration'){
                    $link = '<a href="'.url('bank-administration/'.$transactions->refference_id).'">'.$transactions->refference_number.'</a>';
                }
                if($transactions->refference == 'invoice_customer_tax'){
                    //the refference id to be displyade is should be pointed to invoice customer of this invoice customer tax
                    //so, let's find out
                    $invoice_customer_id = InvoiceCustomerTax::where('id', '=', $transactions->refference_id)->first()->invoice_customer_id;
                    $link .= '<a href="'.url('invoice-customer/'.$invoice_customer_id).'">'.$transactions->refference_number.'</a>';
                }
                if($transactions->refference == 'site_internal_request'){
                    $link = '<text class="text text-danger">'.$transactions->refference_number.'</text>';
                }
                if($transactions->refference == 'site_settlement'){
                    $link = '<text class="text text-danger">'.$transactions->refference_number.'</text>';
                }
                if($transactions->refference == 'cashbond-site'){
                    $link = '<a href="'.url('cash-bond-site/'.$transactions->refference_id).'">'.$transactions->refference_number.'</a>';
                }
                if($transactions->refference == 'payroll'){
                    $link = '<a href="'.url('payroll/'.$transactions->refference_id).'">'.$transactions->refference_number.'</a>';
                }

                return $link;
            })
            ->addColumn('credit_amount', function($transactions){
                if($transactions->type == 'credit'){
                    return number_format($transactions->amount, 2);
                }else{
                    return NULL;
                }
                
            })
            ->addColumn('debit_amount', function($transactions){
                if($transactions->type == 'debet'){
                    return number_format($transactions->amount, 2);
                }else{
                    return NULL;
                }
            })
            ->editColumn('reference_amount', function($transactions){
                return number_format($transactions->reference_amount);
            })
            ->editColumn('notes', function($transactions){
                return str_limit($transactions->notes, 25);
            })
            ->editColumn('type', function($transactions){
                return ucfirst($transactions->type);
            })
            ->editColumn('transaction_date', function($transactions){
                $actions_html = $transactions->transaction_date;
                if(\Auth::user()->can('edit-transaction')){
                    $actions_html .='&nbsp;<button type="button" class="btn btn-info btn-xs btn-update-transaction" data-id="'.$transactions->id.'" data-transactionDate="'.$transactions->transaction_date.'">';
                    $actions_html .=    '<i class="fa fa-calendar"></i>';
                    $actions_html .='</button>&nbsp;';   
                }
                return $actions_html;
            })
            ->editColumn('created_at', function($transactions){
                return jakarta_date_time($transactions->created_at);
            })
            ->addColumn('accounting_expense', function($transactions){
                return $transactions->accounting_expense ? $transactions->accounting_expense->name : "--";
            })
            ->addColumn('actions', function($transactions){
                $actions_html = "";
                if(\Auth::user()->can('delete-transaction')){
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-transaction" data-id="'.$transactions->id.'" data-text="'.$transactions->refference_number.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>&nbsp;';
                }
                if($transactions->refference == "site_internal_request"){
                    //check it has site settlement
                    $check = \DB::table('transactions')
                            ->where('refference', 'site_settlement')
                            ->where('refference_id', $transactions->id)
                            ->get();

                    if(count($check) != 1){
                        $actions_html .='<button type="button" class="btn btn-default btn-xs btn-create-sitesettlement" title="Click to create the settlement" data-id="'.$transactions->id.'" data-text="'.$transactions->refference_number.'" data-site_ir_amount="'.$transactions->amount.'">';
                        $actions_html .=    '<i class="fa fa-retweet"></i>';
                        $actions_html .='</button>';
                    }
                }

                    $actions_html .='<button type="button" class="btn btn-default btn-xs btn-register-accounting-expense" title="Click to register accounting expense" data-id="'.$transactions->id.'" data-text="'.$transactions->refference_number.'" >';
                    $actions_html .=    '<i class="fa fa-envelope"></i>';
                    $actions_html .='</button>';
                
                return $actions_html;
            });
            /*->filter(function ($query) use ($request) {

                if($request->has('date_from') && $request->has('date_to')){

                    $query->whereBetween('transaction_date',[$request->date_from, $request->date_to]);
                }
            });*/

        if ($keyword = $request->get('search')['value']) {
            $data_transactions->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_transactions->make(true);
    }
    //END Transaction datatables


    //BANK Administration datatables
    public function getBankAdministrations(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $bank_administrations = BankAdministration::with('cash')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'bank_administrations.*'
        ]);

        $data_bank_administrations = Datatables::of($bank_administrations)
            ->editColumn('cash', function($bank_administrations){
                return $bank_administrations->cash->name;
            })
            ->editColumn('amount', function($bank_administrations){
                return number_format($bank_administrations->amount, 2);
            })
            ->editColumn('accounted', function($bank_administrations){
                return $bank_administrations->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($bank_administrations){
                    $actions_html ='<a href="'.url('bank-administration/'.$bank_administrations->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('bank-administration/'.$bank_administrations->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this bank-administration">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-bank-administration" data-id="'.$bank_administrations->id.'" data-text="'.$bank_administrations->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_bank_administrations->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_bank_administrations->make(true);
    }
    //END BANK Administration datatables

    //Period datatables
    public function getPeriods(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $periods = Period::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'periods.*'
        ]);

        $data_periods = Datatables::of($periods)
            
            ->addColumn('actions', function($periods){
                    $actions_html = '';
                    if(\Auth::user()->can('show-period')){
                        $actions_html .='<a href="'.url('period/'.$periods->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                        $actions_html .=    '<i class="fa fa-external-link"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    if(\Auth::user()->can('edit-period')){
                        $actions_html .='<a href="'.url('period/'.$periods->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this period">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';    
                    }
                    if(\Auth::user()->can('delete-period')){
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-period" data-id="'.$periods->id.'" data-text="'.$periods->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';
                    }

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_periods->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_periods->make(true);
    }
    //END Period datatables

    //User Time Period datatables
    public function getUserTimePeriods(Request $request)
    {   
        $user_id = $request->user_id;

        \DB::statement(\DB::raw('set @rownum=0'));
        $periods = Period::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'periods.*'
        ]);

        $data_periods = Datatables::of($periods)
            ->addColumn('actions', function($periods) use($user_id){
                $time_report_user = \DB::table('time_report_user')
                                    ->where('user_id', '=', $user_id)
                                    ->where('period_id', '=', $periods->id)
                                    ->get();
                if(count($time_report_user)){
                    $actions_html ='<a href="'.url('user/time-report/show/?user_id='.$user_id.'&period_id='.$periods->id).'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;'; 
                }
                else{
                    $actions_html ='<a href="'.url('user/time-report/create/?user_id='.$user_id.'&period_id='.$periods->id).'" class="btn btn-success btn-xs" title="Click to register time report">';
                    $actions_html .=    '<i class="fa fa-plus"></i>';
                    $actions_html .='</a>&nbsp;';
                }
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_periods->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_periods->make(true);
    }
    //END User Time Period datatables


    //TRANSFER TASK INTERNAL REQUEST datatables
    public function getTransferTaskInternalRequests(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles()->first()->code; 
        $internal_requests = InternalRequest::with('remitter_bank', 'beneficiary_bank', 'project', 'requester')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'internal_requests.*',
            ])
            ->where('internal_requests.status', 'approved')
            ->where('accounted', false);

        $data_internal_requests = Datatables::of($internal_requests)
            ->editColumn('code', function($internal_requests){
                $link  = '<a href="'.url('internal-request/'.$internal_requests->id.'').'">';
                $link .=    $internal_requests->code;
                $link .= '</a>';
                return $link;
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
            ->editColumn('remitter_bank', function($internal_requests){
                if($internal_requests->remitter_bank){
                    return $internal_requests->remitter_bank->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('beneficiary_bank', function($internal_requests){
                if($internal_requests->type != "pindah_buku"){
                    if($internal_requests->beneficiary_bank){
                        return $internal_requests->beneficiary_bank->name;
                    }else{
                        return NULL;
                    }
                }
                else if($internal_requests->type == 'pindah_buku'){
                    if($internal_requests->bank_target){
                        return $internal_requests->bank_target->name;
                    }else{
                        return "";
                    }
                }
                else{
                    return NULL;
                }
                
                
            })
            ->editColumn('amount', function($internal_requests){
                return number_format($internal_requests->amount);
            })
            ->editColumn('project', function($internal_requests){
                if($internal_requests->project){
                    return $internal_requests->project->code;
                }
                
            })
            ->editColumn('requester', function($internal_requests){
                return $internal_requests->requester->name;
            })
            ->addColumn('transfered', function($internal_requests){
                if($internal_requests->accounted == TRUE){
                    return "Yes";    
                }else{
                    return "No";
                }
            })
            ->addColumn('actions', function($internal_requests) use ($user_role){
                $actions_html = "";
                if($user_role == 'FIN' || $user_role == 'ADM'){
                    if($internal_requests->accounted == FALSE && $internal_requests->accounted_approval == 'pending'){
                        $actions_html = '<i class="fa fa-clock-o" title="Waiting for transfer approval"></i>';
                    }
                    elseif($internal_requests->accounted == FALSE && $internal_requests->accounted_approval == 'approved'){
                        if($internal_requests->remitter_bank && $internal_requests->beneficiary_bank)
                        {
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'" data-remitterBank="'.$internal_requests->remitter_bank->name.'" data-beneficiaryBank="'.$internal_requests->beneficiary_bank->name.'">';
                        }
                        else{
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'" data-remitterBank="" data-beneficiaryBank="">';
                        }
                        $actions_html .=    '<i class="fa fa-money"></i>';
                        $actions_html .='</button>';
                    }

                }elseif($user_role == 'SUP'){
                    if($internal_requests->accounted_approval == 'pending' && $internal_requests->type != 'pindah_buku'){
                        $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'" data-requester-id="'.$internal_requests->requester->id.'">';
                        $actions_html .=    '<i class="fa fa-check-circle" title="Click to approve this transfer task"></i>';
                        $actions_html .='</button>';
                    }
                    elseif($internal_requests->accounted_approval == 'pending' && $internal_requests->type == 'pindah_buku'){
                        $actions_html ='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-internal-request-pindah-buku" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'" data-requester-id="'.$internal_requests->requester->id.'">';
                        $actions_html .=    '<i class="fa fa-check-circle" title="Click to approve this transfer task pindah buku"></i>';
                        $actions_html .='</button>';
                    }
                    elseif($internal_requests->accounted == FALSE && $internal_requests->accounted_approval == 'approved'){
                        if($internal_requests->remitter_bank && $internal_requests->beneficiary_bank)
                        {
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'" data-remitterBank="'.$internal_requests->remitter_bank->name.'" data-beneficiaryBank="'.$internal_requests->beneficiary_bank->name.'">';
                            $actions_html .=    '<i class="fa fa-money"></i>';
                            $actions_html .='</button>&nbsp;';
                            $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'" data-requester-id="'.$internal_requests->requester->id.'">';
                            $actions_html .=    '<i class="fa fa-cog" title="Click to approve this transfer task"></i>';
                            $actions_html .='</button>';
                        }
                        else{
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'" data-remitterBank="" data-beneficiaryBank="">';
                            $actions_html .=    '<i class="fa fa-money"></i>';
                            $actions_html .='</button>&nbsp;';
                            $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-internal-request" data-id="'.$internal_requests->id.'" data-text="'.$internal_requests->code.'" data-requester-id="'.$internal_requests->requester->id.'">';
                            $actions_html .=    '<i class="fa fa-cog" title="Click to approve this transfer task"></i>';
                            $actions_html .='</button>';
                        }
                        
                    }
                   
                }
               
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_internal_requests->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_internal_requests->make(true);
    }
    //END TRANSFER TASK INTERNAL REQUEST datatables


    //Invoice customer TAX Lists
    public function getInvoiceCustomerTaxes(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_customer_taxes = InvoiceCustomerTax::with('invoice_customer', 'cash')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_customer_taxes.*',
        ])->distinct()->groupBy('invoice_customer_id')->get();
        //$collect_invoice_customer_taxes = collect($invoice_customer_taxes);
        



        $data_invoice_customer_taxes = Datatables::of($invoice_customer_taxes)
            ->editColumn('invoice_customer_id', function($invoice_customer_taxes){
                return $invoice_customer_taxes->invoice_customer->code;
            })
            ->editColumn('amount', function($invoice_customer_taxes){
                return number_format($invoice_customer_taxes->amount,2);
            })
            ->editColumn('cash_id', function($invoice_customer_taxes){
                if($invoice_customer_taxes->cash){
                    return $invoice_customer_taxes->cash->name;
                }else{
                    return NULL;
                }
            })
            ->addColumn('tax_date', function($invoice_customer_taxes){
                return $invoice_customer_taxes->invoice_customer->tax_date;
            })
            ->addColumn('actions', function($invoice_customer_taxes){
                $actions_html = "";
                if($invoice_customer_taxes->status != 'paid'){
                    $actions_html ='<button type="button" class="btn btn-info btn-xs btn-paid-tax" data-id="'.$invoice_customer_taxes->id.'" data-description="['.$invoice_customer_taxes->source.'] of '.$invoice_customer_taxes->invoice_customer->code.'">';
                    $actions_html .=    '<i class="fa fa-money"></i>';
                    $actions_html .='</button>';
                }elseif($invoice_customer_taxes->status =='paid' && $invoice_customer_taxes->approval=='pending'){
                    $actions_html ='<button type="button" class="btn btn-success btn-xs btn-approve-paid-tax" data-id="'.$invoice_customer_taxes->id.'" data-description="['.$invoice_customer_taxes->source.'] of '.$invoice_customer_taxes->invoice_customer->code.'">';
                    $actions_html .=    '<i class="fa fa-check-circle"></i>';
                    $actions_html .='</button>';
                }
                else{
                    $actions_html="";
                }
                
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_customer_taxes->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_customer_taxes->make(true);
    }
    //END Invoice customer TAX Lists


    //Invoice vendor TAX Lists
    public function getInvoiceVendorTaxes(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_vendor_taxes = InvoiceVendorTax::with('invoice_vendor', 'cash')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_vendor_taxes.*',
        ]);

        $data_invoice_vendor_taxes = Datatables::of($invoice_vendor_taxes)
            ->editColumn('invoice_vendor_id', function($invoice_vendor_taxes){
                if($invoice_vendor_taxes->invoice_vendor){
                    return $invoice_vendor_taxes->invoice_vendor->code;    
                }
                return NULL;
                
            })
             ->addColumn('tax_date', function($invoice_vendor_taxes){
                return $invoice_vendor_taxes->invoice_vendor->tax_date;
            })
            ->editColumn('amount', function($invoice_vendor_taxes){
                return number_format($invoice_vendor_taxes->amount,2);
            })
            ->editColumn('cash_id', function($invoice_vendor_taxes){
                if($invoice_vendor_taxes->cash){
                    return $invoice_vendor_taxes->cash->name;
                }else{
                    return NULL;
                }
            })
            ->addColumn('actions', function($invoice_vendor_taxes){
                $actions_html = "";
                if($invoice_vendor_taxes->status != 'paid'){
                    $actions_html ='<button type="button" class="btn btn-info btn-xs btn-paid-tax" data-id="'.$invoice_vendor_taxes->id.'" data-description="['.$invoice_vendor_taxes->source.'] of '.($invoice_vendor_taxes->invoice_vendor ? $invoice_vendor_taxes->invoice_vendor->code : "").'">';
                    $actions_html .=    '<i class="fa fa-money"></i>';
                    $actions_html .='</button>';
                }elseif($invoice_vendor_taxes->status =='paid' && $invoice_vendor_taxes->approval=='pending'){
                    $actions_html ='<button type="button" class="btn btn-success btn-xs btn-approve-paid-tax" data-id="'.$invoice_vendor_taxes->id.'" data-description="['.$invoice_vendor_taxes->source.'] of '.($invoice_vendor_taxes->invoice_vendor ? $invoice_vendor_taxes->invoice_vendor->code : "").'">';
                    $actions_html .=    '<i class="fa fa-check-circle"></i>';
                    $actions_html .='</button>';
                }
                else{
                    $actions_html="";
                }
                
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_vendor_taxes->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_vendor_taxes->make(true);
    }
    //END Invoice vendor TAX Lists

    
    //TRANSFER TASK INVOICE VENDORS
    public function getTransferTaskInvoiceVendors(Request $request)
    {

        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles()->first()->code;
        if($request->filter && $request->filter = 'over_last_week_overdue'){
            $now_date = Carbon::now();
            $from = $now_date->toDateString();
            $last_week = $now_date->subWeek(1)->toDateString();
            
            $invoice_vendors = InvoiceVendor::with('project', 'purchase_order_vendor','purchase_order_vendor.vendor', 'remitter_bank')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'invoice_vendors.*',
            ])
            ->where('invoice_vendors.status', 'pending')
            ->where('due_date','<=', $last_week)
            ->where('accounted', false);
        }
        else{

            $invoice_vendors = InvoiceVendor::with('project', 'purchase_order_vendor','purchase_order_vendor.vendor', 'remitter_bank', 'purchase_order_vendor.purchase_request', 'purchase_order_vendor.purchase_request.migo')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'invoice_vendors.*',
            ])
            ->where('invoice_vendors.status', 'pending')
            ->where('accounted', false);
        }
        

        $data_invoice_vendors = Datatables::of($invoice_vendors)
            ->editColumn('code', function($invoice_vendors){
                $code_link = "";
                if($invoice_vendors->code){
                    $code_link   .= '<a href="'.url('invoice-vendor/'.$invoice_vendors->id.'').'">';
                    $code_link   .=  $invoice_vendors->code;
                    $code_link   .= '</a>';
                }
                return $code_link;
                
            })
            ->editColumn('project', function($invoice_vendors){
                $project_link = "";
                if($invoice_vendors->project){
                    $project_link   .= '<a href="'.url('project/'.$invoice_vendors->project->id.'').'">';
                    $project_link   .=  $invoice_vendors->project->code;
                    $project_link   .= '</a>';
                }
                return $project_link;
            })
            ->addColumn('vendor', function($invoice_vendors){
                if($invoice_vendors->purchase_order_vendor){
                    if($invoice_vendors->purchase_order_vendor->vendor){
                        return $invoice_vendors->purchase_order_vendor->vendor->name;    
                    }
                    return NULL;
                    
                }
                return NULL;
            })
            ->addColumn('po_vendor_code', function($invoice_vendors){
                $po_vendor_code_link = "";
                if($invoice_vendors->purchase_order_vendor){
                    $po_vendor_code_link   .= '<a href="'.url('purchase-order-vendor/'.$invoice_vendors->purchase_order_vendor->id.'').'">';
                    $po_vendor_code_link   .=  $invoice_vendors->purchase_order_vendor->code;
                    $po_vendor_code_link   .= '</a>';
                }
                return $po_vendor_code_link;
            })
            ->editColumn('amount', function($invoice_vendors){
                return number_format($invoice_vendors->amount);
            })
            ->editColumn('remitter_bank', function($invoice_vendors){
                if($invoice_vendors->remitter_bank){
                    return $invoice_vendors->remitter_bank->name;
                }else{
                    return NULL;
                }
                
            })
            ->addColumn('beneficiary_bank', function($invoice_vendors){
                if($invoice_vendors->purchase_order_vendor){
                    if($invoice_vendors->purchase_order_vendor->vendor){
                        return $invoice_vendors->purchase_order_vendor->vendor->bank_account;    
                    }
                    return NULL;
                    
                }
                return NULL;
                
            })
            ->editColumn('accounted', function($invoice_vendors){
                $disp = "";
                if($invoice_vendors->accounted == TRUE){
                    $disp = "Yes";
                }else{
                    $disp = "No";
                }
                return $disp;
            })
            ->editColumn('purchase_request_migo', function($invoice_vendors){
                $migo = NULL;
                if($invoice_vendors->purchase_order_vendor){
                    if($invoice_vendors->purchase_order_vendor->purchase_request){
                        if($invoice_vendors->purchase_order_vendor->purchase_request->migo){
                            $migo = $invoice_vendors->purchase_order_vendor->purchase_request->migo->code;
                        }
                    }
                }
               return $migo;
            })
            ->addColumn('actions', function($invoice_vendors) use ($user_role){
                $actions_html = "";
                if($user_role == 'FIN' || $user_role == 'ADM'){
                    if($invoice_vendors->accounted == FALSE && $invoice_vendors->accounted_approval == 'pending'){
                        $actions_html = '<i class="fa fa-clock-o" title="Waiting for accounted approval"></i>';
                    }
                    elseif($invoice_vendors->accounted == FALSE && $invoice_vendors->accounted_approval == 'approved'){
                        if($invoice_vendors->remitter_bank)
                        {
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'" data-amount="'.number_format($invoice_vendors->amount).'" data-remitterBank="'.$invoice_vendors->remitter_bank->name.'" >';
                        }
                        else{
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'">';
                        }
                        $actions_html .=    '<i class="fa fa-money"></i>';
                        $actions_html .='</button>';
                    }

                }elseif($user_role == 'SUP'){
                    if($invoice_vendors->accounted_approval == 'pending'){
                        $actions_html ='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'">';
                        $actions_html .=    '<i class="fa fa-check-circle" title="Click to approve this transfer task"></i>';
                        $actions_html .='</button>';
                    }
                    elseif($invoice_vendors->accounted == FALSE && $invoice_vendors->accounted_approval == 'approved'){
                        if($invoice_vendors->remitter_bank)
                        {
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'" data-amount="'.number_format($invoice_vendors->amount).'" data-remitterBank="'.$invoice_vendors->remitter_bank->name.'" >';
                            $actions_html .=    '<i class="fa fa-money"></i>';
                            $actions_html .='</button>&nbsp;';
                            $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'">';
                            $actions_html .=    '<i class="fa fa-cog" title="Click to change the cash"></i>';
                            $actions_html .='</button>';
                        }
                        else{
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'">';
                            $actions_html .=    '<i class="fa fa-money"></i>';
                            $actions_html .='</button>&nbsp;';
                            $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'">';
                            $actions_html .=    '<i class="fa fa-cog" title="Click to change the cash"></i>';
                            $actions_html .='</button>';
                        }
                        
                    }
                    else{

                    }
                   
                }
               
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_vendors->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_vendors->make(true);
    }
    //END TRANSFER TASK INVOICE VENDORS

    
    //transfer task settlement
    public function getTransferTaskSettlement(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles()->first()->code; 
        $settlements = Settlement::with('internal_request', 'internal_request.requester', 'internal_request.remitter_bank', 'remitter_bank')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'settlements.*',
            ])
            ->where('settlements.status', 'approved')
            ->where('settlements.accounted', false);

        $data_settlement = Datatables::of($settlements)
            ->editColumn('code', function($settlements){
                $link  ='<a href="'.url('settlement/'.$settlements->id).'">';
                $link .=    $settlements->code;
                $link .='</a>';
                return $link;
            })
            ->addColumn('ir_code', function($settlements){
                $link  ='<a href="'.url('internal-request/'.$settlements->internal_request->id).'">';
                $link .=    $settlements->internal_request->code;
                $link .='</a>';
                return $link;
            })
            ->addColumn('ir_cash', function($settlements){
                return $settlements->internal_request->remitter_bank ? $settlements->internal_request->remitter_bank->name : null;
            })
            ->editColumn('amount', function($settlements){
                return number_format($settlements->amount);
            })
            ->addColumn('member_name', function($settlements){
                return $settlements->internal_request->requester->name;
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
           ->editColumn('remitter_bank_id', function($settlements){
                if($settlements->remitter_bank){
                    return $settlements->remitter_bank->name;
                }
                return NULL;
           })
            ->addColumn('actions', function($settlements) use ($user_role){
                $actions_html = "";
                if($user_role == 'FIN' || $user_role == 'ADM'){
                    if($settlements->accounted == FALSE && $settlements->accounted_approval == 'pending'){
                        $actions_html = '<i class="fa fa-clock-o" title="Waiting for accounted approval"></i>';
                    }
                    elseif($settlements->accounted == FALSE && $settlements->accounted_approval == 'approved'){
                        if($settlements->remitter_bank)
                        {
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'" data-amount="'.number_format($settlements->amount).'" data-remitterBank="'.$settlements->remitter_bank->name.'">';
                        }
                        else{
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'">';
                        }
                        $actions_html .=    '<i class="fa fa-money"></i>';
                        $actions_html .='</button>';
                    }

                }elseif($user_role == 'SUP'){
                    if($settlements->accounted_approval == 'pending'){
                        $actions_html ='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'">';
                        $actions_html .=    '<i class="fa fa-check-circle" title="Click to approve this transfer task"></i>';
                        $actions_html .='</button>';
                    }
                    elseif($settlements->accounted == FALSE && $settlements->accounted_approval == 'approved'){
                        if($settlements->remitter_bank)
                        {
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'" data-amount="'.number_format($settlements->amount).'" data-remitterBank="'.$settlements->remitter_bank->name.'">';
                            $actions_html .=    '<i class="fa fa-money"></i>';
                            $actions_html .='</button>&nbsp;';
                            $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'">';
                            $actions_html .=    '<i class="fa fa-cog" title="Click to approve this transfer task"></i>';
                            $actions_html .='</button>';
                        }
                        else{
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'">';
                            $actions_html .=    '<i class="fa fa-money"></i>';
                            $actions_html .='</button>&nbsp;';
                            $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-settlement" data-id="'.$settlements->id.'" data-text="'.$settlements->code.'">';
                            $actions_html .=    '<i class="fa fa-cog" title="Click to approve this transfer task"></i>';
                            $actions_html .='</button>';
                        }
                        
                    }
                    else{

                    }
                   
                }
               
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_settlement->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_settlement->make(true);
    }


    //transfer task cashbond
    public function getTransferTaskCashbond(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles()->first()->code; 
        $cashbonds = Cashbond::with('user', 'remitter_bank')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashbonds.*',
            ])
            ->where('cashbonds.status', 'approved')
            ->where('cashbonds.accounted', false);

        $data_cashbonds = Datatables::of($cashbonds)
            ->editColumn('code', function($cashbonds){
                $link  ='<a href="'.url('cash-bond/'.$cashbonds->id).'">';
                $link .=    $cashbonds->code;
                $link .='</a>';
                return $link;
            })
            ->editColumn('amount', function($cashbonds){
                return number_format($cashbonds->amount);
            })
            ->addColumn('member_name', function($cashbonds){
                return $cashbonds->user->name;
            })
             ->editColumn('accounted', function($cashbonds){
                return $cashbonds->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->editColumn('remitter_bank_id', function($cashbonds){
                if($cashbonds->remitter_bank){
                    return $cashbonds->remitter_bank->name;
                }
                return NULL;
           })
            ->addColumn('actions', function($cashbonds) use ($user_role){
                $actions_html = "";
                if($user_role == 'FIN' || $user_role == 'ADM'){
                    if($cashbonds->accounted == FALSE && $cashbonds->accounted_approval == 'pending'){
                        $actions_html = '<i class="fa fa-clock-o" title="Waiting for accounted approval"></i>';
                    }
                    elseif($cashbonds->accounted == FALSE && $cashbonds->accounted_approval == 'approved'){
                        if($cashbonds->remitter_bank)
                        {
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-cashbond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'" data-amount="'.number_format($cashbonds->amount).'" data-remitterBank="'.$cashbonds->remitter_bank->name.'">';
                        }
                        else{
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-cashbond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'">';
                        }
                        $actions_html .=    '<i class="fa fa-money"></i>';
                        $actions_html .='</button>';
                    }

                }elseif($user_role == 'SUP'){
                    if($cashbonds->accounted_approval == 'pending'){
                        $actions_html ='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-cashbond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'">';
                        $actions_html .=    '<i class="fa fa-check-circle" title="Click to approve this transfer task"></i>';
                        $actions_html .='</button>';
                    }
                    elseif($cashbonds->accounted == FALSE && $cashbonds->accounted_approval == 'approved'){
                        if($cashbonds->remitter_bank)
                        {
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-cashbond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'" data-amount="'.number_format($cashbonds->amount).'" data-remitterBank="'.$cashbonds->remitter_bank->name.'">';
                            $actions_html .=    '<i class="fa fa-money"></i>';
                            $actions_html .='</button>&nbsp;';
                            $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-cashbond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'">';
                            $actions_html .=    '<i class="fa fa-cog" title="Click to approve this transfer task"></i>';
                            $actions_html .='</button>';
                        }
                        else{
                            $actions_html ='<button type="button" class="btn btn-info btn-xs btn-transfer-cashbond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'">';
                            $actions_html .=    '<i class="fa fa-money"></i>';
                            $actions_html .='</button>&nbsp;';
                            $actions_html .='<button type="button" class="btn btn-success btn-xs btn-approve-transfer-cashbond" data-id="'.$cashbonds->id.'" data-text="'.$cashbonds->code.'">';
                            $actions_html .=    '<i class="fa fa-cog" title="Click to approve this transfer task"></i>';
                            $actions_html .='</button>';
                        }
                        
                    }
                    else{

                    }
                   
                }
               
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_cashbonds->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_cashbonds->make(true);
    }


    //Cashbond Site datatables
    public function getCashbondSites(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles()->first()->code;
        
        $cashbond_sites = CashbondSite::with('user')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'cashbond_sites.*',
        ]);

        $data_cashbonds = Datatables::of($cashbond_sites)
            ->editColumn('user', function($cashbond_sites){
                if($cashbond_sites->user){
                    return $cashbond_sites->user->name;    
                }else{
                    return "";
                }
                
            })
            ->editColumn('amount', function($cashbond_sites){
                return number_format($cashbond_sites->amount, 2);
            })
            ->editColumn('accounted', function($cashbond_sites){
                return $cashbond_sites->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->editColumn('created_at', function($settlements){
                return jakarta_date_time($settlements->created_at);
            })
            ->addColumn('actions', function($cashbond_sites){
                    $actions_html ='<a href="'.url('cash-bond-site/'.$cashbond_sites->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-cash-bond-site" data-id="'.$cashbond_sites->id.'" data-text="'.$cashbond_sites->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_cashbonds->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_cashbonds->make(true);
    }
    //END Cashbond Site datatables



    public function getInvoiceTaxComparation(Request $request)
    {
        $yearmonth_array = [];
        $tax_month_from_invoice_customers = \DB::table('invoice_customers')
            ->select([
                \DB::raw('DATE_FORMAT(tax_date,"%Y-%m") AS tax_month'),
            ])
            ->where('tax_date','!=',"")
            ->distinct()
            ->get();
        foreach($tax_month_from_invoice_customers as $tmfic){
            array_push($yearmonth_array,
                ['tax_month'=>$tmfic->tax_month]
            );
        }

        $tax_month_from_invoice_vendors = \DB::table('invoice_vendors')
            ->select([
                \DB::raw('DATE_FORMAT(tax_date,"%Y-%m") AS tax_month'),
            ])
            ->where('tax_date','!=',"")
            ->distinct()
            ->get();

        foreach($tax_month_from_invoice_vendors as $tmfid){
            array_push($yearmonth_array,
                ['tax_month'=>$tmfid->tax_month]
            );
        }
        $results = array_map("unserialize", array_unique(array_map("serialize", $yearmonth_array)));

        $data_comparations = Datatables::of(collect($results))
        ->addColumn('rownum', function($results){
            return "#";
        })
        ->addColumn('tax_in', function($results){
            $tax_in_html  = '';
            $tax_in_html .= number_format($this->count_tax_in_from_date($results['tax_month']));
            $tax_in_html .= '<p>';
            $tax_in_html .=     '<a class="btn btn-xs btn-tax-in-detail" data-yearmonth="'.$results['tax_month'].'">';
            $tax_in_html .=         '<i class="fa fa-folder-open"></i>';
            $tax_in_html .=     '</a>';
            $tax_in_html .= '</p>';
            return $tax_in_html;
        })
        ->addColumn('tax_out', function($results){
            $tax_out_html  = '';
            $tax_out_html .= number_format($this->count_tax_out_from_date($results['tax_month']));
            $tax_out_html .= '<p>';
            $tax_out_html .=     '<a class="btn btn-xs btn-tax-out-detail" data-yearmonth="'.$results['tax_month'].'">';
            $tax_out_html .=         '<i class="fa fa-folder-open"></i>';
            $tax_out_html .=     '</a>';
            $tax_out_html .= '</p>';
            return $tax_out_html;
        })
        ->addColumn('credit', function($results){
            $yearmonth = $results['tax_month'];
            $dt = Carbon::parse($yearmonth);
            $prevMonth = $dt->subMonth()->format('Y-m');
            $prev_month_tax_in = $this->count_tax_in_from_date($prevMonth);
            $prev_month_tax_out = $this->count_tax_out_from_date($prevMonth);
            $prevMonthPayment = $prev_month_tax_in - $prev_month_tax_out;
            return number_format($prevMonthPayment);
        })
        ->addColumn('payment', function($results){
            $html = '';
            $yearmonth = $results['tax_month'];
            $dt = Carbon::parse($yearmonth);
            $prevMonth = $dt->subMonth()->format('Y-m');
            $prev_month_tax_in = $this->count_tax_in_from_date($prevMonth);
            $prev_month_tax_out = $this->count_tax_out_from_date($prevMonth);
            $prevMonthPayment = $prev_month_tax_in - $prev_month_tax_out;

            $tax_in = $this->count_tax_in_from_date($results['tax_month']);
            $tax_out = $this->count_tax_out_from_date($results['tax_month']);
            $payment = $tax_in - $tax_out;
            $html.='<p>'.number_format($prevMonthPayment).' (Previous)</p>';
            $html.='<p>'.number_format($payment).' (Current Month)</p>';
            $html.='<p>'.number_format($payment+$prevMonthPayment).' (Final)</p>';

            return  $html;
        });
        return $data_comparations->make(true);
    }

    public function count_tax_in_from_date($yearmonth){
        $invoice_vendor_taxes = InvoiceVendorTax::whereHas('invoice_vendor', function($query) use ($yearmonth){
            $query->where('invoice_vendors.tax_date', 'LIKE', "%$yearmonth%");
            $query->where('invoice_vendor_taxes.source', '=', "vat");
        })
        ->sum('amount');
        return $invoice_vendor_taxes;
    }

    public function count_tax_out_from_date($yearmonth){
        

        $invoice_customer_taxes = InvoiceCustomerTax::whereHas('invoice_customer', function($query) use ($yearmonth){
            $query->where('invoice_customers.tax_date', 'LIKE', "%$yearmonth%");
            $query->where('invoice_customer_taxes.source', '=', "vat");
        })
        ->sum('amount');
        return $invoice_customer_taxes;
    }


    //Invoice customer taxes from Caomparation Page
    public function getInvoiceCustomerTaxesFromTaxComparation(Request $request)
    {

        \DB::statement(\DB::raw('set @rownum=0'));
        if($request->param_yearmonth!=""){
            $invoice_customer_taxes = InvoiceCustomerTax::with('invoice_customer')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_customer_taxes.*',
            ])
            ->whereHas('invoice_customer', function($query) use($request){
                $query->where('tax_date', 'LIKE', "%$request->param_yearmonth%");
            })
            ->where('source', '=', 'vat');
        }
        else{
            $invoice_customer_taxes = InvoiceCustomerTax::with('invoice_customer', 'cash')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'invoice_customer_taxes.*',
            ])
            ->where('source', '=', 'vat');
        }
        

        $data_invoice_customer_taxes = Datatables::of($invoice_customer_taxes)
            ->editColumn('amount', function($invoice_customer_taxes){
                return number_format($invoice_customer_taxes->amount,2);
            })
            ->addColumn('tax_date', function($invoice_customer_taxes){
                return $invoice_customer_taxes->invoice_customer->tax_date;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_customer_taxes->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_customer_taxes->make(true);
    }
    //END Invoice customer taxes from Caomparation Page

    //Invoice vendor taxes from Caomparation Page
    public function getInvoiceVendorTaxesFromTaxComparation(Request $request)
    {

        \DB::statement(\DB::raw('set @rownum=0'));
        if($request->param_yearmonth!=""){
            $invoice_vendor_taxes = InvoiceVendorTax::with('invoice_vendor')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_vendor_taxes.*',
            ])
            ->whereHas('invoice_vendor', function($query) use($request){
                $query->where('tax_date', 'LIKE', "%$request->param_yearmonth%");
            })
            ->where('source', '=', 'vat');
        }
        else{
            $invoice_vendor_taxes = InvoiceVendorTax::with('invoice_vendor')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'invoice_vendor_taxes.*',
            ])
            ->where('source', '=', 'vat');
        }
        

        $data_invoice_vendor_taxes = Datatables::of($invoice_vendor_taxes)
            ->editColumn('amount', function($invoice_vendor_taxes){
                return number_format($invoice_vendor_taxes->amount,2);
            })
            ->addColumn('tax_date', function($invoice_vendor_taxes){
                return $invoice_vendor_taxes->invoice_vendor->tax_date;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_vendor_taxes->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_vendor_taxes->make(true);
    }
    //END Invoice vendor taxes from Caomparation Page


    


    public function getCashFlow(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $yearmonth_array = [];
        $yearmonth_from_invoice_customers = \DB::table('invoice_customers')
            ->select([
                \DB::raw('DATE_FORMAT(due_date,"%Y-%m") AS yearmonth'),
            ])
            ->where('due_date','!=',"")
            ->distinct()
            ->get();
        foreach($yearmonth_from_invoice_customers as $ymfic){
            /*array_push($yearmonth_array,
                ['year_month'=>$ymfic->yearmonth]
            );*/
            if(!in_array($ymfic->yearmonth, $yearmonth_array)){
                $yearmonth_array[] = $ymfic->yearmonth;    
            }
            
        }

        $yearmonth_from_invoice_vendors = \DB::table('invoice_vendors')
            ->select([
                \DB::raw('DATE_FORMAT(due_date,"%Y-%m") AS yearmonth'),
            ])
            ->where('due_date','!=',"")
            ->distinct()
            ->get();

        foreach($yearmonth_from_invoice_vendors as $ymfid){
            /*array_push($yearmonth_array,
                ['year_month'=>$ymfid->yearmonth]
            );*/
            if(!in_array($ymfid->yearmonth, $yearmonth_array)){
                $yearmonth_array[] = $ymfid->yearmonth;
            }
        }

        sort($yearmonth_array); 
        $results = collect($yearmonth_array);
        
        $data_cashflows = Datatables::of($results)
        ->addColumn('rownum', function($results){
            return '#';
        })
        ->addColumn('year_month', function($results){
            return $results;
        })
        ->addColumn('tot_invoice_customer', function($results){
            $tot_invoice_customer = '';
            $tot_invoice_customer .= number_format($this->total_invoice_customer_from_yearmonth($results));
            return $tot_invoice_customer;
        })
        ->addColumn('tot_invoice_vendor', function($results){
            $tot_invoice_vendor = '';
            $tot_invoice_vendor .= number_format($this->total_invoice_vendor_from_yearmonth($results));
            return $tot_invoice_vendor;
        })
        ->addColumn('difference', function($results){
            $tot_invoice_customer = $this->total_invoice_customer_from_yearmonth($results);
            $tot_invoice_vendor = $this->total_invoice_vendor_from_yearmonth($results);
            $diff = number_format($tot_invoice_customer - $tot_invoice_vendor);
            return $diff;
        })
        ->addColumn('cash_amount', function($results){
            $cash_amount = $this->getCashAmountOnYearMonth($results);
            return number_format($cash_amount);
        })
        ->addColumn('previous_cash', function($results){
            $previous_cash = $this->getPreviousCashAmountOnYearMonth($results);
            return number_format($previous_cash);
        })
        ->addColumn('estimation', function($results){
            $result = 0;
            $tot_invoice_customer = $this->total_invoice_customer_from_yearmonth($results);
            $tot_invoice_vendor = $this->total_invoice_vendor_from_yearmonth($results);
            $diff = $tot_invoice_customer - $tot_invoice_vendor;

            $cash_amount = $this->getCashAmountOnYearMonth($results);

            $previous_cash = $this->getPreviousCashAmountOnYearMonth($results);

            $result = $diff+$cash_amount+$previous_cash;
            return number_format($result);
        });


        return $data_cashflows->make(true);
    }


    public function total_invoice_customer_from_yearmonth($yearmonth = NULL)
    {
        
        $invoice_customers = InvoiceCustomer::where('due_date', 'LIKE', "%$yearmonth%")
        ->sum('amount');
        return $invoice_customers;
    }

    public function total_invoice_vendor_from_yearmonth($yearmonth = NULL)
    {
        
        $invoice_vendors = InvoiceVendor::where('due_date', 'LIKE', "%$yearmonth%")
        ->sum('amount');
        return $invoice_vendors;
    }

    public function getCashAmountOnYearMonth($yearmonth)
    {
        $result = 0;
        $debet = Transaction::where('cash_id', 2)
                ->where('type','debet')
                ->where('transaction_date', 'LIKE', "%$yearmonth%")
                ->sum('amount');
        $credit = Transaction::where('cash_id', 2)
                ->where('type','credit')
                ->where('transaction_date', 'LIKE', "%$yearmonth%")
                ->sum('amount');
        $result = $credit - $debet;
        return $result;
    }

    public function getPreviousCashAmountOnYearMonth($yearmonth)
    {
        $result = 0;
        $defined = Carbon::parse($yearmonth);
        $toSearch = $defined->subMonth()->format('Y-m');
        $count = Transaction::where('cash_id', 2)
                ->where('transaction_date', 'LIKE', "%$toSearch%")
                ->get()
                ->last();
        if($count){
            $result = $count->reference_amount;
        }
        return $result;
    }

    


    //Accounting Expenses datatables
    public function getAccountingExpense(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $accounting_expenses = AccountingExpense::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'accounting_expenses.*',
        ])->get();

        $data_accounting_expenses = Datatables::of($accounting_expenses)
          
            ->addColumn('actions', function($accounting_expenses){
                    $actions_html ='<a href="'.url('accounting-expense/'.$accounting_expenses->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('accounting-expense/'.$accounting_expenses->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this quotation">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-accounting-expense" data-id="'.$accounting_expenses->id.'" data-text="'.$accounting_expenses->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_accounting_expenses->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_accounting_expenses->make(true);
    }
    //END Accounting Expenses datatables

    //Payroll datatables
    public function getTransferTaskPayroll(Request $request)
    {   
        $grand_total = 5555555;
        \DB::statement(\DB::raw('set @rownum=0'));
        $payrolls = Payroll::with(['period', 'user'])->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'payrolls.*',
        ])
        ->where('payrolls.status','=','approved')
        ->where('payrolls.accounted','=',FALSE);

        if($request->get('filter_user_type')){
            $user_type = $request->get('filter_user_type');
            $payrolls->whereHas('user', function($q) use ($user_type){
                $q->where('users.type','=',$user_type);
            });
        }
        

        $data_payrolls = Datatables::of($payrolls)
            ->with('grand_total', $grand_total)
            ->editColumn('period_id', function($payrolls){
                return $payrolls ? $payrolls->period->code : NULL;
            })
            ->editColumn('user_id', function($payrolls){
                return $payrolls ? $payrolls->user->name : NULL;
            })
            ->editColumn('thp_amount', function($payrolls){
                return number_format($payrolls->thp_amount, 2);
            })
            ->editColumn('remitter_bank_id', function($payrolls){
                if($payrolls->remitter_bank){
                    return $payrolls->remitter_bank->name;
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('accounted', function($payrolls){
                return $payrolls->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($payrolls){
                    $actions_html ='<a href="'.url('payroll/'.$payrolls->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_payrolls->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_payrolls->make(true);
    }
    //END Payroll datatables
}
