@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('college/_college-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Department <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Overall -->
@include('college/_college-main-graphs')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                View attrition for a specific department
            </div>
            <div class="panel-body">
                </br>
                <h4>Choose a department</h4>
                <!--Dropdown for prompt-->
                {{ Form::open(array('action' => 'CollegeController@showSpecificCollege')) }}
                  <div class="input-group">
                    <select class="form-control" required="required" id="college-dropdown" name="college-dropdown">
                        @foreach($collegelist as $college){
                            <option value={{ $college->unitid }}>{{ $college->unitname }}</option>
                        }
                        @endforeach
                    </select>
                  </div>
                  <br/>
                  <button type="submit" class="btn btn-default">View Department</button>
                {{ Form::close() }}
                <!-- end of dropdown -->
            </div>
        </div>
    </div>
</div>

@stop
<!-- /. ROW  -->

@section('javascript')


@include('college/scripts/_college-main-scripts')







@stop
