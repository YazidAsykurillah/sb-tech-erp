<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\TimeReport;
use App\Period;

class TimeReportController extends Controller
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
    public function create(Request $request)
    {
        $period = Period::findOrfail($request->period_id);
        $start_date = $period->start_date;
        $end_date = $period->end_date;
        $time_report_dates = $this->create_time_report_dates(Carbon::parse($start_date), Carbon::parse($end_date));
        return view('time-report.create')
            ->with('period', $period)
            ->with('time_report_dates', $time_report_dates);
    }


    protected function create_time_report_dates(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];

        foreach($request->the_date as $key=>$value){
            array_push($data, [
                'period_id'=>$request->period_id,
                'the_date'=>$request->the_date[$key],
                'type'=>$request->type[$key],
            ]);
        }
        \DB::table('time_reports')->where('period_id','=', $request->period_id)->delete();
        \DB::table('time_reports')->insert($data);
        return redirect('period/'.$request->period_id);
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
