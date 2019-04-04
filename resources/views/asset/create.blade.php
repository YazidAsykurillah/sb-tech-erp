@extends('layouts.app')

@section('page_title')
    Asset
@endsection

@section('page_header')
  <h1>
    Asset
    <small>Create Asset</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-database"></i> Master Data</a></li>
    <li class="active"><i></i> Asset</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Asset</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['route'=>'asset.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-asset-category','files'=>true]) !!}
              <div class="form-group{{ $errors->has('asset_category_id') ? ' has-error' : '' }}">
                {!! Form::label('asset_category_id', 'Asset Category', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <select name="asset_category_id" id="asset_category_id" class="form-control">
                    @if(Request::old('asset_category_id') != NULL)
                      <option value="{{Request::old('asset_category_id')}}">
                        {{ \App\AssetCategory::find(Request::old('asset_category_id'))->name }}
                      </option>
                    @endif
                  </select>
                  @if ($errors->has('asset_category_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('asset_category_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the asset', 'id'=>'name']) !!}
                  @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price', 'Price', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::text('price',null,['class'=>'form-control', 'placeholder'=>'Price of the asset', 'id'=>'price']) !!}
                  @if ($errors->has('price'))
                    <span class="help-block">
                      <strong>{{ $errors->first('price') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', 'Description', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  {!! Form::textarea('description',null,['class'=>'form-control', 'placeholder'=>'Description of the asset', 'id'=>'description']) !!}
                  @if ($errors->has('description'))
                    <span class="help-block">
                      <strong>{{ $errors->first('description') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                  {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  <a href="{{ url('master-data/asset-category') }}" class="btn btn-default">
                    <i class="fa fa-repeat"></i>&nbsp;Cancel
                  </a>&nbsp;
                  <button type="submit" class="btn btn-info" id="btn-submit-asset-category">
                    <i class="fa fa-save"></i>&nbsp;Submit
                  </button>
                </div>
              </div>
              {!! Form::close() !!}
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
          
          </div>
        </div><!-- /.box -->
    </div>
  </div>


  
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    
    //Block Asset Category Selection
    $('#asset_category_id').select2({
      placeholder: 'AssetCategory',
      ajax: {
        url: '{!! url('select2AssetCategory') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.name,
                      id: item.id,
                  }
              })
          };
        },
        cache: true
      },
      allowClear : true,
      templateResult : templateResultAssetCategorySelection,
    }).on('select2:select', function(){
      var selected = $('#asset_category_id').select2('data')[0];
    });

    function templateResultAssetCategorySelection(results){
      if(results.loading){
        return "Searching...";
      }
      var markup = '<span>';
          markup+=  results.text;
          // markup+=  '<br/>'+results.customer.name;
          markup+= '</span>';
      return $(markup);
    }
    //ENDBlock Asset Category Selection
  </script>
@endsection