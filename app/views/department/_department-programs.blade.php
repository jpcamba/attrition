<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Programs
            </div>
            <div class="panel-body">
                <div id="departmentprograms-total-dropouts"></div>
                <center>
                    <h4>Average number of students per year for each program under the department</h4>
                    <div id="departmentprograms-ave-number-students"></div>
                </center>
            </div>
        </div>
    </div>
</div>

<!-- Dropdown for programs -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                View attrition for a specific program of the department
            </div>
            <div class="panel-body">
                </br>
                <h4>Choose a program</h4>
                <!--Dropdown for prompt-->
                {{ Form::open(array('action' => 'ProgramController@showSpecificProgram')) }}
                  <div class="input-group">
                    <select class="form-control" required="required" id="program-dropdown" name="program-dropdown">
                        @foreach($departmentprograms as $departmentprogram){
                            <option value={{ $departmentprogram->programid }}>{{ $departmentprogram->programtitle }}</option>
                        }
                        @endforeach
                    </select>
                  </div>
                  <br/>
                  <button type="submit" class="btn btn-default">View Program</button>
                {{ Form::close() }}
                <!-- end of dropdown -->
            </div>
        </div>
    </div>
</div>
