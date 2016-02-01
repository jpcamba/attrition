@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('simulation/units/_units-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Simulation (Units) <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            Get estimates of <strong>Total Attrition Rate</strong> and <strong>Total Number of
            Dropouts</strong> from user-inputted student <strong>Semester Unit Range</strong> percentages.
        </div>
    </div>
</div>

<!-- Housing Type Input -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Enter percentages of students for each Semester Unit Range.
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <form role="form" id="under-form">
                            <div class="form-group input-group">
                                <input type="number" id="under" class="form-control" placeholder="Less than 15 Units" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form role="form" id="normal-form">
                            <div class="form-group input-group">
                                <input type="number" id="normal" class="form-control" placeholder="15-21 Units" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form role="form" id="over-form">
                            <div class="form-group input-group">
                                <input type="number" id="over" class="form-control" placeholder="More than 21 Units" style="height:100px">
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
        var under = parseInt($('#under').val(), 10);
        var normal = parseInt($('#normal').val(), 10);
        var over = parseInt($('#over').val(), 10);
        var sum = under + normal + over;

        if (sum != 100) {
            $('#validator').modal('show');
        }

        else {
            $('#values').empty();

            Morris.Donut({
                element: 'values',
                data: [
                    {label: "Less than 15 Units", value: under},
                    {label: "15-21 Units", value: normal},
                    {label: "More than 21 Units", value: over}
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
        document.getElementById('under-form').reset();
        document.getElementById('normal-form').reset();
        document.getElementById('over-form').reset();
    }
</script>

@stop