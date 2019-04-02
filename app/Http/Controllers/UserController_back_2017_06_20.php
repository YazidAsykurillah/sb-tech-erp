<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\InputTimeReportUserRequest;


use App\User;
use App\Role;
use App\TimeReport;
use App\Period;

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
        $user->salary = floatval(preg_replace('#[^0-9.]#', '', $request->salary));
        $user->eat_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->eat_allowance));
        $user->transportation_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->transportation_allowance));
        $user->medical_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->medical_allowance));
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
        $user->nik = $request->number_id;
        $user->salary = floatval(preg_replace('#[^0-9.]#', '', $request->salary));
        $user->eat_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->eat_allowance));
        $user->transportation_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->transportation_allowance));
        $user->medical_allowance = floatval(preg_replace('#[^0-9.]#', '', $request->medical_allowance));
        $user->incentive = floatval(preg_replace('#[^0-9.]#', '', $request->incentive));
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

        $data['total_incentive_non'] = $time_report_users->where('pivot.incentive', 'non')->count();
        $data['total_incentive_week_day'] = $time_report_users->where('pivot.incentive', 'week_day')->count();
        $data['total_incentive_week_end'] = $time_report_users->where('pivot.incentive', 'week_end')->count();

        $data['total_allowance'] = $time_report_users->where('pivot.allowance', 1)->count();
        $data['total_non_allowance'] = $time_report_users->where('pivot.non_allowance', 1)->count();

        $data['total_normal_time'] = $time_report_users->sum('pivot.normal_time');

        $data['total_overtime_one'] = $time_report_users->sum('pivot.overtime_one');
        

        $data['total_overtime_two'] = $time_report_users->sum('pivot.overtime_two');

        $data['total_overtime_three'] = $time_report_users->sum('pivot.overtime_three');
        $data['total_overtime_four'] = $time_report_users->sum('pivot.overtime_four');

        $data['user'] = $user;
        $data['period'] = $period;

        
        $data['cashbonds'] = $user->cashbonds()
                                ->where('cashbonds.accounted','=',TRUE)
                                ->whereBetween('cashbonds.created_at',[$period->start_date, $period->end_date])
                                ->sum('cashbonds.amount');
                                    
        
        
        $pdf = \PDF::loadView('pdf.salary', $data);
        return $pdf->stream("Salary".'.pdf');
    }
}
