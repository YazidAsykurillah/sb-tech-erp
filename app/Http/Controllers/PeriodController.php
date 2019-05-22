<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Period;
use App\Ets;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('period.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $the_year_opts = [];
        $the_month_opts = [
            'january'=>'January', 'february'=>'February', 'march'=>'March', 'april'=>'April',
            'may'=>'May', 'june'=>'June', 'july'=>'July', 'august'=>'August',
            'september'=>'September', 'october'=>'October', 'november'=>'November', 'december'=>'December'
        ];
        for ($i=2017; $i < 2025 ; $i++) { 
            $the_year_opts[$i] = $i;
        }
        return view('period.create')
            ->with('the_year_opts', $the_year_opts)
            ->with('the_month_opts', $the_month_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePeriodRequest $request)
    {
        
        $period = new Period;
        $period->code = 'PER-'.$request->the_year.strtoupper(substr($request->the_month, 0,3));
        $period->the_year = $request->the_year;
        $period->the_month = $request->the_month;
        $period->start_date = date_create($request->start_date);
        $period->end_date = date_create($request->end_date);
        $period->save();
        $last_id = $period->id;
        return redirect('period/'.$last_id)
            ->with('successMessage', 'Period has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $period = Period::findOrFail($id);
        $ets_lists = Ets::where('user_id','=', \Auth::user()->id)->where('period_id', $period->id)->get();
        return view('period.show')
            ->with('ets_lists', $ets_lists)
            ->with('period', $period);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $the_year_opts = [];
        $the_month_opts = [
            'january'=>'January', 'february'=>'February', 'march'=>'March', 'april'=>'April',
            'may'=>'May', 'june'=>'June', 'july'=>'July', 'august'=>'August',
            'september'=>'September', 'october'=>'October', 'november'=>'November', 'december'=>'December'
        ];
        for ($i=2017; $i < 2025 ; $i++) { 
            $the_year_opts[$i] = $i;
        }

        $period = Period::findOrFail($id);
        return view('period.edit')
            ->with('the_year_opts', $the_year_opts)
            ->with('the_month_opts', $the_month_opts)
            ->with('period', $period);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePeriodRequest $request, $id)
    {
        $period = Period::findOrFail($id);
        $period->start_date = date_create($request->start_date);
        $period->end_date = date_create($request->end_date);
        $period->save();
        return redirect('period/'.$id)
            ->with('successMessage', 'Period has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $period = Period::findOrFail($request->period_id);
        $period->delete();
        return redirect('period')
            ->with('successMessage', 'Period has been deleted');
    }
}
