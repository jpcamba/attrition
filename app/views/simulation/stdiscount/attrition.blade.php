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
            Simulation of Attrition Using ST Bracket
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Input and Results Charts -->
@include('simulation/stdiscount/_stdiscount-total')

@stop

@section('javascript')

@include('simulation/stdiscount/scripts/_stdiscount-total-scripts')

@stop