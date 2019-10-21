<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreQuotationCustomerRequest;
use App\Http\Requests\UpdateQuotationCustomerRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\QuotationCustomer;
use App\Customer;
use App\User;

class QuotationCustomerController extends Controller
{
   
    protected $quotation_customer_file_to_insert = NULL;
    protected $quotation_customer_file_to_delete = '';

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quotation-customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer_opts = Customer::lists('name', 'id');
        $sales_opts = User::lists('name', 'id');
        return view('quotation-customer.create')
            ->with('sales_opts', $sales_opts)
            ->with('customer_opts', $customer_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    

    //File upload handling process
    protected function upload_process(Request $request){
        
        $file = $request->file('file');
        $upload_directory = public_path().'/files/quotation-customer/';
        $extension = $request->file('file')->getClientOriginalExtension();
        $this->quotation_customer_file_to_insert = time().'_'.$file->getClientOriginalName();

        //now move the uploaded file
        $file->move($upload_directory, $this->quotation_customer_file_to_insert);
        
    }
    //ENDFile upload handling process
    public function store(StoreQuotationCustomerRequest $request)
    {
        $app_name = config('app.name');
        
        if($request->hasFile('file')){
            $this->upload_process($request);
        }
        //Block build next quotation_customer code
        //2017-06-13
        $today = date('Y-m-d');
        
        $this_month = substr($today, 0, 7);
        $suffix = "BMKN-QC";
        if($app_name == 'BMN Accounting'){
            $suffix = "BMN-SPH";
        }
        $qc_format = "$suffix-".substr($this_month, 2, 2)."-".substr($this_month, 5, 2)."-";
        
        $next_quotation_customer_number = "";
        $quotation_customers = \DB::table('quotation_customers')->where('created_at', 'like', "%$this_month%");
        //if counted quotation customers created in this month is 0, simply make it 001 to the next quotation customer number param.
        if($quotation_customers->count() == 0){
            $next_quotation_customer_number = str_pad(1, 3, 0, STR_PAD_LEFT);
        }
        else{
            $max = $quotation_customers->max('code');
            $int_max = ltrim(substr($max, -3), '0');
            $next_quotation_customer_number = str_pad(($int_max+1), 3, 0, STR_PAD_LEFT);
            
        }
        //error handling check for duplication
        $qc_number_to_insert = $this->check_for_duplication($qc_format, $next_quotation_customer_number);

        $quotation_customer = new QuotationCustomer;
        $quotation_customer->code = $qc_number_to_insert;
        $quotation_customer->customer_id = $request->customer_id;
        $quotation_customer->sales_id = $request->sales_id;
        $quotation_customer->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $quotation_customer->description = $request->description;
        $quotation_customer->file = $this->quotation_customer_file_to_insert;
        $quotation_customer->save();
        $last_id = $quotation_customer->id;
        return redirect('quotation-customer/'.$last_id)
            ->with('successMessage', "Quotation Customer has been created");
    }

    protected function check_for_duplication($qc_format, $qc_num_to_check){
        //echo $qc_format.$qc_num_to_check;

        $result = "";
        $check = \DB::table('quotation_customers')->where('code', '=', $qc_format.$qc_num_to_check)->first();
        if($check){
            $int_qc_num_to_check = intval($qc_num_to_check);
            $result = $qc_format.str_pad(($int_qc_num_to_check+1), 3, 0, STR_PAD_LEFT);
        }
        else{
            $result = $qc_format.$qc_num_to_check;
            
        }
        return $result;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation_customer = QuotationCustomer::findOrFail($id);
            return view('quotation-customer.show')
            ->with('quotation_customer', $quotation_customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation_customer = QuotationCustomer::findOrFail($id);
        $customer_opts = Customer::lists('name', 'id');
        $sales_opts = User::lists('name', 'id');
        return view('quotation-customer.edit')
            ->with('quotation_customer', $quotation_customer)
            ->with('customer_opts', $customer_opts)
            ->with('sales_opts', $sales_opts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuotationCustomerRequest $request, $id)
    {
        $quotation_customer = QuotationCustomer::findOrFail($id);

        if($request->hasFile('file')){
            //if there is an uploaded file, fire the upload process,set the new profile picture name
            // and collect this profile picture name (to be deleted from the server).
            $this->upload_process($request);
            $this->quotation_customer_file_to_delete = $quotation_customer->file;
        }
        else{
            //no file uploaded, it means the profile picture name stays still
            $this->quotation_customer_file_to_insert = $quotation_customer->file;
        }

        $quotation_customer->customer_id = $request->customer_id;
        $quotation_customer->sales_id = $request->sales_id;
        $quotation_customer->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $quotation_customer->description = $request->description;
        $quotation_customer->file = $this->quotation_customer_file_to_insert;
        $quotation_customer->save();

        //delete old quotation_customer file
        \File::delete(public_path().'/files/quotation-customer/'.$this->quotation_customer_file_to_delete);
        
        return redirect('quotation-customer/'.$id)
            ->with('successMessage', "Quotation Customer has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $quotation_customer = QuotationCustomer::findOrFail($request->quotation_customer_id);
        $quotation_customer->delete();
        return redirect('quotation-customer')
            ->with('successMessage', "Quotation customer has been removed");
    }


    public function setSubmittedQuotationCustomer(Request $request)
    {
        $quotation_customer = QuotationCustomer::findOrFail($request->quotation_customer_id);
        $quotation_customer->status = 'submitted';
        $quotation_customer->submitted_date = date('Y-m-d');
        $quotation_customer->save();
        return redirect('quotation-customer/'.$request->quotation_customer_id)
            ->with('successMessage', "Quotation Customer has been marked as Submitted");
    }


    

    public function getCustomerFromQuotationOrderCustomer(Request $request)
    {
        $quotation_customer = QuotationCustomer::findOrFail($request->quotation_customer_id);
        $customer_id = $quotation_customer->customer_id;
        $customer = Customer::findOrFail($customer_id);
        return json_encode($customer);
    }


    public function uploadFile(Request $request)
    {
        $quotation_customer = QuotationCustomer::findOrFail($request->id);
        if($request->hasFile('file')){
            //if there is an uploaded file, fire the upload process,set the new profile picture name
            // and collect this profile picture name (to be deleted from the server).
            $this->upload_process($request);
            $this->quotation_customer_file_to_delete = $quotation_customer->file;
        }
        else{
            //no file uploaded, it means the profile picture name stays still
            $this->quotation_customer_file_to_insert = $quotation_customer->file;
        }
        $quotation_customer->file = $this->quotation_customer_file_to_insert;
        $quotation_customer->save();
        //delete old quotation_customer file
        \File::delete(public_path().'/files/quotation-customer/'.$this->quotation_customer_file_to_delete);
        return redirect()->back()
            ->with('successMessage', "File has been uploaded");


    }

    public function downloadFile(Request $request)
    {
        $header = array();
        $file_name = $request->file_name;
        $pathToFile = public_path().'/files/quotation-customer/'.$file_name;
        
        $extension = \File::extension($pathToFile);
        if($extension == 'pdf'){
            $header = array('application/pdf');
            return response()->file($pathToFile, $header);
        }
        else if($extension == 'doc' || $extension == 'docx' || $extension == 'xlsx'){
            return response()->download($pathToFile);
        }
        else if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png'){
            return response()->file($pathToFile);
        }
        else{
            echo "File not found";
        }
        
    }

    public function deleteFile(Request $request){
        $quotation_customer = QuotationCustomer::findOrFail($request->id);
        if($quotation_customer->file !=NULL){
            $old_file = $quotation_customer->file;
            $pathToFile = public_path().'/files/quotation-customer/'.$old_file;
            //Delete the file on the server, first
            \File::delete($pathToFile);
            //now update the quotation_customer_file to NULL;
            $quotation_customer->file = NULL;
            $quotation_customer->save();
            return redirect('quotation-customer/'.$request->id)
                ->with('successMessage', "Quotation file has been deleted");

        }else{
            return redirect()->back();
        }

    }


    //Quotation Customer dataTables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM' || $user_role=='FIN'){
            $quotation_customers = QuotationCustomer::with('customer', 'sales', 'po_customer')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'quotation_customers.*',
            ]);
        }
        else{
            $quotation_customers = QuotationCustomer::with('customer', 'sales', 'po_customer')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'quotation_customers.*',
            ])
            ->where('sales_id', '=', \Auth::user()->id);
        }

        $data_quotation_customers = Datatables::of($quotation_customers)
            ->editColumn('customer', function($quotation_customers){
                return $quotation_customers->customer ? $quotation_customers->customer->name : null;
            })
            ->editColumn('sales', function($quotation_customers){
                if($quotation_customers->sales){
                    return $quotation_customers->sales->name;
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('amount', function($quotation_customers){
                return number_format($quotation_customers->amount, 2);
            })
            ->editColumn('description', function($quotation_customers){
              return substr($quotation_customers->description, 0, 30)."....<p><i>[Click detail icon for more information]</i></p>";
            })
            ->editColumn('created_at', function($quotation_customers){
                return jakarta_date_time($quotation_customers->created_at);
            })
            ->editColumn('po_customer_code', function($quotation_customers){
                if($quotation_customers->po_customer){
                    return $quotation_customers->po_customer->code;
                }else{
                    return NULL;
                }
            })
            ->addColumn('actions', function($quotation_customers){
                    $actions_html ='<a href="'.url('quotation-customer/'.$quotation_customers->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('quotation-customer/'.$quotation_customers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this quotation">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-quotation-customer" data-id="'.$quotation_customers->id.'" data-text="'.$quotation_customers->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_quotation_customers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_quotation_customers->make(true);
    }
    //END Quotation Customer dataTables
}
