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
            Simulation of Attrition Using Region
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
            Get estimate of <strong>Average Attrition Rate</strong> from user-inputted student <strong>Region of Residence</strong> percentages.
        </div>
    </div>
</div>

<!-- Grade Range Input -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Enter percentages of students for each Region.
            </div>
            <div class="panel-body">
                {{Form::open(array('role' => 'form', 'action' => 'SimulationController@postRegion'))}}
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="luzon" name="luzon" class="form-control" placeholder="Luzon" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="visayas" name="visayas" class="form-control" placeholder="Visayas" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group input-group">
                                <input type="number" id="mindanao" name="mindanao" class="form-control" placeholder="Mindanao" style="height:100px">
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
    </div>
</div>

@stop

@section('javascript')

@stop