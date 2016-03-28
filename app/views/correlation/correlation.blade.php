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
<div class="row">
    <div class="col-md-12">
        <!-- Chart -->
        @include('correlation/_correlation-total')

        <div class="panel panel-primary">
            <div class="panel-heading"><h5>Explanation of Factors</h5></div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item"><b>Employment </b>The higher the number of unemployed students, the lower the attrition rate.</li>
                    <li class="list-group-item"><b>Grades </b>The higher the number of students with passing grades (GWA 3.00 and above), the lower the attrition rate.</li>
                    <li class="list-group-item"><b>Overloading </b>The higher the number of students with overloading units (18 units and above), the higher the attrition rate.</li>
                    <li class="list-group-item"><b>Region </b>The higher the number of students from distant hometowns (Visayas and Mindanao), the higher the attrition rate.</li>
                    <li class="list-group-item"><b>ST Bracket </b>The higher the number of students with high ST Bracket (A and B), the higher the attrition rate.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- end content section -->

@stop
<!-- /. ROW  -->

@section('javascript')

@include('correlation/scripts/_correlation-total-scripts')

@stop
