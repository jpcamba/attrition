<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Years Required</h4>
                    <div id="program-required-years"><h2>{{ $program->numyears }}</h2></div>
                </center>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Average Years of Stay</h4>
                    <div id="program-ave-years"><h2>{{ $aveYearsOfStay }}</h2></div>
                </center>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Years Before Shifting Out</h4>
                    <div id="program-shift-years"><h2>{{ $aveYearsBeforeShifting }}</h2></div>
                </center>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Years Before Dropping Out</h4>
                    <div id="program-shift-years"><h2>{{ $aveYearsBeforeDropout }}</h2></div>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"> </br>
            </div>
            <div class="panel-body">
                <div id="program-rates"></div>
                <center>
                    <h4>Overall Rates</h4>
                    <div id="program-division"></div>
                    </br></br>
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
                <div id="program-total-dropouts"></div>
                <center>
                    <h4>Average Batch Attrition Rate</h4>
                    <div id="program-ave-attrition"><h1>{{ $aveAttrition }} %</h1></div>
                    </br></br>
                    <h4>Attrition Rate per Batch</h4>
                    <div id="program-ave-attrition-batch"></div>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Shifting
            </div>
            <div class="panel-body">
                <div id="program-total-dropouts"></div>
                <center>
                    <h4>Average Batch Shift Rate</h4>
                    <div id="program-ave-shift"><h1>{{ $aveShiftRate }} %</h1></div>
                    </br></br>
                    <h4>Attrition Shift Rate per Batch</h4>
                    <div id="program-ave-shift-batch"></div>
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
                <div id="program-total-dropouts"></div>
                <center>
                    <h4>Average number of students per year</h4>
                    <div id="program-yearly-number-students"></div>
                    </br></br>
                    <h4>Difference between semesters per year</h4>
                    <div id="program-yearly-sem-difference"></div>
                </center>
            </div>
        </div>
    </div>
</div>
