<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\User;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('delivery-order.index');
    }

    //Datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        if(\Auth::user()->can('index-user-office') && \Auth::user()->can('index-user-outsource')){
            $users = User::with('roles')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*'
            ]);    
        }else if(\Auth::user()->can('index-user-outsource')){
            $users = User::with('roles')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*'
            ])
            ->where('users.type', '=', 'outsource');
        }
        else{
            $users = User::with('roles')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*'
            ]);
        }
        
        $data_users = Datatables::of($users)
            ->editColumn('salary', function($users){
                return number_format($users->salary);
            })
            ->editColumn('work_activation_date', function($users){
                $wad = "";
                if($users->work_activation_date!=NULL){
                    $wad = Carbon::parse($users->work_activation_date)->format('Y');
                }
                return $wad;
            })
            ->addColumn('roles', function (User $user) {
                    return $user->roles->map(function($role) {
                        return str_limit($role->name, 30, '...');
                    })->implode('<br>');
            })
            ->editColumn('status', function($users){
                if($users->status == 'active'){
                    return '<i class="fa fa-check"></i>';
                }
            })
            ->addColumn('actions', function($users){
                    $actions_html ='<a href="'.url('user/'.$users->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('user/'.$users->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this user">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-user" data-id="'.$users->id.'" data-text="'.$users->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_users->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_users->make(true);
    }
    //END Datatables

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
    public function store(Request $request)
    {
        //
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
}
