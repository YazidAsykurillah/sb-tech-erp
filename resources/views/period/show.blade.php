@extends('layouts.app')

@section('page_title')
  {{ $period->code }}
@endsection

@section('page_header')
  <h1>
    Period Detail
    <small>Detail of Period {{ $period->code }}</small>
  </h1>
@endsection

@section('additional_styles')
  <style type="text/css">
    table tr td.centered-bordered{
      text-align: center;
      border: 1px solid;
    }
  </style>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('period') }}"><i class="fa fa-clock-o"></i> Period</a></li>
    <li class="active"><i></i> {{ $period->code }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-3">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;Period Information</h3>
          <a href="{{ URL::to('period/'.$period->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Edit">
            <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <td style="width: 40%;">Code</td>
                <td style="width: 1%;">:</td>
                <td>{{ $period->code }}</td>
              </tr>
              <tr>
                <td style="width: 40%;">Year</td>
                <td style="width: 1%;">:</td>
                <td>{{ $period->the_year }}</td>
              </tr>
              <tr>
                <td style="width: 40%;">Month</td>
                <td style="width: 1%;">:</td>
                <td>{{ ucwords($period->the_month) }}</td>
              </tr>
              <tr>
                <td style="width: 40%;">Start Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $period->start_date }}</td>
              </tr>
              <tr>
                <td style="width: 40%;">End Date</td>
                <td style="width: 1%;">:</td>
                <td>{{ $period->end_date }}</td>
              </tr>
              
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
    <div class="col-md-9">
      <!--BOX Time Report Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;ETS</h3>
          <div class="pull-right">
            <button type="button" id="btn-import-ets" class="btn btn-xs btn-info">
              <i class="fa fa-upload"></i> Import
            </button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="table-ets" class="table">
              <thead>
                <tr>
                  <th rowspan="3" style="text-align:center;border:1px solid;">#</th>
                  <th rowspan="3" style="text-align:center;border:1px solid;">Date</th>
                  <th colspan="5" style="text-align:center;border:1px solid;">Manhour</th>
                  <th rowspan="3" style="text-align:center;border:1px solid;">Description</th>
                  <th rowspan="3" style="text-align:center;border:1px solid;">Plant</th>
                  
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
                    <td class="centered-bordered">{{ nl2br($ets->description) }}</td>
                    <td class="centered-bordered">{{ $ets->plant }}</td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div>
      <!--ENDBOX Time Report Informations-->
    </div>
  </div>

  <!--Modal Import ETS-->
  <div class="modal fade" id="modal-import-ets" tabindex="-1" role="dialog" aria-labelledby="modal-import-etsLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'ets/import', 'method'=>'post', 'id'=>'form-import-file', 'files'=>true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-import-etsLabel">Import ETS</h4>
        </div>
        <div class="modal-body">
          
          <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
            {!! Form::label('file', 'File', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::file('file') !!}
              @if ($errors->has('file'))
                <span class="help-block">
                  <strong>{{ $errors->first('file') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <input type="hidden" id="period_id" name="period_id" value="{{ $period->id }}" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btn-submit-import-ets">Submit</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!--ENDModal Import ETS-->
@endsection

@section('additional_scripts')
<script type="text/javascript">
  $('#btn-import-ets').on('click', function(event){
    event.preventDefault();
    //$('#modal-import-ets').modal('show');
    $('#modal-import-ets').modal({
      backdrop : 'static',
      keyboard : false
    });

  });
</script>
  
@endsection