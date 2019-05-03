<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Project;
use App\Period;
use App\InvoiceCustomerTax;
use App\InvoiceVendorTax;

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
            $html.='<p>'.number_format($prevMonthPayment).' (Credit)</p>';
            $html.='<p>'.number_format($payment).' (Current Month)</p>';
            $html.='<p>'.number_format($payment-$prevMonthPayment).' (Total)</p>';

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
}
