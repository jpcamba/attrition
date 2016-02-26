@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('program/_program-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Program <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Overall -->
@include('program/_program-main-graphs')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                View attrition for a specific program
            </div>
            <div class="panel-body">
                </br>
                <h4>Choose a program</h4>
                <!--Dropdown for prompt-->
                {{ Form::open(array('action' => 'ProgramController@showSpecificProgram')) }}
                  <div class="input-group">
                    <select class="form-control" required="required" id="program-dropdown" name="program-dropdown">
                        @foreach($programlist as $program){
                            <option value={{ $program->programid }}>{{ $program->programtitle }}</option>
                        }
                        @endforeach
                    </select>
                  </div>
                  <br/>
                  <button type="submit" class="btn btn-default">View Program</button>
                {{ Form::close() }}
                <!-- end of dropdown -->
            </div>
        </div>
    </div>
</div>

@stop
<!-- /. ROW  -->

@section('javascript')


@include('program/scripts/_program-main-scripts')





@stop
