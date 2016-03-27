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

    var employmentCount = {{ json_encode($employmentCount) }};
    var stbracketCount = {{ json_encode($stbracketCount) }};
    //var gradeCount = {{-- json_encode($gradeCount) --}};
    //var regionCount = {{-- json_encode($regionCount) --}};
    var employmentArray = [];
    //var gradeArray = [];
    //var regionArray = [];
    var stbracketArray = [];

    for(var employmentKey in employmentCount){
        employmentArray.push({label: employmentKey, value: employmentCount[employmentKey]});
    }

    for(var stbracketKey in stbracketCount){
        stbracketArray.push({label: stbracketKey, value: stbracketCount[stbracketKey]});
    }

    new Morris.Donut({
     element: 'campus-employment',
     data: employmentArray,
     colors: ['#114B5F', '#028090']
    });

    new Morris.Donut({
      element: 'campus-stbracket',
      data: stbracketArray,
      colors: ['#114B5F', '#028090', '#07BEB8', '#9CEAEF', '#0B5351', '508991']
    });


    /*for(var gradeKey in gradeCount){
        gradeArray.push({label: gradeKey, value: gradeCount[gradeKey]});
    }

    for(var regionKey in regionCount){
        regionArray.push({label: regionKey, value: regionCount[regionKey]});
    }

   new Morris.Donut({
     element: 'campus-grade',
     data: gradeArray,
     colors: ['#114B5F', '#028090']
   });

   new Morris.Bar({
    element: 'campus-stbracket',
    data: stbracketArray,
    xkey: 'label',
    ykeys: ['value'],
    labels: ['Students'],
    hideHover: 'auto',
    resize: true,
    barColors: ['#07BEB8', '#3DCCC7', '#68D8D6', '#9CEAEF', '#C4FFF9']
   });

   new Morris.Bar({
    element: 'campus-region',
    data: regionArray,
    xkey: 'label',
    ykeys: ['value'],
    labels: ['Students'],
    hideHover: 'auto',
    resize: true,
    barColors: ['#07BEB8', '#3DCCC7', '#68D8D6']
});*/


</script>
