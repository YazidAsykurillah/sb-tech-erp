<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
    	'project_id', 'user_id', 'name', 'description', 'start_date_schedule', 'finish_date_schedule', 'status'
    ];

    
    //###
    //Block Relation with other models
    //###

    //Project
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    //PIC
    public function pic()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    //###
    //ENDBlock Relation with other models
    //###
}
