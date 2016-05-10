<!-- Disclaimer for Applied Physics -->
@if($program->programid === 117)
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    The first batch of BS Applied Physics students started in 2011. However, the data for this study is only up to 2013. The rates provided in this page were taken by observing batches 2011 and 2012 and whether they dropped out or shifted out within 1-2 years in the program.
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Years Required</h4>
                    <div id="program-required-years"><h2>{{ $numYears }}</h2></div>
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
                    <br/>
                    Program attrition is affected by the number of students who left the program either by dropping out of the university or by shifting to another program.
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
                    <h4>Shift Rate per Batch</h4>
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
                    </br>
                    The average number of students per year consists of all the undergraduate students in the program regardless of their batch.
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
                <div id="program-factors"></div>
                <center>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Percentage of Dropouts with GWAs below 3.00</h4>
                            <div id="program-grade"></div>
                        </div>
                        <div class="col-md-6">
                            <h4>Percentage of STFAP Brackets of Dropouts</h4>
                            <div id="program-stbracket"></div>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Percentage of Shiftees with GWAs below 3.00</h4>
                            <div id="program-shiftgrade"></div>
                        </div>
                        <div class="col-md-6">
                            <h4>Percentage of STFAP Brackets of Shiftees</h4>
                            <div id="program-shiftbracket"></div>
                        </div>
                    </div>
                </center>
                <br/>
                *For the computation of the percentage of STFAP Brackets, the numeric bracket '9' was included in the alphabetic bracket 'A' count. The numeric bracket '1' was included the alphabetic bracket 'E2' count.
            </div>
        </div>
    </div>
</div>
