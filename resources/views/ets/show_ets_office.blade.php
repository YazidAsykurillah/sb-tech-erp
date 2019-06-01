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
    <li class=""><a href="{{ URL::to('ets/office') }}">ETS</a></li>
    <li class="active">Detail</li>
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
                  <td style="width: 5%;">#</td>
                  <td style="width: 10%;">Date</td>
                  <td style="width: 10%;">Start Time</td>
                  <td style="width: 10%;">End Time</td>
                  <td style="width: 15%;">Description</td>
                  <td>Location</td>
                  <td>Project Number</td>
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
                    <td class="centered-bordered">{{ $ets->start_time }}</td>
                    <td class="centered-bordered">{{ $ets->end_time }}</td>
                    <td class="centered-bordered">{{ $ets->description }}</td>
                    <td class="centered-bordered">{{ $ets->location }}</td>
                    <td class="centered-bordered">{{ $ets->project_number }}</td>
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