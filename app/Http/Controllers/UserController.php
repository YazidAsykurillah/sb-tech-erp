<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\InputTimeReportUserRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\User;
use App\Role;
use App\TimeReport;
use App\Period;
use App\Leave;

class UserController extends Controller
{

    protected $user_profile_picture = NULL;
    protected $user_profile_picture_to_delete = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_options = Role::lists('name', 'id');
        return view('user.create')
            ->with('role_options', $role_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if($request->hasFile('image')){
            $this->upload_process($request);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password ? bcrypt($request->password) : bcrypt('bmkn');
        $user->nik = $request->number_id;
        $user->type = $request->type;
        $user->work_activation_date = $request->work_activation_date;
        $user->position = $request->position;
        $user->salary = floatval(preg_replace('#[^0-9.]#', '', $request->salary));
        $user->eat_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->eat_allowance));
        $user->eat_allowance_non_local = floatval(preg_replace('#[^0-9.]#', '', $request->eat_allowance_non_local));
        $user->transportation_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->transportation_allowance));
        $user->transportation_allowance_non_local = floatval(preg_replace('#[^0-9.]#', '', $request->transportation_allowance_non_local));
        $user->medical_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->medical_allowance));
        $user->incentive_week_day = floatval(preg_replace('#[^0-9.]#', '', $request->incentive_week_day));
        $user->incentive_week_end = floatval(preg_replace('#[^0-9.]#', '', $request->incentive_week_end));
        $user->bpjs_tk = floatval(preg_replace('#[^0-9.]#', '', $request->bpjs_tk));
        $user->bpjs_ke = floatval(preg_replace('#[^0-9.]#', '', $request->bpjs_ke));

        $user->profile_picture = $this->user_profile_picture;
        $user->save();

        $user_id = $user->id;
        //attach role for this user
        $saved_user = User::find($user_id);
        $saved_user->roles()->attach($request->role_id);
        return redirect('user/'.$user_id)
            ->with('successMessage', "Member $saved_user->name has been registered");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        //lock cheking
        $checker = \DB::table('lock_configurations')->select('user_id')
                ->where('facility_name', '=', 'create_internal_request')
                ->where('user_id','=', $user->id)
                ->get();
        $lock_create_internal_request = count($checker);
        return view('user.show')
            ->with('lock_create_internal_request', $lock_create_internal_request)
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role_options = Role::lists('name', 'id');
        return view('user.edit')
            ->with('role_options', $role_options)
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        //dd($request->has_workshop_allowance);


        if($request->hasFile('image')){
            //if there is an uploaded image, fire the upload process,set the new profile picture name
            // and collect this profile picture name (to be deleted from the server).
            $this->upload_process($request);
            $this->user_profile_picture_to_delete = $user->profile_picture;
        }
        else{
            //no image uploaded, it means the profile picture name stays still
            $this->user_profile_picture = $user->profile_picture;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->nik = $request->number_id;
        $user->type = $request->type;
        $user->work_activation_date = $request->work_activation_date;
        $user->salary = floatval(preg_replace('#[^0-9.]#', '', $request->salary));
        $user->man_hour_rate = floatval(preg_replace('#[^0-9.]#', '', $request->man_hour_rate));
        $user->eat_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->eat_allowance));
        $user->eat_allowance_non_local = floatval(preg_replace('#[^0-9.]#', '', $request->eat_allowance_non_local));
        $user->transportation_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->transportation_allowance));
        $user->transportation_allowance_non_local = floatval(preg_replace('#[^0-9.]#', '', $request->transportation_allowance_non_local));
        $user->medical_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->medical_allowance));
        if($request->has_workshop_allowance =='on'){
            $user->has_workshop_allowance = TRUE;
            $user->workshop_allowance_amount = floatval(preg_replace('#[^0-9.]#', '', $request->workshop_allowance_amount));
        }else{
            $user->has_workshop_allowance = FALSE;
            $user->workshop_allowance_amount = 0;
        }
        $user->incentive_week_day = floatval(preg_replace('#[^0-9.]#', '', $request->incentive_week_day));
        $user->incentive_week_end = floatval(preg_replace('#[^0-9.]#', '', $request->incentive_week_end));
        $user->additional_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->additional_allowance));
        $user->competency_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->competency_allowance));
        $user->bpjs_ke = floatval(preg_replace('#[^0-9.]#', '', $request->bpjs_ke));
        $user->bpjs_tk = floatval(preg_replace('#[^0-9.]#', '', $request->bpjs_tk));
        $user->profile_picture = $this->user_profile_picture;
        $user->save();
        //update the role
        $user->roles()->detach();
        $user->roles()->attach($request->role_id);


        //delete old user profile and it's thumbnail from the server if any
        \File::delete(public_path().'/img/user/'.$this->user_profile_picture_to_delete);
        \File::delete(public_path().'/img/user/thumb_'.$this->user_profile_picture_to_delete);

        return redirect('user/'.$id.'/edit')
            ->with('successMessage', "Member has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        //get the user profile to be removed from the server
        if($user->profile_picture != NULL){
            $this->user_profile_picture_to_delete = $user->profile_picture;
        }
        $delete = $user->delete();
        if($delete){
            \File::delete(public_path().'/img/user/'.$this->user_profile_picture_to_delete);
            \File::delete(public_path().'/img/user/thumb_'.$this->user_profile_picture_to_delete);
            return redirect('user')
                ->with('successMessage', "$user->name has been removed");
        }
        else{
            return "Something wrong when removing member";
        }
    }

    //Image upload handling process
    protected function upload_process(Request $request){
        $upload_directory = public_path().'/img/user/';
        $extension = $request->file('image')->getClientOriginalExtension();
        $profile_picture_to_be_inserted = time().'.'.$extension;
        $this->user_profile_picture = $profile_picture_to_be_inserted;
        $save_image = \Image::make($request->image)->save($upload_directory.$profile_picture_to_be_inserted);
        //make the thumbnail
        $thumbnail = \Image::make($request->image)->resize(171,180)->save($upload_directory.'thumb_'.$this->user_profile_picture);
        //free the memory
        $save_image->destroy();

    }
    //ENDImage upload handling process



    public function unlock_create_internal_request(Request $request)
    {
        $check = \DB::table('lock_configurations')
                ->select('id')
                ->where('user_id', '=', $request->user_id)
                ->where('facility_name','=', 'create_internal_request')
                ->get();
        if(count($check)){
            $unlock = \DB::table('lock_configurations')
                    ->where('id','=', $check[0]->id)->delete();
            return($unlock);
        }
    }

    public function show_time_report(Request $request)
    {
        $user = User::findOrfail($request->user_id);
        $period = Period::findOrfail($request->period_id); 

        $time_report_users = $user->time_reports->where('pivot.period_id', $period->id);

        $total_incentive_non = $time_report_users->where('pivot.incentive', 'non')->count();
        $total_incentive_week_day = $time_report_users->where('pivot.incentive', 'week_day')->count();
        $total_incentive_week_end = $time_report_users->where('pivot.incentive', 'week_end')->count();

        $total_allowance = $time_report_users->where('pivot.allowance', 1)->count();
        $total_non_allowance = $time_report_users->where('pivot.non_allowance', 1)->count();

        $total_normal_time = $time_report_users->sum('pivot.normal_time');

        $total_overtime_one = $time_report_users->sum('pivot.overtime_one');
        $total_overtime_two = $time_report_users->sum('pivot.overtime_two');
        $total_overtime_three = $time_report_users->sum('pivot.overtime_three');
        $total_overtime_four = $time_report_users->sum('pivot.overtime_four');
        
        return view('user.show_time_report')
            ->with('user', $user)
            ->with('period', $period)
            ->with('time_report_users', $time_report_users)
            ->with('total_incentive_non', $total_incentive_non)
            ->with('total_incentive_week_day', $total_incentive_week_day)
            ->with('total_incentive_week_end', $total_incentive_week_end)
            ->with('total_allowance', $total_allowance)
            ->with('total_non_allowance', $total_non_allowance)
            ->with('total_normal_time', $total_normal_time)
            ->with('total_overtime_one', $total_overtime_one)
            ->with('total_overtime_two', $total_overtime_two)
            ->with('total_overtime_three', $total_overtime_three)
            ->with('total_overtime_four', $total_overtime_four);
    }

    public function create_time_report(Request $request)
    {
        $period = Period::findOrfail($request->period_id); 
        $time_reports = TimeReport::where('period_id','=', $period->id)->get();
        $user = User::findOrfail($request->user_id);
        $incentive_opts = ['non'=>'Non', 'week_day'=>'Week Day', 'week_end'=>'Week End'];
        $allowance_opts = ['allowance'=>'Allowance', 'non_allowance'=>'Non Allowance'];
        return view('user.create_time_report')
            ->with('user', $user)
            ->with('period', $period)
            ->with('time_reports', $time_reports)
            ->with('incentive_opts', $incentive_opts)
            ->with('allowance_opts', $allowance_opts);
    }

    public function store_time_report(InputTimeReportUserRequest $request)
    {

        $data = [];
        foreach($request->time_report_id as $key=>$value){
            array_push($data, [
                'period_id'=>$request->period_id,
                'time_report_id'=>$request->time_report_id[$key],
                'user_id'=>$request->user_id,
                'incentive'=>$request->incentive[$key],
                'allowance'=>$request->allowance[$key] == 'allowance' ? TRUE : FALSE,
                'non_allowance'=>$request->allowance[$key] == 'non_allowance' ? TRUE : FALSE,
                'normal_time'=>$request->normal_time[$key],
                'overtime_one' => $request->overtime_one[$key],
                'overtime_two' => $request->overtime_two[$key],
                'overtime_three' => $request->overtime_three[$key],
                'overtime_four' => $request->overtime_four[$key],
            ]);

        }
        //\DB::table('time_report_user')->delete();
        \DB::table('time_report_user')->insert($data);
        return redirect('user/'.$request->user_id);
        
    }



    public function print_salary(Request $request)
    {
        $user = User::findOrfail($request->user_id);
        $period = Period::findOrfail($request->period_id);
        $time_report_users = $user->time_reports->where('pivot.period_id', $period->id);

        //Block collect needed user property
        $data['employee_name'] = $user->name;
        $data['employee_nik'] = $user->nik;
        $data['employee_role'] = $user->roles->first()->name;
        $data['employee_man_hour_rate'] = $user->man_hour_rate;
        $data['employee_eat_allowance'] = $user->eat_allowance;
        $data['employee_transportation_allowance'] = $user->transportation_allowance;
        $data['employee_medical_allowance'] = $user->medical_allowance;
        $data['employee_incentive_week_day'] = $user->incentive_week_day;
        $data['employee_incentive_week_end'] = $user->incentive_week_end;

        //ENDBlock collect needed user property

        $data['total_incentive_non'] = $time_report_users->where('pivot.incentive', 'non')->count();
        $data['total_incentive_week_day'] = $time_report_users->where('pivot.incentive', 'week_day')->count();
        $data['total_incentive_week_end'] = $time_report_users->where('pivot.incentive', 'week_end')->count();

        $data['total_allowance'] = $time_report_users->where('pivot.allowance', 1)->count();
        $data['total_non_allowance'] = $time_report_users->where('pivot.non_allowance', 1)->count();

        $data['total_normal_time'] = $time_report_users->sum('pivot.normal_time');

        $data['total_overtime_one'] = $time_report_users->sum('pivot.overtime_one');
        $data['value_total_overtime_one'] = $time_report_users->sum('pivot.overtime_one') * 1.5;
        

        $data['total_overtime_two'] = $time_report_users->sum('pivot.overtime_two');
        $data['value_total_overtime_two'] = $time_report_users->sum('pivot.overtime_two') * 2;

        $data['total_overtime_three'] = $time_report_users->sum('pivot.overtime_three');
        $data['value_total_overtime_three'] = $time_report_users->sum('pivot.overtime_three') * 3;

        $data['total_overtime_four'] = $time_report_users->sum('pivot.overtime_four');
        $data['value_total_overtime_four'] = $time_report_users->sum('pivot.overtime_four') * 4;

        $data['value_total_over_time'] = $data['value_total_overtime_one']+$data['value_total_overtime_two']+$data['value_total_overtime_three']+$data['value_total_overtime_four'];

        //Block build salary parameters to be paid AS ADDITION
        //if employee type is outsource, the basic salary is result of manhour_rate * normal time total
        $data['employee_salary'] = $user->type=='outsource' ? $data['employee_man_hour_rate']*$data['total_normal_time'] : $user->salary;
        $data['overtime_salary'] = $data['value_total_over_time'] * $data['employee_man_hour_rate'];
        $data['eat_allowance_salary'] = $data['total_allowance'] * $data['employee_eat_allowance'];
        $data['transportation_allowance_salary'] = $data['total_allowance'] * $data['employee_transportation_allowance'];
        $data['incentive_week_day_salary'] = $data['total_incentive_week_day'] * $data['employee_incentive_week_day'];
        $data['incentive_week_end_salary'] =$data['total_incentive_week_end'] * $data['employee_incentive_week_end'];
        $data['medical_allowance_salary'] = $data['total_allowance'] > 14 ? $data['employee_medical_allowance'] : $data['employee_medical_allowance']/2;
        //ENDBlock build salary parameters to be paid AS ADDITION

        //Block build salary parameters to be paid AS SUBTRACTION
        $data['cashbond_salary'] = $user->cashbonds()
                                ->where('cashbonds.accounted','=',TRUE)
                                ->whereBetween('cashbonds.created_at',[$period->start_date, $period->end_date])
                                ->sum('cashbonds.amount');
        $data['bpjs_ke_salary'] = $user->bpjs_ke;
        $data['bpjs_tk_salary'] = $user->bpjs_tk;
        //EndBlock build salary parameters to be paid AS SUBTRACTION

        //Block Count total salary to be paid
            //salary as addition params
            $total_salary_add = $data['employee_salary']+$data['overtime_salary']+
                                $data['eat_allowance_salary']+$data['transportation_allowance_salary']+
                                $data['incentive_week_day_salary']+$data['incentive_week_end_salary']+$data['medical_allowance_salary'];
            //salary as subtraction params
            $total_salary_sub = $data['cashbond_salary']+$data['bpjs_ke_salary']+$data['bpjs_tk_salary'];

            $data['total_salary'] = $total_salary_add - $total_salary_sub;
        //ENDBlock Count total salary to be paid
        $data['user'] = $user;
        $data['period'] = $period;

        $pdf = \PDF::loadView('pdf.salary', $data);
        return $pdf->stream("Salary".'.pdf');
    }


    public function resetPassword(Request $request)
    {
        $user = User::find($request->user_id);
        if($user){
            $user->password = bcrypt('12345');
            $user->save();
            return redirect('user/'.$request->user_id)
            ->with('successMessage', "User password has been resetted");
        }else{
            return redirect()->back();
        }
    }


    //USER datatables
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
    //END USER datatables

    //Block get user leave datatable
    public function getLeavesDataTable(Request $request)
    {

        \DB::statement(\DB::raw('set @rownum=0'));
        $leaves = Leave::where('user_id', $request->user_id)->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'leaves.*',
        ])->get();

        $data_leave = Datatables::of($leaves)
            
            ->addColumn('actions', function($leaves){
                    $actions_html ='<button type="button" class="btn btn-danger btn-xs btn-delete-asset-category" data-id="'.$leaves->id.'" data-text="'.$leaves->description.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_leave->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_leave->make(true);
    }
    //END Block get user leave datatable

    public function select2Site(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("users")
                    ->where('type', '=', 'outsource')
                    ->where('users.name','LIKE',"%$search%")
                    ->get();
        }
        else{
            $data = \DB::table('users')
                    ->where('type', '=', 'outsource')
                    ->get();
        }
        return response()->json($data);
    }

    public function select2Office(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("users")
                    ->where('type', '=', 'office')
                    ->where('users.name','LIKE',"%$search%")
                    ->get();
        }
        else{
            $data = \DB::table('users')
                    ->where('type', '=', 'office')
                    ->get();
        }
        return response()->json($data);
    }

}
