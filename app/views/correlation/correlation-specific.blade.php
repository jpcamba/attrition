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
            Correlation of Factors
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<div class="row">
    <div class="col-md-12" id="chart-warning"></div>
</div>

<!-- Overall -->
<div class="row">
    <div class="col-md-12">
        <!-- Chart -->
        <div class="panel panel-default">
            <div class="panel-heading"><h3>{{$levelName}}</h3></div>
            <div class="panel-body">
                <center>
                    <div id="specific-chart"></div>
                    <h5>The greatest slice represents the factor that is most strongly correlated with attrition. The numerical value displayed is the absolute value of the factor's correlation value.</h5>
                    *Factors with irrelevant correlation values have been removed for better analysis.
                </center>
            </div>
        </div>

        <!-- Explanation of Factors -->
        <div class="panel panel-primary">
            <div class="panel-heading"><h5>Explanation of Factors</h5></div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>Positive Correlation</th><th>Negative Correlation</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Employment</td> <td>High Grades</td></tr>
                            <tr><td>Low Grades</td> <td>Unemployment</td></tr>
                            <tr><td>ST Bracket</td> <td></td></tr>
                            <tr><td>Region</td> <td></td></tr>
                            <tr><td>Underloading Units</td> <td></td></tr>
                            <tr><td>Overloading Units</td> <td></td></tr>
                        </tbody>
                    </table>
                </div>
                <b>Positive Correlation: </b> An increase in this factor corresponds to an <b>increase</b> in attrition rate. <br>
                <b>Negative Correlation: </b> An increase in this factor corresponds to a <b>decrease</b> in attrition rate.
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <center>
            <a href="/correlation" class="btn btn-success btn-lg">Return to Main Correlation Page</a>
        </center>
    </div>
</div>
<!-- end content section -->

@stop
<!-- /. ROW  -->

@section('javascript')

@include('correlation/scripts/_correlation-specific-scripts')

@stop
