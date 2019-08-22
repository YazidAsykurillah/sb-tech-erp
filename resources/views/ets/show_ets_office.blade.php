@extends('layouts.app')

@section('page_title')
  ETS Detail
@endsection

@section('additional_styles')
  {!! Html::style('vendor/bootstrap3-editable/css/bootstrap-editable.css') !!}
  <style type="text/css">
    table#table-ets{
      width: 100%;
    }
    table#table-ets td{
      border: 1px solid;
    }
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
                  <th style="text-align:center;border:1px solid;width: 5%;">#</th>
                  <th style="text-align:center;border:1px solid;width: 10%;">Date</th>
                  <th style="text-align:center;border:1px solid;width: 10%;">Start Time</th>
                  <th style="text-align:center;border:1px solid;width: 10%;">End Time</th>
                  <th style="text-align:center;border:1px solid;width: 15%;">Description</th>
                  <th style="text-align: center;border:1px solid;">Location</th>
                  <th style="text-align: center;border:1px solid;">Project Number</th>
                  <th style="text-align: center;border:1px solid;">Incentive Week Day</th>
                  <th style="text-align: center;border:1px solid;">Incentive Week End</th>
                  <th style="text-align: center;border:1px solid;">Checker Notes</th>
                </tr>  
              </thead>
              <tbody>
                @if($ets_lists->count())
                  <?php $num = 0; ?>
                  @foreach($ets_lists as $ets)
                  <?php $num++;?>
                  <tr class="{{ is_date_weekend($ets->the_date) == TRUE ? 'weekend':'' }}">
                    <td class="centered-bordered">{{ $num }}</td>
                    <td class="centered-bordered">
                      {{ $ets->the_date }}
                      <p>{{ get_day_name($ets->the_date) }}</p>
                    </td>
                    <td class="centered-bordered">{{ $ets->start_time }}</td>
                    <td class="centered-bordered">{{ $ets->end_time }}</td>
                    <td class="centered-bordered">
                      <a href="#" class="le_text" data-type="text" data-pk="{{ $ets->id }}"  data-title="Description" data-name="description">
                        {{ $ets->description }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_dropdown" data-pk="{{$ets->id}}" data-title="Location" data-value="{{ $ets->location }}" data-name="location"></a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_text" data-type="text" data-pk="{{ $ets->id }}"  data-title="Project Number" data-name="project_number">
                        {{ $ets->project_number }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <input type="checkbox" class="check_has_incentive_week_day" data-id="{{$ets->id}}" @if($ets->has_incentive_week_day == TRUE) checked @endif @if(\Auth::user()->cannot('update-ets-incentive-state')) disabled @endif/>
                    </td>
                    <td class="centered-bordered">
                      <input type="checkbox" class="check_has_incentive_week_end" data-id="{{$ets->id}}" @if($ets->has_incentive_week_end == TRUE) checked @endif @if(\Auth::user()->cannot('update-ets-incentive-state')) disabled @endif/>
                    </td>
                    <td class="centered-bordered">
                      @if(\Auth::user()->can('update-ets-checker-notes'))
                      <a href="#" class="le_text" data-type="text" data-pk="{{ $ets->id }}"  data-title="Checker notes" data-name="checker_notes">
                        {{ $ets->checker_notes }}
                      </a>
                      @endif
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
  {!! Html::script('vendor/bootstrap3-editable/js/bootstrap-editable.js') !!}
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    var _token = $('meta[name="csrf-token"]').attr('content');
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
        data: {ets_id : ets_id, 'state':state, '_token': _token},
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
        data: {ets_id : ets_id, 'state':state, '_token': _token},
        dataType: 'json',
        success: function( data ) {
          console.log(data);
        }       
      })
    }
    //ENDHandling check has incentive week end

    //Live editable dropdown
    $('.le_dropdown').editable({
      value: $(this).attr('data-value'),
      type:'select',
      pk: $(this).attr('data-pk'),
      url: '{!! url('ets/liveEdit') !!}',
      title: 'Please select',
      params : {_token : _token, name:$(this).attr('data-name')},
      source: [
                {value: 'site-local', text: 'Site Local'},
                {value: 'site-non-local', text: 'Site Non local'},
                {value: 'workshop', text: 'Workshop'},
                {value: 'office', text: 'Office'},
              ]
    });
    //ENDLive editable text type

    //Live editable text type
    $('.le_text').editable({
      mode : 'popup',
      type: 'number',
      emptytext:'empty',
      pk: $(this).attr('data-pk'),
      url: '{!! url('ets/liveEdit') !!}',
      title: 'Please type it here',
      params : {_token : _token, name:$(this).attr('data-name')},
      success: function(response, newValue){
        console.log(response);
        
      }
    });
    //ENDLive editable text type
  </script>
@endsection