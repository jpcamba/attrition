<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Departments
            </div>
            <div class="panel-body">
                <div id="collegedepartments-total-dropouts"></div>
                <center>
                    <h4>Average number of students per year for each department under the college</h4>
                    <div id="collegedepartments-ave-number-students"></div>
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
                View attrition for a specific department of the college
            </div>
            <div class="panel-body">
                </br>
                <h4>Choose a department</h4>
                <!--Dropdown for prompt-->
                {{ Form::open(array('action' => 'DepartmentController@showSpecificDepartment')) }}
                  <div class="input-group">
                    <select class="form-control" required="required" id="department-dropdown" name="department-dropdown">
                        @foreach($collegedepartments as $collegedepartment){
                            <option value={{ $collegedepartment->unitid }}>{{ $collegedepartment->unitname }}</option>
                        }
                        @endforeach
                    </select>
                  </div>
                  <br/>
                  <button type="submit" class="btn btn-default">View Department</button>
                {{ Form::close() }}
                <!-- end of dropdown -->
            </div>
        </div>
    </div>
</div>
