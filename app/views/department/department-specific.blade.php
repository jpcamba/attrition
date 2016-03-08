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
            {{ $department->unitname }} <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Overall -->
@include('department/_department-specific-graphs')

<!-- Programs -->
@include('department/_department-programs')




@stop
<!-- /. ROW  -->

@section('javascript')


@include('department/scripts/_department-specific-scripts')







@stop
