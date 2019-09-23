<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FrontEndController extends Controller
{
    public function getTaskList(Request $request)
    {
    	return view('front-end.task-list');
    }
}
