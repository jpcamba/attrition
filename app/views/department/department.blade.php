@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('department/_department-sidebar')

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
@include('department/_department-main-graphs')

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
                {{ Form::open(array('action' => 'DepartmentController@showSpecificDepartment')) }}
                  <div class="input-group">
                    <select class="form-control" required="required" id="department-dropdown" name="department-dropdown">
                        @foreach($departmentlist as $department){
                            <option value={{ $department->unitid }}>{{ $department->unitname }}</option>
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


@include('department/scripts/_department-main-scripts')







@stop
