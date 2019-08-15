<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Requests\StoreTaskRequest;

use App\Task;
use App\Project;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('task.index');
    }

    //return dataTables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $tasks = Task::with('project', 'pic')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'tasks.*',
        ]);

        $data = Datatables::of($tasks)
            ->editColumn('project.name', function($tasks){
                $project = NULL;
                if($tasks->project){
                    $project = $tasks->project->code.'<br/>';
                    $project .= $tasks->project->name;
                }
                return $project;
                
            })
            ->addColumn('actions', function($tasks){
                    $actions_html ='<a href="'.url('task/'.$tasks->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('task/'.$tasks->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this task">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-task" data-id="'.$tasks->id.'" data-text="'.$tasks->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                    

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
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $task = new Task;
        $task->project_id = $request->project_id;
        $task->user_id = $request->user_id;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->save();
        return redirect('task')
            ->with('successMessage', 'Task has been saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        $pic = $task->pic ? $task->pic : NULL;
        $project = $task->project ? $task->project : NULL;
        return view('task.show')
            ->with('task', $task)
            ->with('project', $project)
            ->with('pic', $pic);
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

    //Select Project
    public function select2Project(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("projects")
                    ->where('projects.code','LIKE',"%$search%")
                    ->where('projects.enabled','=',TRUE)
                    ->get();
        }
        else{
            $data = \DB::table('projects')
                    ->where('projects.enabled','=',TRUE)
                    ->get();
        }
        return response()->json($data);
    }

    //Select User
    public function select2User(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("users")
                    ->where('users.name','LIKE',"%$search%")
                    ->get();
        }
        else{
            $data = \DB::table('users')
                    ->get();
        }
        return response()->json($data);
    }
}
