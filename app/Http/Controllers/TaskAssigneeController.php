<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Requests\StoreTaskAssigneeRequest;

use App\TaskAssignee;

class TaskAssigneeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getDataPerTask(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $task_assignees = TaskAssignee::with('user')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'task_assignees.*',
        ])->where('task_id','=',$request->task_id);

        $data = Datatables::of($task_assignees)
            ->addColumn('user_name', function($task_assignees){
                return $task_assignees->user->name;
            })
            ->addColumn('actions', function($task_assignees){
                    $actions_html ='<a href="'.url('task-assignee/'.$task_assignees->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskAssigneeRequest $request)
    {
        $taskAssignee = new TaskAssignee;
        $taskAssignee->task_id = $request->task_id;
        $taskAssignee->user_id = $request->user_id;
        $taskAssignee->working_hour = $request->working_hour;
        $taskAssignee->save();
        return response()->json(['success'=>TRUE, 'data'=>$taskAssignee]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //Block Select2 Users
    public function select2User(Request $request)
    {   

        $data = [];
        if($request->has('q')){
            $data = \DB::table("users")
                ->select("id","name")
                ->where('name','LIKE',"%$search%")
                ->get();
        }
        else{
            $data = \DB::table("users")
                    ->select("id","name")
                    ->get();
            
        }
        return response()->json($data);
    }
    //ENDBlock Select2 Users
}
