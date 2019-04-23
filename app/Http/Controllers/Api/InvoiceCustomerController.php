<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\InvoiceCustomer;

class InvoiceCustomerController extends Controller
{

    public function index(Request $request)
    {
    	return response()->json($request->all());
    }
}
