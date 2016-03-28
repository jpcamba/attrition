<script>
	//Factors that affect attrition
    var correlation = {{json_encode($correlation)}}

    new Morris.Donut({
    	element: 'correlation-factors',
  		data: [
		    {label: 'ST Bracket', value: correlation['stbracket']},
		    {label: 'Region', value: correlation['region']},
		    {label: 'Employment', value: correlation['unemployment']},
		    {label: 'Grades', value: correlation['highgrades']},
		    {label: 'Overloading', value: correlation['overloading']},
  		],
  		colors: ['#8FBFE0', '#0BC9CD', '#1D8A99', '#7C77B9', '#2B8A77', '#4AB9CC']
	});

</script>