<script>
	//Factors that affect attrition
    var correlation = {{json_encode($correlation)}}

    new Morris.Donut({
    	element: 'correlation-factors',
  		data: [
		    {label: 'Employment', value: correlation['employment']},
		    {label: 'Grades', value: correlation['grades']},
		    {label: 'ST Bracket', value: correlation['stbracket']},
		    {label: 'Region', value: correlation['region']}
  		],
  		colors: ['#8FBFE0', '#0BC9CD', '#1D8A99', '#7C77B9']
	});

</script>