<script>
//department
    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    //var yearlySemDifference = {{-- json_encode($yearlySemDifference) --}};
    var departmentProgramsAverage = {{ json_encode($departmentProgramsAverage) }};
    var batchAttrition = {{ json_encode($batchAttrition) }};
    var programsAttrition = {{ json_encode($programsAttrition) }};
    var employmentCount = {{ json_encode($employmentCount) }};
    var gradeCount = {{ json_encode($gradeCount) }};
    var shiftGradeCount = {{ json_encode($shiftGradeCount) }};
    var stbracketCount = {{ json_encode($stbracketCount) }};
    //var regionCount = {{-- json_encode($regionCount) --}};
    var shiftBracketCount = {{ json_encode($shiftBracketCount) }};

    var averageData = [];
    //var semDifference = [];
    var departmentPrograms = [];
    var batchAttritionArray = [];
    var programsAttritionArray = [];
    var employmentArray = [];
    var gradeArray = [];
    var shiftGradeArray = [];
    //var regionArray = [];
    var stbracketArray = [];
    var shiftBracketArray = [];

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});
        //semDifference.push({year: yearKey, studentdifference: yearlySemDifference[yearKey]});
    }

    for(var programKey in departmentProgramsAverage){
        departmentPrograms.push({program: programKey, studentcount: departmentProgramsAverage[programKey]});
        programsAttritionArray.push({program: programKey, attritionrate: programsAttrition[programKey]});
    }

    for(var batchKey in batchAttrition){
        batchAttritionArray.push({batch: batchKey, attritionrate: batchAttrition[batchKey]});
    }

    for(var employmentKey in employmentCount){
        employmentArray.push({label: employmentKey, value: employmentCount[employmentKey]});
    }

    for(var gradeKey in gradeCount){
        gradeArray.push({label: gradeKey, value: gradeCount[gradeKey]});
    }

    for(var shiftGradeKey in shiftGradeCount){
        shiftGradeArray.push({label: shiftGradeKey, value: shiftGradeCount[shiftGradeKey]});
    }

    for(var stbracketKey in stbracketCount){
        stbracketArray.push({label: stbracketKey, value: stbracketCount[stbracketKey]});
    }

    /*for(var regionKey in regionCount){
        regionArray.push({label: regionKey, value: regionCount[regionKey]});
    }*/

    for(var shiftBracketKey in shiftBracketCount){
        shiftBracketArray.push({label: shiftBracketKey, value: shiftBracketCount[shiftBracketKey]});
    }

    new Morris.Bar({
     element: 'department-ave-batch-attrition',
     data: batchAttritionArray,
     xkey: 'batch',
     ykeys: ['attritionrate'],
     labels: ['Attrition Rate'],
     hideHover: 'auto',
     resize: true,
     parseTime: false,
     barColors: ['#0BC9CD']
    });

    new Morris.Area({
     element: 'department-yearly-number-students',
     data: averageData,
     xkey: 'year',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     parseTime: false
    });

    new Morris.Bar({
     element: 'departmentprograms-ave-number-students',
     data: departmentPrograms,
     xkey: 'program',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     parseTime: false
    });

    new Morris.Bar({
     element: 'departmentprograms-ave-batch-attrition',
     data: programsAttritionArray,
     xkey: 'program',
     ykeys: ['attritionrate'],
     labels: ['Attrition Rate'],
     hideHover: 'auto',
     resize: true,
     parseTime: false,
     barColors: ['#0BC9CD']
    });

    new Morris.Donut({
      element: 'department-employment',
      data: employmentArray,
      colors: ['#114B5F', '#028090']
    });

    new Morris.Donut({
      element: 'department-grade',
      data: gradeArray,
      colors: ['#114B5F', '#028090']
    });

    new Morris.Donut({
      element: 'department-shiftgrade',
      data: shiftGradeArray,
      colors: ['#07BEB8', '#9CEAEF']
    });

    new Morris.Donut({
      element: 'department-stbracket',
      data: stbracketArray,
      colors: ['#114B5F', '#028090', '#07BEB8', '#9CEAEF', '#0B5351', '508991']
    });

    new Morris.Donut({
      element: 'department-shiftbracket',
      data: shiftBracketArray,
      colors: ['#09BC8A', '#4FB286', '#3C896D', '#546D64', '#4D685A', '#40C9A2']
    });

    /*new Morris.Bar({
     element: 'department-stbracket',
     data: stbracketArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#07BEB8', '#3DCCC7', '#68D8D6', '#9CEAEF', '#C4FFF9']
    });

    new Morris.Bar({
     element: 'department-region',
     data: regionArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#07BEB8', '#3DCCC7', '#68D8D6']
    });

    new Morris.Bar({
     element: 'department-shiftbracket',
     data: shiftBracketArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#BEE9E8', '#62B6CB', '#1B4965', '#CAE9FF', '#5FA8D3']
 });*/

    /*new Morris.Line({
     element: 'department-yearly-sem-difference',
     data: semDifference,
     xkey: 'year',
     ykeys: ['studentdifference'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     goals: [0],
     parseTime: false
 });*/

    //random colors for graphs
    /*function randomColors() {
      // 30 random hues with step of 12 degrees
      var color = "#";
      for (k = 0; k < 3; k++) {
        color += ("0" + (Math.random()*256|0).toString(16)).substr(-2);
      }
      return color;
    }

    var randomColorsArray = ['#0b62a4', '#7A92A3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed'];
    for(var x = 0; x < 27; x++){
        var color = randomColors();
        randomColorsArray.push(color);
    }*/


</script>
