@extends('layouts.app')

@section('page_title')
    Delivery Order
@endsection

@section('page_header')
  <h1>
    Delivery Order
    <small>Create Delivery Order</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('delivery-order') }}"><i class="fa fa-truck"></i> Delivery Order</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    {!! Form::open(['route'=>'delivery-order.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-delivery-order','files'=>true]) !!}
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Project</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
            {!! Form::label('project_id', 'Project', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
             <select name="project_id" id="project_id" class="form-control">
                @if(Request::old('project_id') != NULL)
                  <option value="{{Request::old('project_id')}}">
                    {{ \App\Project::find(Request::old('project_id'))->code }}
                  </option>
                @endif
              </select>
              @if ($errors->has('project_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('project_id') }}</strong>
                </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('sender_id') ? ' has-error' : '' }}">
            {!! Form::label('sender_id', 'PIC', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              <select name="sender_id" id="sender_id" class="form-control">
                @if(Request::old('sender_id') != NULL)
                  <option value="{{Request::old('sender_id')}}">
                    {{ \App\User::find(Request::old('sender_id'))->name }}
                  </option>
                @endif
              </select>
              @if ($errors->has('sender_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('sender_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          
          <!-- Group items -->
          <div class="form-group">
            {!! Form::label('item', 'Item(s)', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-8">
              <div class="table-responsive">
                <table id="table-items" class="table">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th style="width:25%;">Qty</th>
                      <th style="width:5%">
                        <button id="btn-add-item" class="btn btn-primary btn-xs" type="button">Add Item</button>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="table_items_body">
                    <!-- Build row items from occured item validation error-->
                    @if(Form::old('item'))
                       @foreach(old('item') as $key => $val)
                          <tr id="row_index_{{$key}}">
                            <td class="{{ $errors->has('item.'.$key.'') ? ' has-error' : '' }}">
                              <select name="item[{{ $key }}]" class="form-control select-item">
                                @if(Request::old('item.'.$key.'') != NULL)
                                  <option selected="selected" value="{{Request::old('item.'.$key.'')}}">
                                    {{ \DB::table('item_purchase_request')->where('id','=',Request::old('item.'.$key.''))->first()->item }}
                                  </option>
                                @else
                                  <option selected="selected" hidden="hidden" value="">Select Item</option>
                                @endif
                              </select>
                               @if ($errors->has('item.'.$key.''))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('item.'.$key.'') }}</strong>
                                  </span>
                                @endif
                            </td>
                            <td class="{{ $errors->has('quantity.'.$key.'') ? ' has-error' : '' }}">
                              <input type="text" name="quantity[{{$key}}]" class="form-control quantity" value="{{ old('quantity.'.$key) }}" />
                              @if ($errors->has('quantity.'.$key.''))
                                <span class="help-block">
                                  <strong>{{ $errors->first('quantity.'.$key.'') }}</strong>
                                </span>
                              @endif
                            </td>
                            @if($key !=0)
                            <td>
                              <button class="btn btn-danger btn-xs btn-remove-item" type="button">
                                <i class="fa fa-trash"></i>
                              </button>
                            </td>
                            @endif
                          </tr>
                      @endforeach
                    <!-- Build row items from NOT occured item validation error / The page load at very first-->
                    @else
                      <tr id="row_index_0">
                        <td class="{{ $errors->has('item.0') ? ' has-error' : '' }}">
                          <select name="item[0]" class="form-control select-item">
                            <option selected="selected" hidden="hidden" value="">item</option>
                          </select>
                           @if ($errors->has('item.0'))
                              <span class="help-block">
                                <strong>{{ $errors->first('item.0') }}</strong>
                              </span>
                            @endif
                        </td>
                        <td>
                          <input type="text" name="quantity[0]" class="form-control quantity" value="{{ old('quantity.0') }}" />
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-sm-2">
              <select name="build_item_from_purchase_request" id="build_item_from_purchase_request" style="width:100%;">
              </select>
            </div>
          </div>
          <!-- ENDGroup items -->
          <div class="form-group">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('delivery-order') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-delivery-order">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
        </div>
      </div><!-- /.box-body -->
    </div>
   
    {!! Form::close() !!}
  </div>

  
@endsection

@section('additional_scripts')
  
<script type="text/javascript">
  //Block Select2 Project
  $('#project_id').select2({
    placeholder: 'Select Project',
    ajax: {
      url: '{!! url('project/select2ForDeliveryOrder') !!}',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
                return {
                    text: item.code,
                    id: item.id,
                    customer_name: item.customer_name
                }
            })
        };
      },
      cache: true
    },
    allowClear:true,
    templateResult : templateResultProject,
  });

  function templateResultProject(results){
    if(results.loading){
      return "Searching...";
    }
    var markup = '<span>';
        markup+=  results.text;
        markup+= '<br/>';
        markup+=  results.customer_name;
        markup+= '</span>';
    return $(markup);
  }
  //END Block Select2 Project


  //Block Select2 Sender ID
  $('#sender_id').select2({
    placeholder: 'Select PIC',
    ajax: {
      url: '{!! url('select2User') !!}',
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
    allowClear:true,
    templateResult : templateResultSender,
  });

  function templateResultSender(results){
    if(results.loading){
      return "Searching...";
    }
    var markup = '<span>';
        markup+=  results.text;
        markup+= '</span>';
    return $(markup);
  }
  //END Block Select2 Sender ID

  //Block Button add item handling
  var index_initiator = 0;
  $('#btn-add-item').on('click', function(){
    index_initiator+=1;
    var row_item = '<tr id="row_index_'+index_initiator+'">'+
                      '<td>'+
                        '<select name="item['+index_initiator+']" class="form-control select-item">'+
                          '<option selected="selected" hidden="hidden" value="">item</option>'+
                        '</select>'+
                      '</td>'+
                      '<td><input type="text" name="quantity[]" class="form-control quantity" /></td>'+
                      '<td><button class="btn btn-danger btn-xs btn-remove-item" type="button"><i class="fa fa-trash"></i></button></td>'+
                    '</tr>';
    $('#table-items').find('tbody').append(row_item);
    $('#table-items').find('tr td button.btn-remove-item').on('click', function(){
      remove_row($(this));
    });
    initSelect2ForItem();
  });
  //ENDBlock Button add item handling
  //Block register .btn-remove-item event handler [After validation fails from the server]
  $('#table-items').find('tr td button.btn-remove-item').on('click', function(){
    remove_row($(this));
  });
  //ENDBlock register .btn-remove-item event handler [After validation fails from the server]

  //Block function to remove additional row
  function remove_row(obj){
    $(obj).parent().parent().remove();
  }
  //ENDBlock function to remove additional row

  function initSelect2ForItem(){
    //Block Select2 Item
    $('.select-item').select2({
      placeholder: 'Select Item',
      ajax: {
        url: '{!! url('purchase-request/select2Items') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.item,
                      id: item.id,
                  }
              })
          };
        },
        cache: true
      },
      allowClear:true,
      templateResult : templateResultItem,
    });
  }
  
  function templateResultItem(results){
    if(results.loading){
      return "Searching...";
    }
    var markup = '<span>';
        markup+=  results.text;
        markup+= '</span>';
    return $(markup);
  }
  //END Block Select2 Item

  //fire select2 initialization to class item
  initSelect2ForItem();


  //Build Item from Purchase Request
  //Block Copy items from purchase request
    $('#build_item_from_purchase_request').select2({
      placeholder: 'Copy items from Purchase Request',
      ajax: {
        url: '{!! url('select2PurchaseRequestToCopyItems') !!}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                      text: item.code,
                      id: item.id,
                      the_items : item.the_items
                  }
              })
          };
        },
        cache: true,
      },
      allowClear:true
    }).on('select2:select', function(){
      run_build_item_from_purchase_request($(this).val());
    });

    function run_build_item_from_purchase_request(purchase_request_id){
      //$('#table-items').find('tbody').find('tr#row_index_0').remove();
      var purchase_request_id = purchase_request_id;
      $.ajax({
        url : '{!! url('getPurchaseRequestItems') !!}',
        type : 'GET',
        data : 'purchase_request_id='+purchase_request_id,
        beforeSend : function(){},
        success : function(response){
          if(response.length > 0){
            $('#table-items').find('tbody').find('tr#row_index_0').remove();
            $.each(response, function(idx, obj) {
              index_initiator+=1;
              var row_item = '<tr id="row_index_'+index_initiator+'">'+
                                '<td>'+
                                  '<select name="item['+index_initiator+']" class="form-control select-item">'+
                                    '<option selected="selected" value="'+obj.id+'">'+obj.item+'</option>'+
                                  '</select>'+
                                '</td>'+
                                '<td><input type="text" name="quantity['+index_initiator+']" class="form-control quantity" value="'+obj.quantity+'"/></td>'+
                                '<td><button class="btn btn-danger btn-xs btn-remove-item" type="button"><i class="fa fa-trash"></i></button></td>'+
                              '</tr>';
              $('#table-items').find('tbody').append(row_item);
              $('#table-items').find('tr td button.btn-remove-item').on('click', function(){
                remove_row($(this));
              });

            });
          }
         
        }
      });
    }

  //ENDBuild Item from Purchase Request
  $('#form-create-delivery-order').on('submit', function(event){
    $('#btn-submit-delivery-order').prop('disabled', true);
  });
</script>
@endsection