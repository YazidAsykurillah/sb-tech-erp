@extends('layouts.app')

@section('page_title')
  Dashboard SB TECH
@endsection

@section('page_header')
  <h1>
    Dashboard
    <small></small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="active"><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
        	<div class="box-header with-border">
            	<h3 class="box-title">Welcome</h3>
          	</div>
            <div class="box-body">
            	<p>Please use the menu on the left to navigate your modules</p>
            </div>
        </div>
    </div>
</div>

@endsection
