<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Attrition
            </div>
            <div class="panel-body">
                <div id="campus-total-dropouts"></div>
                <center>
                    <h4>Average batch attrition rate for each program</h4>
                    <div id="program-ave-batch-attrition"></div>
                    <br/>
                    <div id="program-ave-batch-attrition-legend"></div>
                    <br/><br/>
                    Program attrition is affected by the number of students who left the program or batch by dropping out of the university, shifting to another program, or being delayed.
                </center>

                @foreach($programlist as $program){
        			{{$proglist[$program->programtitle] = $program}}
        		}
                @endforeach

                @foreach ($proglist as $program)
                {
                    {{$attr[$program->programtitle] = $program->getAveAttrition()}}
                }
                @endforeach
                {{array_multisort($attr, SORT_DESC, $proglist)}} <br/><br/>

                @foreach($proglist as $program)
                    {{ $program->programtitle }} & {{ $program->getAveAttrition() }}\% \\ <br/>
                @endforeach
                <br/>

                @foreach($proglist as $program)
                    {{ $program->programtitle }}
                    &  {{ $program->getAveDropoutRate() }}\%
                    &  {{ $program->getAveShiftRate() }}\%
                    &  {{ $program->getAveDelayedRate() }}\% \\ <br/>
                @endforeach

            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"> Students
            </div>
            <div class="panel-body">
                <div id="campus-total-dropouts"></div>
                <center>
                    <h4>Average number of students per year for each program</h4>
                    <div id="program-ave-number-students"></div>
                    <br/><div id="program-ave-number-students-legend"></div>
                    <br/><br/>
                    The average number of students per year consists of all the undergraduate students in the program regardless of their batch.
                </center>
            </div>
        </div>
    </div>
</div>
