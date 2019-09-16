<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAssignee extends Model
{
    protected $table = 'task_assignees';

    protected $fillable = [
    	'task_id', 'user_id', 'working_hour', 'description'
    ];

    public function task()
    {
    	return $this->belongsTo('App\Task');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
