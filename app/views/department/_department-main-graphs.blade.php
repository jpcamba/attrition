<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Attrition
            </div>
            <div class="panel-body">
                <div id="department-total-attrition"></div>
                <center>
                    <h4>Average attrition rate for each department</h4>
                    <div id="department-ave-attrition-rate"></div>
                    <br/>
                    <div id="department-ave-attrition-rate-legend"></div>
                    <br/><br/>
                    Department attrition is affected by the number of students who left the department or batch by dropping out of the university, shifting to another department, or being delayed.
                </center>

        		@foreach($departmentlist as $department){
        			{{$deptlist[$department->unitname] = $department}}
        		}
                @endforeach

                @foreach ($deptlist as $department)
                {
                    {{$attr[$department->unitname] = $department->getAveAttrition()}}
                }
                @endforeach
                {{array_multisort($attr, SORT_DESC, $deptlist)}} <br/><br/>

                @foreach($deptlist as $department)
                    {{ $department->unitname }} & {{ $department->getAveAttrition() }}\% \\ <br/>
                @endforeach
                <br/>

                @foreach($deptlist as $department)
                    {{ $department->unitname }}
                    &  {{ $department->getAveDropoutRate() }}\%
                    &  {{ $department->getAveShiftRate() }}\%
                    &  {{ $department->getAveDelayedRate() }}\% \\ <br/>
                @endforeach

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Students
            </div>
            <div class="panel-body">
                <div id="department-total-dropouts"></div>
                <center>
                    <h4>Average number of students per year for each department</h4>
                    <div id="department-ave-number-students"></div>
                    <br/>
                    <div id="department-ave-number-students-legend"></div>
                    <br/><br/>
                    The average number of students per year consists of all the undergraduate students in the department regardless of their batch.
                </center>
            </div>
        </div>
    </div>
</div>
