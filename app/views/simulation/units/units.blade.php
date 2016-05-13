@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('simulation/_simulation-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Simulation of Attrition Using Units
        </h1>
    </div>
</div>
<!-- /. ROW  -->

@if ($error)
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <strong>Invalid input.</strong> Sum of input values should be equal to 100%.
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            Get estimate of <strong>Average Attrition Rate</strong> from user-inputted student <strong>Unit Range</strong> percentages.
        </div>
    </div>
</div>

<!-- Employment Type Input -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Enter percentages of students for each Employment Type.
            </div>
            <div class="panel-body">
                {{Form::open(array('role' => 'form', 'action' => 'SimulationController@postUnits'))}}
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="underload" name="underload" class="form-control" placeholder="Underload" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="regular" name="regular" class="form-control" placeholder="Regular" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="overload" name="overload" class="form-control" placeholder="Overload" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <center>
                            <button type="submit" class="btn btn-success" id="simulate">Simulate</button>
                        </center>
                    </div>
                {{Form::close()}}
            </div>
        </div>
    <div>
</div>

@stop

@section('javascript')

@stop