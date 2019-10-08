<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Project;
use App\Period;

use App\InvoiceVendor;
use App\InvoiceCustomer;

use App\InvoiceVendorTax;
use App\InvoiceCustomerTax;

use App\Transaction;

class ReportController extends Controller
{
    public function project(Request $request)
    {
    	return view('report.project');
    }

    public function getDataProject(Request $request)
    {
		$response['cols'] = [
			["id"=>"", "lable"=>"Topping", "pattern"=>"", "type"=>"string"],
			["id"=>"", "lable"=>"Slices", "pattern"=>"", "type"=>"number"],
		];
		$response['rows'] = [
			[
				"c"=>[
					["v"=>"January", "f"=>null],
					["v"=>"3", "f"=>null],
				]

			],
			[
				"c"=>[
					["v"=>"February", "f"=>null],
					["v"=>"9", "f"=>null],
				]

			],
			[
				"c"=>[
					["v"=>"March", "f"=>null],
					["v"=>"12", "f"=>null],
				]

			]
		];
		return response()->json($response);
    }

    public function ppn(Request $request)
    {
    	return view('report.ppn');

    }


    public function getDataPpn(Request $request)
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
        ->addColumn('credit', function($results){
            $html_credit = '';
            $yearmonth = $results['tax_month'];
            $dt = Carbon::parse($yearmonth);
            $prevMonth = $dt->subMonth()->format('Y-m');
            $prev_month_tax_in = $this->count_tax_in_from_date($prevMonth);
            $prev_month_tax_out = $this->count_tax_out_from_date($prevMonth);
            
            //$prevMonthPayment = $prev_month_tax_in - $prev_month_tax_out;
            $prevMonthPayment = $prev_month_tax_out - $prev_month_tax_in;

            $tax_in = $this->count_tax_in_from_date($results['tax_month']);
            $tax_out = $this->count_tax_out_from_date($results['tax_month']);
            $credit_amount = 0;
            $credit = $tax_out-$tax_in;
            if($credit < 0){
                $credit_amount = $credit;
            }
            $html_credit .='<p>'.number_format($credit_amount).'</p>';
            return  $html_credit;
        })
        ->addColumn('payment', function($results){
            $html = '';
            $yearmonth = $results['tax_month'];
            $dt = Carbon::parse($yearmonth);
            $prevMonth = $dt->subMonth()->format('Y-m');
            $prev_month_tax_in = $this->count_tax_in_from_date($prevMonth);
            $prev_month_tax_out = $this->count_tax_out_from_date($prevMonth);
            
            //$prevMonthPayment = $prev_month_tax_in - $prev_month_tax_out;
            $prevMonthPayment = $prev_month_tax_out - $prev_month_tax_in;

            $tax_in = $this->count_tax_in_from_date($results['tax_month']);
            $tax_out = $this->count_tax_out_from_date($results['tax_month']);
            //$payment = $tax_in - $tax_out;
            $payment = $tax_out-$tax_in;
            $html .='<p>'.number_format($payment).'</p>';
            $html .='<p>';
            $html .=    '<a class="btn btn-info btn-xs btn-payment" href="javascript::void()">';
            $html .=        'Bayar';
            $html .=    '</a>';
            $html .='</p>';

            return  $html;
        });
        return $data_comparations->make(true);
    }

    public function count_tax_out_from_date($yearmonth){
        $invoice_customer_taxes = InvoiceCustomerTax::whereHas('invoice_customer', function($query) use ($yearmonth){
            $query->where('invoice_customers.tax_date', 'LIKE', "%$yearmonth%");
            $query->where('invoice_customer_taxes.source', '=', "vat");
            $query->where('invoice_customer_taxes.tax_number', 'NOT LIKE', "0000%");
        })
        ->sum('amount');
        return $invoice_customer_taxes;
    }

    public function count_tax_in_from_date($yearmonth){
        $invoice_vendor_taxes = InvoiceVendorTax::whereHas('invoice_vendor', function($query) use ($yearmonth){
            $query->where('invoice_vendors.tax_date', 'LIKE', "%$yearmonth%");
            $query->where('invoice_vendor_taxes.source', '=', "vat");
            $query->where('invoice_vendor_taxes.tax_number', 'NOT LIKE', "0000%");
        })
        ->sum('amount');
        return $invoice_vendor_taxes;
    }


    //Block TAX FLOW
    public function taxFlow(Request $request)
    {
        if($request->has('year')){
            $year = $request->year;
            $predictive_taxflow_data = $this->buildPredictiveTaxFlowData($year);
            return view('report.tax-flow-annual')
                ->with('year', $year)
                ->with('predictive_taxflow_data', $predictive_taxflow_data);
                //test commit
        }
        else{
            $years = [];
            for ($i=2016; $i <2025 ; $i++) { 
                $years[]=$i;
            }
            return view('report.tax-flow')
                ->with('years', $years); 
        }
        
    }

    protected function count_tax_credit_from_yearmonth($ym)
    {
        $result = 0;
        $tax_out = InvoiceCustomerTax::countTotalByYearMonth($ym);
        $tax_in = InvoiceVendorTax::countTotalByYearMonth($ym);
        $credit = $tax_out-$tax_in;
        if($credit < 0){
            $result = $credit;
        }
        return $result;
    }

    protected function buildPredictiveTaxFlowData($year)
    {
        $result = [];
        $year_month_list = $this->buildYearMonthList($year);
        foreach ($year_month_list as $ym) {
            $tax_out = InvoiceCustomerTax::countTotalByYearMonth($ym);
            $tax_in = InvoiceVendorTax::countTotalByYearMonth($ym);
            array_push($result, 
                [
                    'year_month'=>$ym,
                    'tax_out'=>number_format($tax_out),
                    'tax_in'=>number_format($tax_in),
                    'credit'=>number_format($this->count_tax_credit_from_yearmonth($ym)),
                ]
            );
        }
        return $result;
    }

    //Block Cash FLOW
    public function cashFlow(Request $request)
    {
        if($request->has('year')){
            $year = $request->year;
            $predictive_cashflow_data = $this->buildPredictiveCashFlowData($year);
            $actual_cashflow_data = $this->buildActualCashFlowData($year);
            return view('report.cash-flow-annual')
                ->with('year', $year)
                ->with('predictive_cashflow_data', $predictive_cashflow_data)
                ->with('actual_cashflow_data', $actual_cashflow_data);
                //test commit
        }
        else{
            $years = [];
            for ($i=2016; $i <2025 ; $i++) { 
                $years[]=$i;
            }
            return view('report.cash-flow')
                ->with('years', $years); 
        }
        
    }

    protected function buildPredictiveCashFlowData($year)
    {
        $result = [];
        $year_month_list = $this->buildYearMonthList($year);
        foreach ($year_month_list as $ym) {
            $cash_out = InvoiceVendor::countTotalByYearMonth($ym);
            $cash_in = InvoiceCustomer::countTotalByYearMonth($ym);
            array_push($result, 
                [
                    'year_month'=>$ym,
                    'cash_out'=>number_format($cash_out),
                    'cash_in'=>number_format($cash_in),
                    'balance'=>number_format($cash_in-$cash_out),
                ]
            );
        }
        return $result;
    }

    protected function buildActualCashFlowData($year)
    {
        $result = [];
        $year_month_list = $this->buildYearMonthList($year);
        foreach ($year_month_list as $ym) {
            $cash_out = Transaction::where('type','=', 'debet')
                    ->where('transaction_date', 'LIKE', "%$ym%")
                    ->sum('amount');
            $cash_in = Transaction::where('type','=', 'credit')
                    ->where('transaction_date', 'LIKE', "%$ym%")
                    ->sum('amount');
            array_push($result, 
                [
                    'year_month'=>$ym,
                    'cash_out'=>number_format($cash_out),
                    'cash_in'=>number_format($cash_in),
                    'balance'=>number_format($cash_in-$cash_out),
                ]
            );
        }
        return $result;
    }
    

    //Return Yer-month list
    protected function buildYearMonthList($year)
    {
        $year_month_list =[
            $year.'-01',
            $year.'-02',
            $year.'-03',
            $year.'-04',
            $year.'-05',
            $year.'-06',
            $year.'-07',
            $year.'-08',
            $year.'-09',
            $year.'-10',
            $year.'-11',
            $year.'-12',
        ];
        return $year_month_list;
    }
}
