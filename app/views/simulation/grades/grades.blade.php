@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('simulation/grades/_grades-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Simulation (Grades) <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            Get estimates of <strong>Total Attrition Rate</strong> and <strong>Total Number of
            Dropouts</strong> from user-inputted student <strong>Grade Range</strong> percentages.
        </div>
    </div>
</div>

<!-- Grade Range Input -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Enter percentages of students for each Grade Range.
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <form role="form" id="l1-form">
                            <div class="form-group input-group">
                                <input type="number" id="lineof1" class="form-control" placeholder="1.00-1.99" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form role="form" id="l2-form">
                            <div class="form-group input-group">
                                <input type="number" id="lineof2" class="form-control" placeholder="2.00-2.99" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form role="form" id="l3-form">
                            <div class="form-group input-group">
                                <input type="number" id="lineof3" class="form-control" placeholder="3.00-3.99" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form role="form" id="l4-form">
                            <div class="form-group input-group">
                                <input type="number" id="lineof4" class="form-control" placeholder="4.00-5.00" style="height:100px">
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
        var l1 = parseInt($('#lineof1').val(), 10);
        var l2 = parseInt($('#lineof2').val(), 10);
        var l3 = parseInt($('#lineof3').val(), 10);
        var l4 = parseInt($('#lineof4').val(), 10);
        var sum = l1 + l2 + l3 + l4;

        if (sum != 100) {
            $('#validator').modal('show');
        }

        else {
            $('#values').empty();

            Morris.Donut({
                element: 'values',
                data: [
                    {label: "1.00-1.99", value: l1},
                    {label: "2.00-2.99", value: l2},
                    {label: "3.00-3.99", value: l3},
                    {label: "4.00-5.00", value: l4}
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
        document.getElementById('l1-form').reset();
        document.getElementById('l2-form').reset();
        document.getElementById('l3-form').reset();
        document.getElementById('l4-form').reset();
    }
</script>

@stop