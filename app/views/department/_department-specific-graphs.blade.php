<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Average Attrition Rate</h4>
                    Students from this department who dropped out
                    <div id="department-ave-attrition"><h1>{{ $aveAttrition }} %</h1></div><br/>
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
                    <div id="department-ave-shiftrate"><h1>{{ $aveShiftRate }} %</h1></div><br/>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Years Before Dropping Out</h4>
                    Average years before a student drops out
                    <div id="department-ave-years_dropout"><h1>{{ $aveYearsBeforeDropout }} </h1></div><br/>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Years Before Shifting Out</h4>
                    Average years before shifting to another department
                    <div id="department-ave-years_shiftout"><h1>{{ $aveYearsBeforeShifting }} </h1></div><br/>
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

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Factors
            </div>
            <div class="panel-body">
                <div id="deparment-factors"></div>
                <center>
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Percentage of Employed Dropouts</h4>
                            <div id="department-employment"></div>
                        </div>
                        <div class="col-md-4">
                            <h4>Percentage of Dropouts with Failing GWAs</h4>
                            <div id="department-grade"></div>
                        </div>
                        <div class="col-md-4">
                            <h4>Percentage of STFAP Brackets of Dropouts</h4>
                            <div id="department-stbracket"></div>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Percentage of Shiftees with Failing GWAs</h4>
                            <div id="department-shiftgrade"></div>
                        </div>
                        <div class="col-md-6">
                            <h4>Percentage of STFAP Brackets of Shiftees</h4>
                            <div id="department-shiftbracket"></div>
                        </div>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>
