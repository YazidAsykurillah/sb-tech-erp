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
                    <td class="centered-bordered">
                      <a href="#" class="le_date" data-type="date" data-pk="{{ $ets->id }}"  data-title="Date" data-name="the_date">
                        {{ $ets->the_date }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_number" data-type="text" data-pk="{{ $ets->id }}"  data-title="Normal" data-name="normal">
                        {{ $ets->normal }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_number" data-type="text" data-pk="{{ $ets->id }}"  data-title="I" data-name="I">
                        {{ $ets->I }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_number" data-type="text" data-pk="{{ $ets->id }}"  data-title="I" data-name="II">
                        {{ $ets->II }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_number" data-type="text" data-pk="{{ $ets->id }}"  data-title="I" data-name="III">
                        {{ $ets->III }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_number" data-type="text" data-pk="{{ $ets->id }}"  data-title="I" data-name="IV">
                        {{ $ets->IV }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_text" data-type="text" data-pk="{{ $ets->id }}"  data-title="I" data-name="project_number">
                        {{ $ets->project_number }}
                      </a>
                    </td>
                    <td class="centered-bordered">
                      <a href="#" class="le_dropdown" data-pk="{{$ets->id}}" data-title="Location" data-value="{{ $ets->location }}" data-name="location"></a>
                    </td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr style="border: 1px solid;">
                  <td style="text-align: center;">Total</td>
                  <td style="text-align:center;"></td>
                  <td style="text-align:center;">{{$ets_lists->sum('normal')}}</td>
                  <td style="text-align:center;">{{$ets_lists->sum('I')}}</td>
                  <td style="text-align:center;">{{$ets_lists->sum('II')}}</td>
                  <td style="text-align:center;">{{$ets_lists->sum('III')}}</td>
                  <td style="text-align:center;">{{$ets_lists->sum('IV')}}</td>
                </tr>
              </tfoot>
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
    //Live editable number type
    $('.le_number').editable({
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
    }).on('shown', function(e, editable) {
        editable.input.$input.autoNumeric('init',{
            mDec:'0',
            vMin:'0',
            vMax:'1000',
        });
    });
    //ENDLive editable number type

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
                {value: 'workshop', text: 'Workshop'}
              ]
    });
    //ENDLive editable text type

    //Live editable date type
    $('.le_date').editable({
      mode : 'popup',
      type: 'date',
      pk: $(this).attr('data-pk'),
      url: '{!! url('ets/liveEdit') !!}',
      title: 'Please type it here',
      params : {_token : _token, name:$(this).attr('data-name')},
      success: function(response, newValue){
        console.log(response);
        
      }
    });
    //ENDLive editable date type
  </script>
@endsection