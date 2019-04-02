<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cash;
use App\Transaction;

//User Maatwebsite Excel package
use Excel;

class ExporterController extends Controller
{
    public function exportCashTransaction(Request $request)
    {
    	//$cash = Cash::findOrFail($request->cash_id_to_export);

    	if($request->has('exporter_type')){
    		if($request->exporter_type == 'annual'){
    			return $this->exportCashTransactionAnnual($request);
    		}elseif($request->exporter_type == 'monthly'){
    			return $this->exportCashTransactionMonthly($request);
    		}else{
    			return $this->exportCashTransactionFull($request);
    		}
    	}else{
    		return redirect()->back()
    			->with('errorMessage', "Please select Export type");
    	}
        
        /*$data = Transaction::select('cash_id','refference','refference_id','refference_number','type', 'amount', 'notes', 'transaction_date')->where('cash_id',$cash->id)->get();
        return Excel::create('transaction_report_'.$cash->name.'', function($excel) use ($data) {
            $excel->sheet('Sheet-01', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download('xlsx');*/
    }

    protected function exportCashTransactionAnnual($request)
    {
        $dataExport = [];

    	$cash = Cash::findOrFail($request->cash_id_to_export);
    	$data = Transaction::select('cash_id','refference','refference_id','refference_number','type', 'amount', 'notes', 'transaction_date')
    			->where('cash_id',$cash->id)
    			->where('transaction_date', 'like', "%$request->year%")
    			->get()->toArray();

        foreach($data as $key=>$value){
            $dataExport[$key]['cash_id'] = $data[$key]['cash_id'];
            $dataExport[$key]['refference'] = $data[$key]['refference'];
            $dataExport[$key]['refference_id'] = $data[$key]['refference_id'];
            $dataExport[$key]['refference_number'] = $data[$key]['refference_number'];
            $dataExport[$key]['type'] = $data[$key]['type'];
            $dataExport[$key]['amount'] = $data[$key]['amount'];
            if($data[$key]['type'] == 'credit'){
                $dataExport[$key]['credit'] = $data[$key]['amount'];
                $dataExport[$key]['debit'] = '';
            }else{
                $dataExport[$key]['credit'] = '';
                $dataExport[$key]['debit'] = $data[$key]['amount'];
            }
            $dataExport[$key]['notes'] = $data[$key]['notes'];
            $dataExport[$key]['transaction_date'] = $data[$key]['transaction_date'];
            
        }

        return Excel::create($request->year.'_annual_transaction_report_'.$cash->name.'', function($excel) use ($dataExport) {
            $excel->sheet('Sheet-01', function($sheet) use ($dataExport)
            {
                $sheet->fromArray($dataExport);
            });
        })->download('xlsx');
    }

    protected function exportCashTransactionMonthly($request)
    {
        $dataExport = [];

    	$cash = Cash::findOrFail($request->cash_id_to_export);
    	$year_month = $request->year.'-'.$request->month;
    	$data = Transaction::select('cash_id','refference','refference_id','refference_number','type', 'amount', 'notes', 'transaction_date')
    			->where('cash_id',$cash->id)
    			->where('transaction_date', 'like', "%$year_month%")
    			->get()->toArray();

        foreach($data as $key=>$value){
            $dataExport[$key]['cash_id'] = $data[$key]['cash_id'];
            $dataExport[$key]['refference'] = $data[$key]['refference'];
            $dataExport[$key]['refference_id'] = $data[$key]['refference_id'];
            $dataExport[$key]['refference_number'] = $data[$key]['refference_number'];
            $dataExport[$key]['type'] = $data[$key]['type'];
            $dataExport[$key]['amount'] = $data[$key]['amount'];
            if($data[$key]['type'] == 'credit'){
                $dataExport[$key]['credit'] = $data[$key]['amount'];
                $dataExport[$key]['debit'] = '';
            }else{
                $dataExport[$key]['credit'] = '';
                $dataExport[$key]['debit'] = $data[$key]['amount'];
            }
            $dataExport[$key]['notes'] = $data[$key]['notes'];
            $dataExport[$key]['transaction_date'] = $data[$key]['transaction_date'];
            
        }

        return Excel::create($request->year.'-'.$request->month.'_monthly_transaction_report_'.$cash->name.'', function($excel) use ($dataExport) {
            $excel->sheet('Sheet-01', function($sheet) use ($dataExport)
            {
                $sheet->fromArray($dataExport);
            });
        })->download('xlsx');
    }

    protected function exportCashTransactionFull($request)
    {
        $dataExport = [];
    	$cash = Cash::findOrFail($request->cash_id_to_export);
    	$data = Transaction::select('cash_id','refference','refference_id','refference_number','type', 'amount', 'notes', 'transaction_date')->where('cash_id',$cash->id)->get()->toArray();
        foreach($data as $key=>$value){
            $dataExport[$key]['cash_id'] = $data[$key]['cash_id'];
            $dataExport[$key]['refference'] = $data[$key]['refference'];
            $dataExport[$key]['refference_id'] = $data[$key]['refference_id'];
            $dataExport[$key]['refference_number'] = $data[$key]['refference_number'];
            $dataExport[$key]['type'] = $data[$key]['type'];
            $dataExport[$key]['amount'] = $data[$key]['amount'];
            if($data[$key]['type'] == 'credit'){
                $dataExport[$key]['credit'] = $data[$key]['amount'];
                $dataExport[$key]['debit'] = '';
            }else{
                $dataExport[$key]['credit'] = '';
                $dataExport[$key]['debit'] = $data[$key]['amount'];
            }
            $dataExport[$key]['notes'] = $data[$key]['notes'];
            $dataExport[$key]['transaction_date'] = $data[$key]['transaction_date'];
            
        }
        /*echo '<pre>';
        print_r($dataExport);        
        echo '</pre>';
        exit();*/
        return Excel::create('full_transaction_report_'.$cash->name.'', function($excel) use ($dataExport) {
            $excel->sheet('Sheet-01', function($sheet) use ($dataExport)
            {
                $sheet->fromArray($dataExport);
            });
        })->download('xlsx');
    }
}
