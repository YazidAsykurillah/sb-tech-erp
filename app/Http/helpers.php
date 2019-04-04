<?php

use Carbon\Carbon;


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