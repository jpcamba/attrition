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
            {{ $college->unitname }} <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Overall -->
@include('college/_college-specific-graphs')

<!-- Programs -->
@include('college/_college-programs')




@stop
<!-- /. ROW  -->

@section('javascript')


@include('college/scripts/_college-specific-scripts')







@stop
