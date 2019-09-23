<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
    	$tasks = Task::all();
    	return response()->json($tasks);
    }
}
