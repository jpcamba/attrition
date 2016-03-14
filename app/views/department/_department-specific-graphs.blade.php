<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Average Attrition Rate</h4>
                    Students from this department who dropped out
                    <div id="department-ave-attrition"><h1>{{ $aveAttrition }} %</h1></div>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Average Shift Rate</h4>
                    Students shifting to another department
                    <div id="department-ave-shiftrate"><h1>{{ $aveShiftRate }} %</h1></div>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Attrition
            </div>
            <div class="panel-body">
                <div id="department-total-attrition"></div>
                <center>
                    <h4>Attrition rate for each batch</h4>
                    <div id="department-ave-batch-attrition"></div>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Overall
            </div>
            <div class="panel-body">
                <div id="department-total-dropouts"></div>
                <center>
                    <h4>Average number of students per year</h4>
                    <div id="department-yearly-number-students"></div>
                    <!--<h4>Difference between semesters per year</h4>
                    <div id="department-yearly-sem-difference"></div>-->
                </center>
            </div>
        </div>
    </div>
</div>
