@extends('layouts.app')

@section('page_title')
  ETS Detail
@endsection

@section('page_header')
  <h1>
    ETS Detail
    <small></small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Detail ETS</h3>
          </div>
          <div class="box-body">
           <table class="table" id="table-user">
             <tr>
               <td>User</td>
               <td>:</td>
               <td>{{ $user->name}}</td>
             </tr>
             <tr>
               <td>Type</td>
               <td>:</td>
               <td>{{ $user->type}}</td>
             </tr>
             <tr>
               <td>Period</td>
               <td>:</td>
               <td>{{ $period->the_year}}-{{$period->the_month}}</td>
             </tr>
           </table>
           <p></p>
           <p></p>
           <table class="table" id="table-ets">
             <thead>
                <tr>
                  <th rowspan="3" style="text-align:center;border:1px solid;">#</th>
                  <th rowspan="3" style="text-align:center;border:1px solid;">Date</th>
                  <th colspan="5" style="text-align:center;border:1px solid;">Manhour</th>
                  
                  <th rowspan="3" style="text-align:center;border:1px solid;">Project Number</th>
                  <th rowspan="3" style="text-align:center;border:1px solid;">Location</th>
                  
                </tr>
                <tr>
                  <th rowspan="2" style="text-align:center;border:1px solid;">Normal</th>
                  <th colspan="4" style="text-align:center;border:1px solid;">Overtime</th>
                  
                </tr>
                <tr>
                  <th style="text-align:center;border:1px solid;">I</th>
                  <th style="text-align:center;border:1px solid;">II</th>
                  <th style="text-align:center;border:1px solid;">III</th>
                  <th style="text-align:center;border:1px solid;">IV</th>
                </tr>
              </thead>
              <tbody>
                 @if($ets_lists->count())
                  <?php $num = 0; ?>
                  @foreach($ets_lists as $ets)
                  <?php $num++;?>
                  <tr>
                    <td class="centered-bordered">{{ $num }}</td>
                    <td class="centered-bordered">{{ $ets->the_date }}</td>
                    <td class="centered-bordered">{{ $ets->normal }}</td>
                    <td class="centered-bordered">{{ $ets->I }}</td>
                    <td class="centered-bordered">{{ $ets->II }}</td>
                    <td class="centered-bordered">{{ $ets->III }}</td>
                    <td class="centered-bordered">{{ $ets->IV }}</td>
                    <td class="centered-bordered">{{ $ets->project_number }}</td>
                    <td class="centered-bordered">{{ $ets->location }}</td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
           </table>
          </div>
        </div><!-- /.box-body -->
    </div>
    
  </div>  
@endsection

@section('additional_scripts')
  
@endsection