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
            Simulation of Attrition Using ST Bracket
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
            Get estimate of <strong>Average Attrition Rate</strong> from user-inputted student <strong>ST Bracket</strong> percentages.
        </div>
    </div>
</div>

<!-- Housing Type Input -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Enter percentages of students for each ST Discount Bracket.
            </div>
            <div class="panel-body">
                {{Form::open(array('role' => 'form', 'action' => 'SimulationController@postStbracket'))}}
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="nd" name="nd" class="form-control" placeholder="ND" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="pd33" name="pd33" class="form-control" placeholder="PD 33" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="pd60" name="pd60" class="form-control" placeholder="PD 60" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="pd80" name="pd80" class="form-control" placeholder="PD 80" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="fd" name="fd" class="form-control" placeholder="FD" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="fds" name="fds" class="form-control" placeholder="FD with Stipend" style="height:100px">
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