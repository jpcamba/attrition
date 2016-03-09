@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('correlation/_correlation-sidebar')

{{-- Page content --}}
@section('content')
<!-- start of page content -->
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Correlation of Factors <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Overall -->
@include('correlation/_correlation-total')

<!-- end content section -->

@stop
<!-- /. ROW  -->

@section('javascript')

@include('correlation/scripts/_correlation-total-scripts')

@stop
