@extends('layouts.app')

@section('page_title')
  ETS Detail
@endsection

@section('additional_styles')
  <style type="text/css">
    td.centered-bordered{
      text-align: center;
    }
    tr.weekend{
      color: red;
    }
    td.weekend{
      color: red;
    }
  </style>
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
                  <td>Incentive Week Day</td>
                  <td>Incentive Week End</td>
                  <td>Checker Notes</td>
                </tr>  
              </thead>
              <tbody>
                @if($ets_lists->count())
                  <?php $num = 0; ?>
                  @foreach($ets_lists as $ets)
                  <?php $num++;?>
                  <tr class="{{ is_date_weekend($ets->the_date) == TRUE ? 'weekend':'' }}">
                    <td class="">{{ $num }}</td>
                    <td class="">
                      {{ $ets->the_date }}
                      <p>{{ get_day_name($ets->the_date) }}</p>
                    </td>
                    <td class="">{{ $ets->start_time }}</td>
                    <td class="">{{ $ets->end_time }}</td>
                    <td class="">{{ $ets->description }}</td>
                    <td class="">{{ $ets->location }}</td>
                    <td class="">{{ $ets->project_number }}</td>
                    <td class="">
                      <!-- <input type="checkbox" class="check_has_incentive_week_day" data-id="{{$ets->id}}" {{$ets->has_incentive_week_day == TRUE ? "checked" : ""}} /> -->
                      <input type="checkbox" class="check_has_incentive_week_day" data-id="{{$ets->id}}" @if($ets->has_incentive_week_day == TRUE) checked @endif @if(\Auth::user()->cannot('update-ets-incentive-state')) disabled @endif/>
                    </td>
                    <td class="">
                      <input type="checkbox" class="check_has_incentive_week_end" data-id="{{$ets->id}}" @if($ets->has_incentive_week_end == TRUE) checked @endif @if(\Auth::user()->cannot('update-ets-incentive-state')) disabled @endif/>
                    </td>
                    <td>
                      {{ $ets->checker_notes }}
                    </td>
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
  <script type="text/javascript">
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var ets_id = "";
    //Handling check has incentive week day
    $('.check_has_incentive_week_day').on('click', function(event){
      //event.preventDefault();
      ets_id = $(this).attr('data-id');
      if($(this).prop("checked") == true){
        update_has_incentive_weekday(ets_id,"checked");
      }
      else if($(this).prop("checked") == false){
       update_has_incentive_weekday(ets_id,"unchecked"); 
      }
    });

    function update_has_incentive_weekday(ets_id, state){
      $.ajax({
        url: '/ets/update_has_incentive_weekday',
        type: 'POST',
        data: {ets_id : ets_id, 'state':state, '_token': csrf},
        dataType: 'json',
        success: function( data ) {
          console.log(data);
        }       
      })
    }
    //ENDHandling check has incentive week day

    //Handling check has incentive week end
    $('.check_has_incentive_week_end').on('click', function(event){
      //event.preventDefault();
      ets_id = $(this).attr('data-id');
      if($(this).prop("checked") == true){
        update_has_incentive_weekend(ets_id,"checked");
      }
      else if($(this).prop("checked") == false){
       update_has_incentive_weekend(ets_id,"unchecked"); 
      }
    });

    function update_has_incentive_weekend(ets_id, state){
      $.ajax({
        url: '/ets/update_has_incentive_weekend',
        type: 'POST',
        data: {ets_id : ets_id, 'state':state, '_token': csrf},
        dataType: 'json',
        success: function( data ) {
          console.log(data);
        }       
      })
    }
    //ENDHandling check has incentive week end
  </script>
@endsection