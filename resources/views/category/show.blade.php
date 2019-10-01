@extends('layouts.app')

@section('page_title')
    Category
@endsection

@section('page_header')
  <h1>
    Category
    <small>Category Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-database"></i> Master Data</a></li>
    <li> <a href="{{ url('master-data/category')}}">Category</a></li>
    <li class="active"><a href="{{ URL::to('master-data/category/'.$category->id) }}"> {{ $category->name }} </a></li>
  </ol>
@endsection

@section('content')

  <div class="row">
    <div class="col-md-7">
      <!--BOX Basic Informations-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-database"></i>&nbsp;Category Information</h3>
          <a href="{{ URL::to('master-data/category/'.$category->id.'/edit')}}" class="btn btn-success btn-xs pull-right" title="Click to edit this category">
            <i class="fa fa-edit"></i>&nbsp;Edit
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table">

              <tr>
                <td style="width: 20%;">Category Name</td>
                <td style="width: 1%;">:</td>
                <td>{{ $category->name }}</td>
              </tr>
              <tr>
                <td style="width: 20%;">Description</td>
                <td style="width: 1%;">:</td>
                <td>{{ nl2br($category->description) }}</td>
              </tr>
            </table>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

    <div class="col-md-5">
      <!--BOX Sub Category-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-database"></i>&nbsp;Sub Category</h3>
          <button id="btn-add-sub-category" class="btn btn-xs pull-right" title="Click to add sub category"><i class="fa fa-plus"></i></button>
        </div><!-- /.box-header -->
        <div class="box-body">
          @if(count($category->sub_categories))
            <ul class="list-group">
            @foreach($category->sub_categories as $sub_category)
              <div href="#" class="list-group-item">
                {{ $sub_category->name }}
                <span class="pull-right">
                  <a href="{{ URL::to('master-data/sub-category/'.$sub_category->id.'/edit') }}" class="btn btn-success btn-xs btn-edit-sub-category" title="Click to edit this sub category"><i class="fa fa-pencil"></i></a>
                  <button class="btn btn-danger btn-xs btn-delete-sub-category" data-id="{{ $sub_category->id }}" data-text="{{ $sub_category->name }}" title="Click to delete this sub category"><i class="fa fa-trash"></i></button>
                </span>
              </div>
            @endforeach
            </ul>
          @else
            <p class="alert alert-info">
              There is no sub category
            </p>
          @endif
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Sub Category-->
    </div>

  </div>


  <!--Modal Add Sub Category-->
  <div class="modal fade" id="modal-add-sub-category" tabindex="-1" role="dialog" aria-labelledby="modal-add-sub-categoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['route'=>'master-data.sub-category.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-sub-category','files'=>true]) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-add-sub-categoryLabel">Add Sub Category</h4>
        </div>
        <div class="modal-body">
          <div class="form-group{{ $errors->has('subCategoryName') ? ' has-error' : '' }}" id="subCategoryNameGroup">
            {!! Form::label('subCategoryName', 'Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10" id="subCategoryNameBlock">
              {!! Form::text('subCategoryName',null,['class'=>'form-control', 'placeholder'=>'Name of the sub category', 'id'=>'subCategoryName']) !!}
              @if ($errors->has('subCategoryName'))
                <span class="help-block" >
                  <strong>{{ $errors->first('subCategoryName') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('subCategoryDescription') ? ' has-error' : '' }}" id="subCategoryDescriptionGroup">
            {!! Form::label('subCategoryDescription', 'Description', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10" id="subCategoryDescriptionBlock">
              {!! Form::textarea('subCategoryDescription',null,['class'=>'form-control', 'placeholder'=>'Description of the sub category', 'id'=>'subCategoryDescription']) !!}
              @if ($errors->has('subCategoryDescription'))
                <span class="help-block">
                  <strong>{{ $errors->first('subCategoryDescription') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="category_id" name="category_id" value="{{ $category->id}}" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Save</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Add Sub Category-->
  
  <!--Modal Delete Sub Category-->
  <div class="modal fade" id="modal-delete-sub-category" tabindex="-1" role="dialog" aria-labelledby="modal-delete-sub-categoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteSubCategory', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-sub-categoryLabel">Delete Sub Category</h4>
        </div>
        <div class="modal-body">
          <p>You are going to delete <strong><span id="subCategoryNameToDelete"></span></strong></p>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="sub_category_id" name="sub_category_id" value="" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Sub Category-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    //Add Sub Category handler
    $('#btn-add-sub-category').on('click', function(){
      $('#modal-add-sub-category').modal('show');
    });
    //EndAdd Sub Category handler

    //Form Sub Category submission
    $('#form-create-sub-category').on('submit', function(event){
      event.preventDefault();
      var url = $(this).attr('action');
      $('#subCategoryNameBlock').find('.help-block').remove();
      $('#subCategoryDescriptionBlock').find('.help-block').remove();
      $.ajax({
        type: 'post',
        url: url,
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data){
          if(data == true){
            location.reload();
          }
          else{
            console.log(data);
          }
        },
        error: function(data){
          var errors = data.responseJSON;
          console.log(errors);
          if(errors.subCategoryName){
            $('#subCategoryNameGroup').addClass('has-error');
            $('#subCategoryNameBlock').append('<span class="help-block">'+errors.subCategoryName[0]+'</span>');
          }
          else{
            $('#subCategoryNameGroup').removeClass('has-error');
            $('#subCategoryNameBlock').find('.help-block').remove();
          }
          if(errors.subCategoryDescription){
            $('#subCategoryDescriptionGroup').addClass('has-error');
            $('#subCategoryDescriptionBlock').append('<span class="help-block">'+errors.subCategoryDescription[0]+'</span>');
          }
          else{
            $('#subCategoryDescriptionGroup').removeClass('has-error');
            $('#subCategoryDescriptionBlock').find('.help-block').remove();
          }
          
          // Render the errors with js ...
        }
      });
    });
    //ENDForm Sub Category submission

    //Delete Sub Category handler
    $('.btn-delete-sub-category').on('click', function(){
      $('#sub_category_id').val($(this).attr('data-id'));
      $('#subCategoryNameToDelete').text($(this).attr('data-text'));
      $('#modal-delete-sub-category').modal('show');
    });
    //EndDelete Sub Category handler
  </script>
@endsection