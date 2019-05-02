<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Project;

class ReportController extends Controller
{
    public function project(Request $request)
    {
    	return view('report.project');
    }

    public function getDataProject(Request $request)
    {
    	/*
    	$string = '{
		  "cols": [
		        {"id":"","label":"Topping","pattern":"","type":"string"},
		        {"id":"","label":"Slices","pattern":"","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Mushrooms","f":null},{"v":3,"f":null}]},
		        {"c":[{"v":"Onions","f":null},{"v":1,"f":null}]},
		        {"c":[{"v":"Olives","f":null},{"v":1,"f":null}]},
		        {"c":[{"v":"Zucchini","f":null},{"v":1,"f":null}]},
		        {"c":[{"v":"Pepperoni","f":null},{"v":2,"f":null}]}
		      ]
		}';
		echo $string;
		*/
		$response['cols'] = [
			["id"=>"", "lable"=>"Topping", "pattern"=>"", "type"=>"string"],
			["id"=>"", "lable"=>"Slices", "pattern"=>"", "type"=>"number"],
		];
		$response['rows'] = [
			[
				"c"=>[
					["v"=>"Mushrooms", "f"=>null],
					["v"=>"3", "f"=>null],
				]

			],
			[
				"c"=>[
					["v"=>"Onions", "f"=>null],
					["v"=>"9", "f"=>null],
				]

			]
		];
		return response()->json($response);
    }
}
