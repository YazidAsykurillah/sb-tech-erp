<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;
use Yajra\Datatables\Datatables;

use App\Ets;
use App\Period;
use App\User;
use Excel;
class EtsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'index';
    }

    public function indexETSSite()
    {
        return view('ets.indexSite');
    }

    public function indexETSOffice()
    {
        return view('ets.indexOffice');
    }

    //Import ETS for site member
    public function importEtsSite(Request $request)
    {
        $user_id = $request->user_id;
        $imported_data = 0;
        if($request->hasFile('file') && $request->period_id!=""){
            config(['excel.import.startRow' => 4 ]);
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                $reader->noHeading = true;
            })->get();
            /*echo '<pre>';
            print_r($data);
            echo '</pre>';
            exit();*/
            if(!empty($data) && $data->count()){
                //first delete all the ETS which is related to user id and period id
                Ets::where('user_id', '=', $user_id)
                    ->where('period_id', '=', $request->period_id)
                    ->delete();
                foreach ($data as $key => $value) {
                    $ets = new Ets;
                    $ets->user_id = $user_id;
                    $ets->period_id = $request->period_id;
                    $ets->the_date =  Carbon::parse($value[0])->format('Y-m-d');
                    $ets->normal = $value[1];
                    $ets->I = $value[2];
                    $ets->II = $value[3];
                    $ets->III = $value[4];
                    $ets->IV = $value[5];
                    $ets->description = $value[6];
                    $ets->location = str_slug(strtolower($value[7]));
                    $ets->project_number = $value[8];
                    $ets->type = 'site';
                    $ets->save();
                    $imported_data +=1;
                    
                }
            }
            return back()->with('successMessage', "$imported_data has been imported");
            
        }
        else{
            return redirect()->back()
            ->withInput()
            ->with('errorMessage', "Please upload the file");
        }
    }

    //END Import ETS for site member

    //ETS Site Datatables
    public function getETSSitedataTables(Request $request)
    {
        $ets = \DB::table('ets')
        ->select(
            'ets.period_id', 'ets.user_id',
            \DB::raw("CONCAT(periods.the_year,'-',periods.the_month) as the_period"),
            \DB::raw('users.name as user_name')
        )
        ->where('ets.type','=', 'site')
        ->join('periods', 'periods.id', '=', 'ets.period_id')
        ->join('users', 'users.id', '=', 'ets.user_id')
        ->groupBy('ets.period_id', 'ets.user_id');

        $data_ets = Datatables::of($ets)
            ->addColumn('actions', function($ets){
                $actions_html = '';
                $actions_html.='<a class="btn btn-default btn-xs" href="/ets/show/?period_id='.$ets->period_id.'&user_id='.$ets->user_id.'">';   
                $actions_html.='<i class="fa fa-external-link"></i>';   
                $actions_html.='</a>';   
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            exit('filter');
            $data_ets->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_ets->make(true);
    }
    //END ETS Site Datatables

    //ETS Office Datatables
    public function getETSOfficedataTables(Request $request)
    {
        $ets = \DB::table('ets')
        ->select(
            'ets.period_id', 'ets.user_id',
            \DB::raw("CONCAT(periods.the_year,'-',periods.the_month) as the_period"),
            \DB::raw('users.name as user_name')
        )
        ->where('ets.type','=', 'office')
        ->join('periods', 'periods.id', '=', 'ets.period_id')
        ->join('users', 'users.id', '=', 'ets.user_id')
        ->groupBy('ets.period_id', 'ets.user_id');

        $data_ets = Datatables::of($ets)
            ->addColumn('actions', function($ets){
                $actions_html = '';
                $actions_html.='<a class="btn btn-default btn-xs" href="/ets/show/?period_id='.$ets->period_id.'&user_id='.$ets->user_id.'">';   
                $actions_html.='<i class="fa fa-external-link"></i>';   
                $actions_html.='</a>';   
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            exit('filter');
            $data_ets->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_ets->make(true);
    }
    //END ETS Office Datatables

    //Import ETS for Office member
    public function importEtsOffice(Request $request)
    {
        $user_id = $request->user_id;
        $imported_data = 0;
        if($request->hasFile('file') && $request->period_id!=""){
            config(['excel.import.startRow' => 2 ]);
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                $reader->noHeading = true;
            })->get();
            /*echo '<pre>';
            print_r($data);
            echo '</pre>';
            exit();*/
            if(!empty($data) && $data->count()){
                //first delete all the ETS which is related to user id and period id
                Ets::where('user_id', '=', $user_id)
                    ->where('period_id', '=', $request->period_id)
                    ->delete();
                foreach ($data as $key => $value) {
                    $ets = new Ets;
                    $ets->user_id = $user_id;
                    $ets->period_id = $request->period_id;
                    $ets->the_date =  Carbon::parse($value[0])->format('Y-m-d');
                    $ets->start_time =  $value[1];
                    $ets->end_time =  $value[2];
                    $ets->description =  $value[3];
                    $ets->location = str_slug(strtolower($value[4]));
                    $ets->project_number = $value[5];
                    $ets->type = 'office';
                    $ets->save();
                    $imported_data +=1;
                    
                }
            }
            return back()->with('successMessage', "$imported_data has been imported");
            
        }
        else{
            return redirect()->back()
            ->withInput()
            ->with('errorMessage', "Please upload the file");
        }
    }

    //END Import ETS for Office member

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
    public function show(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $period = Period::findOrFail($request->period_id);
        if($user->type == 'outsource'){
            return $this->showEtsForOutsource($user, $period);
        }
        elseif ($user->type == 'office'){
            return $this->showEtsForOffice($user, $period);
        }
        else{
            return "Unidentified user type";
        }
        
    }

    public function showEtsForOutsource($user, $period){

        $ets_lists = Ets::where('user_id', '=', $user->id)->where('period_id', '=', $period->id)->get();
        return view('ets.show_ets_outsource')
            ->with('user', $user)
            ->with('period', $period)
            ->with('ets_lists', $ets_lists);
    }

    public function showEtsForOffice($user, $period){

        $ets_lists = Ets::where('user_id', '=', $user->id)->where('period_id', '=', $period->id)->get();
        return view('ets.show_ets_office')
            ->with('user', $user)
            ->with('period', $period)
            ->with('ets_lists', $ets_lists);
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


    //import from period for non office user
    public function import(Request $request)
    {
        
    	$imported_data = 0;
        if($request->hasFile('file') && $request->period_id!=""){
            config(['excel.import.startRow' => 4 ]);
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                $reader->noHeading = true;
            })->get();
            /*echo '<pre>';
            print_r($data);
            echo '</pre>';
            exit();*/
            if(!empty($data) && $data->count()){
                //first delete all the ETS which is related to user id and period id
                Ets::where('user_id', '=', \Auth::user()->id)->where('period_id', '=', $request->period_id)->delete();
                foreach ($data as $key => $value) {
                    $ets = new Ets;
                    $ets->user_id = \Auth::user()->id;
                    $ets->period_id = $request->period_id;
                    $ets->the_date =  Carbon::parse($value[0])->format('Y-m-d');
                    $ets->normal = $value[1];
                    $ets->I = $value[2];
                    $ets->II = $value[3];
                    $ets->III = $value[4];
                    $ets->IV = $value[5];
                    $ets->description = $value[6];
                    $ets->plant = $value[7];
                    $ets->save();
                    $imported_data +=1;
                    
                }
            }
            return back()->with('successMessage', "$imported_data has been imported");
            
        }
        else{
            return redirect()->back()
            ->withInput()
            ->with('errorMessage', "Please upload the file");
        }
    }


    //import from period for OFFICE user
    public function importForOfficeUser(Request $request)
    {
        
        $imported_data = 0;
        if($request->hasFile('file') && $request->period_id!=""){
            config(['excel.import.startRow' => 4 ]);
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                $reader->noHeading = true;
            })->get();

           /* echo '<pre>';
            print_r($data);
            echo '</pre>';
            exit();*/

            if(!empty($data) && $data->count()){
                //first delete all the ETS which is related to user id and period id
                Ets::where('user_id', '=', \Auth::user()->id)->where('period_id', '=', $request->period_id)->delete();
                foreach ($data as $key => $value) {
                    $ets = new Ets;
                    $ets->user_id = \Auth::user()->id;
                    $ets->period_id = $request->period_id;
                    $ets->the_date = Carbon::parse($value[0])->format('Y-m-d');
                    $ets->start_time = Carbon::parse($value[1])->format('G:i');
                    $ets->end_time = Carbon::parse($value[2])->format('G:i');
                    $ets->description = $value[3];
                    $ets->save();
                    $imported_data +=1;
                    
                }
            }
            return back()->with('successMessage', "$imported_data has been imported");
            
        }
        else{
            return redirect()->back()
            ->withInput()
            ->with('errorMessage', "Please upload the file");
        }
    }


    //import from payroll
    public function importFromPayroll(Request $request)
    {
        $user_id = $request->user_id;
        $imported_data = 0;
        if($request->hasFile('file') && $request->period_id!=""){
            config(['excel.import.startRow' => 4 ]);
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                $reader->noHeading = true;
            })->get();
            /*echo '<pre>';
            print_r($data);
            echo '</pre>';
            exit();*/
            if(!empty($data) && $data->count()){
                //first delete all the ETS which is related to user id and period id
                Ets::where('user_id', '=', $user_id)
                    ->where('period_id', '=', $request->period_id)
                    ->delete();
                foreach ($data as $key => $value) {
                    $ets = new Ets;
                    $ets->user_id = $user_id;
                    $ets->period_id = $request->period_id;
                    $ets->the_date =  Carbon::parse($value[0])->format('Y-m-d');
                    $ets->normal = $value[1];
                    $ets->I = $value[2];
                    $ets->II = $value[3];
                    $ets->III = $value[4];
                    $ets->IV = $value[5];
                    $ets->description = $value[6];
                    $ets->project_number = $value[7];
                    $ets->save();
                    $imported_data +=1;
                    
                }
            }
            return back()->with('successMessage', "$imported_data has been imported");
            
        }
        else{
            return redirect()->back()
            ->withInput()
            ->with('errorMessage', "Please upload the file");
        }
    }


    public function updateHasIncentiveWeekDay(Request $request)
    {
        $ets = Ets::findOrFail($request->ets_id);
        if($request->state == 'checked'){
            $ets->has_incentive_week_day = TRUE;
        }else{
            $ets->has_incentive_week_day = FALSE;
        }
        $ets->save();
    }

    public function updateHasIncentiveWeekEnd(Request $request)
    {
        $ets = Ets::findOrFail($request->ets_id);
        if($request->state == 'checked'){
            $ets->has_incentive_week_end = TRUE;
        }else{
            $ets->has_incentive_week_end = FALSE;
        }
        $ets->save();
    }

    public function myEts()
    {
        return view('ets.myets');
    }

    //MY ETS Datatables
    public function myEtsDataTables(Request $request)
    {
        $user_id = \Auth::user()->id;
        $ets = \DB::table('ets')
        ->select(
            'ets.period_id', 'ets.user_id',
            \DB::raw("CONCAT(periods.the_year,'-',periods.the_month) as the_period"),
            \DB::raw('users.name as user_name')
        )
        ->where('ets.user_id','=', $user_id)
        ->join('periods', 'periods.id', '=', 'ets.period_id')
        ->join('users', 'users.id', '=', 'ets.user_id')
        ->groupBy('ets.period_id', 'ets.user_id');

        $data_ets = Datatables::of($ets)
            ->addColumn('actions', function($ets){
                $actions_html = '';
                $actions_html.='<a class="btn btn-default btn-xs" href="/ets/show/?period_id='.$ets->period_id.'&user_id='.$ets->user_id.'">';   
                $actions_html.='<i class="fa fa-external-link"></i>';   
                $actions_html.='</a>';   
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            exit('filter');
            $data_ets->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_ets->make(true);
    }
    //END MY ETS Datatables

    public function importMyEts(Request $request)
    {
        $user = \Auth::user();
        $imported_data = 0;
        if($user->type =='office'){ //Import ETS for office member
            if($request->hasFile('file') && $request->period_id!=""){
                config(['excel.import.startRow' => 2 ]);
                $path = $request->file('file')->getRealPath();
                $data = Excel::load($path, function($reader) {
                    $reader->noHeading = true;
                })->get();
                /*echo '<pre>';
                print_r($data);
                echo '</pre>';
                exit();*/
                if(!empty($data) && $data->count()){
                    //first delete all the ETS which is related to user id and period id
                    Ets::where('user_id', '=', $user->id)
                        ->where('period_id', '=', $request->period_id)
                        ->delete();
                    foreach ($data as $key => $value) {
                        $ets = new Ets;
                        $ets->user_id = $user->id;
                        $ets->period_id = $request->period_id;
                        $ets->the_date =  Carbon::parse($value[0])->format('Y-m-d');
                        $ets->start_time =  $value[1];
                        $ets->end_time =  $value[2];
                        $ets->description =  $value[3];
                        $ets->location = str_slug(strtolower($value[4]));
                        $ets->project_number = $value[5];
                        $ets->type = 'office';
                        $ets->save();
                        $imported_data +=1;
                        
                    }
                }
                return back()->with('successMessage', "$imported_data has been imported");
                
            }
            else{
                return redirect()->back()
                ->withInput()
                ->with('errorMessage', "Please upload the file");
            }
        }
        else{   //the user type is outsource
            if($request->hasFile('file') && $request->period_id!=""){
                config(['excel.import.startRow' => 4 ]);
                $path = $request->file('file')->getRealPath();
                $data = Excel::load($path, function($reader) {
                    $reader->noHeading = true;
                })->get();
                if(!empty($data) && $data->count()){
                    //first delete all the ETS which is related to user id and period id
                    Ets::where('user_id', '=', $user->id)
                        ->where('period_id', '=', $request->period_id)
                        ->delete();
                    foreach ($data as $key => $value) {
                        $ets = new Ets;
                        $ets->user_id = $user->id;
                        $ets->period_id = $request->period_id;
                        $ets->the_date =  Carbon::parse($value[0])->format('Y-m-d');
                        $ets->normal = $value[1];
                        $ets->I = $value[2];
                        $ets->II = $value[3];
                        $ets->III = $value[4];
                        $ets->IV = $value[5];
                        $ets->description = $value[6];
                        $ets->location = str_slug(strtolower($value[7]));
                        $ets->project_number = $value[8];
                        $ets->type = 'site';
                        $ets->save();
                        $imported_data +=1;
                        
                    }
                }
                return back()->with('successMessage', "$imported_data has been imported");
                
            }
            else{
                return redirect()->back()
                ->withInput()
                ->with('errorMessage', "Please upload the file");
            }
        }
        
        
    }
}
