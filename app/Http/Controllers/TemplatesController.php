<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TemplatesController extends Controller
{
    public function index()
    {
    	return view('templates.index');
    }

    public function download(Request $request)
    {
    	$file_name = $request->file_name;


        if($file_name == 'ets_office'){
            $pathToFile = public_path().'/files/templates/ets-office.xlsx';
            return response()->download($pathToFile, 'Template-ETS-OFFICE.xlsx');
        }
        else{
            $pathToFile = public_path().'/files/templates/ets-site.xlsx';
            return response()->download($pathToFile, 'Template-ETS-SITE.xlsx');    
        }
    	
    }
}
