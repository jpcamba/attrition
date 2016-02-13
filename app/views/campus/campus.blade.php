@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('campus/_campus-sidebar')

{{-- Page content --}}
@section('content')
<!-- start of page content -->
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Campus <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Overall -->
@include('campus/_campus-total')




<div class="row">
    <div class="col-md-12">
        <h3 class="page-header">
            Trends of Factors
        </h3>
    </div>
</div>

<!-- end content section -->




@stop
<!-- /. ROW  -->

@section('javascript')


@include('campus/scripts/_campus-total-scripts')







@stop
