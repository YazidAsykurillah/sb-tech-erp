<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ComparationController extends Controller
{
    public function invoiceTax(Request $request)
    {
    	return view('comparation.invoice_tax');
    }
}
