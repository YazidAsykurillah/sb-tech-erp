<?php

use Carbon\Carbon;

use App\Period;

function jakarta_date_time($date_time = NULL)
{	
	if(is_null($date_time)){
		return NULL;
	}
	else{
		$the_date = Carbon::createFromFormat('Y-m-d H:i:s', $date_time);
		$the_date->setTimezone('Asia/Jakarta');
		return $the_date;
	}
	
}

if(!function_exists('asset_type_display')){
	function asset_type_display($type = NULL){
		$display = "";
		if($type!=NULL){
			switch ($type) {
				case 'current':
					$display = "Lancar";
					break;
				case 'fixed':
					$display = "Tetap";
					break;
				case 'intangible':
					$display = "Tidak Berwujud";
					break;
				default:
					# code...
					break;
			}
		}
		return "Activa ".$display;
	}
}

if(!function_exists('generate_date_range')){
	function generate_date_range(Carbon $start_date, Carbon $end_date)
	{
	    $dates = [];
	    for($date = $start_date; $date->lte($end_date); $date->addDay()) {
	        $dates[] = $date->format('Y-m-d');
	    }
	    return $dates;

	}
}

if(!function_exists('get_day_name')){
	function get_day_name($input){
		$date = Carbon::parse($input);
		return $date->format('l');

	}
}

if(!function_exists('is_date_weekend')){
	function is_date_weekend($input){
		$date = Carbon::parse($input);
		return $date->isWeekend();
	}
}


//get current period based on now date

if(!function_exists('current_period')){
	function current_period(){
		$result = [];
		$now = Carbon::now();
		$current_year = $now->format('Y');
		$current_month = $now->format('m');
		$current_date = $now->format('d');
		
		//get last and next month
		$last_month = $now->subMonth()->format('F');
		$next_month = $now->addMonth()->format('F');
		return $next_month;
	}
}