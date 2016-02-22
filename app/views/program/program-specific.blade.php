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
            {{ $program->programtitle }} <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Overall -->
@include('program/_program-specific-graphs')



@stop
<!-- /. ROW  -->

@section('javascript')


@include('program/scripts/_program-specific-scripts')







@stop
