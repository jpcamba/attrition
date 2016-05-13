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
            Simulation of Attrition Using Grades <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Input and Results Charts -->
@include('simulation/grades/_grades-total')

@stop

@section('javascript')

@include('simulation/grades/scripts/_grades-total-scripts')

@stop