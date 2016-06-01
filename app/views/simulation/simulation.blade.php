@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('simulation/_simulation-sidebar')

{{-- Page content --}}
@section('content')
<!-- start of page content -->
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Simulation of Attrition <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>Choose individual factor for simulation of attrition rate.</h4> <br>
                <center>
                    <div class="col-md-12">
                    	<a href="/simulation/employment" class="btn btn-primary btn-lg col-md-5">Employment</a>
                    	<div class="col-md-2"></div>
                    	<a href="/simulation/grades" class="btn btn-danger btn-lg col-md-5">Grades</a>
                    </div>
                    <div class="col-md-12" style="height:20px"></div>
                    <div class="col-md-12">
                    	<a href="/simulation/region" class="btn btn-success btn-lg col-md-5">Region</a>
                    	<div class="col-md-2"></div>
                    	<a href="/simulation/stbracket" class="btn btn-info btn-lg col-md-5">ST Bracket</a>
                    </div>
                    <div class="col-md-12" style="height:20px"></div>
                    <div class="col-md-12">
                    	<a href="/simulation/units" class="btn btn-warning btn-lg col-md-5">Units</a>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>

@stop
<!-- /. ROW  -->

@section('javascript')

@stop
