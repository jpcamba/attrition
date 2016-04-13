<script>
    var correlation = {{json_encode($correlation)}};
    var rawCorrelation = {{json_encode($rawCorrelation)}};
    var factorNames = {{json_encode($factorNames)}};
    var level = {{json_encode($level)}};
    var levelName = {{json_encode($levelName)}}

    var positive = [1, 2, 3, 4, 6, 9];
    var negative = [7, 8];

    //Specific College Factors
	var correlationData = [];
	var sum = 0;
	for (var i = 1; i <= 9; i++) {
		if (i != 5) {
			if (positive.indexOf(i) > -1 && rawCorrelation[level][i] > 0) {
				correlationData.push({label: factorNames[i], value: correlation[level][i]});
				sum++;
			}

			else if (negative.indexOf(i) > -1 && rawCorrelation[level][i] < 0) {
				correlationData.push({label: factorNames[i], value: correlation[level][i]});
				sum++;
			}

			else {}
		}
	}

	if (sum == 0)
		$('#chart-warning').append('<div class="alert alert-danger"> Insufficient data for ' + levelName + ' Correlation Analysis </div>');

    new Morris.Donut({
    	element: 'specific-chart',
  		data: correlationData,
  		colors: ['#8FBFE0', '#0BC9CD', '#1D8A99', '#7C77B9', '#2B8A77', '#4AB9CC']
	});

</script>