<script>
    var correlation = {{json_encode($correlation)}};
    var rawCorrelation = {{json_encode($rawCorrelation)}};
    var factorNames = {{json_encode($factorNames)}};
    var colleges = {{json_encode($colleges)}};
    var departments = {{json_encode($departments)}};
    var programs = {{json_encode($programs)}};
    var collegeNames = {{json_encode($collegeNames)}};
    var departmentNames = {{json_encode($departmentNames)}};
    var programNames = {{json_encode($programNames)}}; 

    var positive = [1, 2, 3, 4, 6, 9];
    var negative = [7, 8];

	//Campus Factors
	var correlationData = [];
	for (var i = 1; i <= 9; i++) {
		if (i != 5) {
			if (positive.indexOf(i) > -1 && rawCorrelation['campus'][-1][i] > 0)
				correlationData.push({label: factorNames[i], value: correlation['campus'][-1][i]});
			else if (negative.indexOf(i) > -1 && rawCorrelation['campus'][-1][i] < 0)
				correlationData.push({label: factorNames[i], value: correlation['campus'][-1][i]});
			else {}
		}
	}

    new Morris.Donut({
    	element: 'correlation-chart',
  		data: correlationData,
  		colors: ['#8FBFE0', '#0BC9CD', '#1D8A99', '#7C77B9', '#2B8A77', '#4AB9CC']
	});

    //Main College Chart
    var collegeFactorData = [];
    for (collegeName in collegeNames) {
    	collegeFactorData.push({college: collegeNames[collegeName], correlation: correlation['college'][collegeName][1]});
    }

    new Morris.Bar({
    	element: 'college-factor',
    	data: collegeFactorData,
    	xkey: 'college',
    	ykeys: ['correlation'],
    	labels: ['Correlation Coefficient'],
    	hideHover: 'auto',
	    resize: true,
	    parseTime: false,
    	barColors: ['#0BC9CD']
    });

    $('#college-factorname').append(factorNames[1] + ' vs Attrition Correlation Coefficient Absolute Values');

    //On College Dropdown Change
    $('#college-factor-dropdown').on('change', function() {
    	var factorid = $('#college-factor-dropdown').val();
    	$('#college-factorname').empty();
    	$('#college-factor').empty();

    	var collegeFactorData = [];
	    for (collegeName in collegeNames) {
	    	collegeFactorData.push({college: collegeNames[collegeName], correlation: correlation['college'][collegeName][factorid]});
	    }

	    new Morris.Bar({
	    	element: 'college-factor',
	    	data: collegeFactorData,
	    	xkey: 'college',
	    	ykeys: ['correlation'],
	    	labels: ['Correlation Coefficient'],
	    	hideHover: 'auto',
		    resize: true,
		    parseTime: false,
	    	barColors: ['#0BC9CD']
	    });

	    $('#college-factorname').append(factorNames[factorid] + ' vs Attrition Correlation Coefficient Absolute Values');
    });

    //Main Department Chart
    var departmentFactorData = [];
    for (departmentName in departmentNames) {
    	departmentFactorData.push({department: departmentNames[departmentName], correlation: correlation['department'][departmentName][1]});
    }

    new Morris.Bar({
    	element: 'department-factor',
    	data: departmentFactorData,
    	xkey: 'department',
    	ykeys: ['correlation'],
    	labels: ['Correlation Coefficient'],
    	hideHover: 'auto',
	    resize: true,
	    parseTime: false,
    	barColors: ['#0BC9CD']
    });

    $('#department-factorname').append(factorNames[1] + ' vs Attrition Correlation Coefficient Absolute Values');

    //On Department Dropdown Change
    $('#department-factor-dropdown').on('change', function() {
    	var factorid = $('#department-factor-dropdown').val();
    	$('#department-factorname').empty();
    	$('#department-factor').empty();

    	var departmentFactorData = [];
	    for (departmentName in departmentNames) {
	    	departmentFactorData.push({department: departmentNames[departmentName], correlation: correlation['department'][departmentName][factorid]});
	    }

	    new Morris.Bar({
	    	element: 'department-factor',
	    	data: departmentFactorData,
	    	xkey: 'department',
	    	ykeys: ['correlation'],
	    	labels: ['Correlation Coefficient'],
	    	hideHover: 'auto',
		    resize: true,
		    parseTime: false,
	    	barColors: ['#0BC9CD']
	    });

	    $('#department-factorname').append(factorNames[factorid] + ' vs Attrition Correlation Coefficient Absolute Values');
    });

</script>