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