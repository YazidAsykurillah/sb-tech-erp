@extends('layouts.app')

@section('page_title')
    Templates
@endsection

@section('page_header')
  <h1>
    Templates
    <small>Daftar Templates</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('templates') }}"><i class="fa fa-briefcase"></i> Template</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Templates</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" id="table-templates">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th>Template Name</th>
                      <th style="width:10%;text-align:center;">Download</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td>ETS OFFICE</td>
                      <td style="text-align:center;">
                        <a href="{{ url('templates/download/?file_name=ets_office') }}" class="btn btn-info"><i class="fa fa-download"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>ETS SITE</td>
                      <td style="text-align:center;">
                        <a href="{{ url('templates/download/?file_name=ets_site') }}" class="btn btn-info"><i class="fa fa-download"></i></a>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            
          </div>
        </div><!-- /.box -->
    
    </div>
  </div>

@endsection

@section('additional_scripts')
  
@endsection