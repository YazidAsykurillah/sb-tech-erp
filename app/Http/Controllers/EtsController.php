<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Ets;
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
        //
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

}
