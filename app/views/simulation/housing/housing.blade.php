@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('simulation/housing/_housing-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Simulation (Housing) <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            Get estimates of <strong>Total Attrition Rate</strong> and <strong>Total Number of
            Dropouts</strong> from user-inputted student <strong>Housing Type</strong> percentages.
        </div>
    </div>
</div>

<!-- Housing Type Input -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Enter percentages of students for each Housing Type.
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <form role="form" id="dorm-form">
                            <div class="form-group input-group">
                                <input type="number" id="dorm" class="form-control" placeholder="UP Dormitory" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form role="form" id="own-form">
                            <div class="form-group input-group">
                                <input type="number" id="own" class="form-control" placeholder="Own House" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form role="form" id="on-form">
                            <div class="form-group input-group">
                                <input type="number" id="on-campus" class="form-control" placeholder="Boarding House On-Campus" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4">
                        <form role="form" id="off-form">
                            <div class="form-group input-group">
                                <input type="number" id="off-campus" class="form-control" placeholder="Boarding House Off-Campus" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form role="form" id="rented-form">
                            <div class="form-group input-group">
                                <input type="number" id="rented" class="form-control" placeholder="Rented House" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form role="form" id="relative-form">
                            <div class="form-group input-group">
                                <input type="number" id="relative" class="form-control" placeholder="Relative's/Guardian's House" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <center>
                            <a class="btn btn-success" id="simulate">Simulate</a>
                        </center>
                    </div>
                    <div class="col-md-6">
                        <center>
                            <button class="btn btn-danger" id="clear" onclick="clearForm()">Clear</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    <div>
</div>

<!-- User Values Panel -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Showing Simulation for</div>
            <div class="panel-body">
                <div id="values"></div>
            </div>
        </div>
    </div>
</div>

<!-- Total Number of Dropouts/Attrition Rate Panel -->
<div class="row">
    <div class="col-md-6" id="result">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Total Attrition Rate</h4>
                    <h1>
                        <div id="rate"></div>
                    </h1>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Total Number of Dropouts</h4>
                    <h1>
                        <div id="dropouts"></div>
                    </h1>
                </center>
            </div>
        </div>
    </div>
</div>

<!-- Validator Modal -->
<div class="modal fade" id="validator" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Please make sure total is equal to 100%.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('javascript')

<script type="text/javascript">
    //Refresh and show results
    function showGraphs() {
        //Total Rate
        var rateRand = Math.floor(Math.random() * (100 - 0 + 1)) + 0;
        $('#rate').empty();
        $('#rate').append(rateRand + '%');
        
        //Total Dropouts
        $('#dropouts').empty();
        $('#dropouts').append(Math.floor(Math.random() * (3000 - 1000 + 1)) + 1000);
    }

    //On Simulate Button Click
    $('#simulate').click(function() {
        var dorm = parseInt($('#dorm').val(), 10);
        var own = parseInt($('#own').val(), 10);
        var onCampus = parseInt($('#on-campus').val(), 10);
        var offCampus = parseInt($('#off-campus').val(), 10);
        var rented = parseInt($('#rented').val(), 10);
        var relative = parseInt($('#relative').val(), 10);
        var sum = dorm + own + onCampus + offCampus + rented + relative;

        if (sum != 100) {
            $('#validator').modal('show');
        }

        else {
            $('#values').empty();

            Morris.Donut({
                element: 'values',
                data: [
                    {label: "UP Dormitory", value: dorm},
                    {label: "Own House", value: own},
                    {label: "Boarding House On-Campus", value: onCampus},
                    {label: "Boarding House Off-Campus", value: offCampus},
                    {label: "Rented House", value: rented},
                    {label: "Relative's/Guardian's House", value: relative}
                ]
            });

            showGraphs();
            window.location.here = '#values';
            window.location.here = '#values';
            window.location.hash = '#values';
        }
    });

    //Clear Form
    function clearForm() {
        document.getElementById('dorm-form').reset();
        document.getElementById('own-form').reset();
        document.getElementById('on-form').reset();
        document.getElementById('off-form').reset();
        document.getElementById('rented-form').reset();
        document.getElementById('relative-form').reset();
    }
</script>

@stop