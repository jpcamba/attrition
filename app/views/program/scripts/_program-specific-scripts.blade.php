<script>
//program
    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    var yearlySemDifference = {{ json_encode($yearlySemDifference) }};
    var batchAttrition = {{ json_encode($batchAttrition) }};
    var batchShiftRate = {{ json_encode($batchShiftRate) }};
    var division = {{ json_encode($division) }};
    //var employmentCount = {{-- json_encode($employmentCount) --}};
    var gradeCount = {{ json_encode($gradeCount) }};
    var shiftGradeCount = {{ json_encode($shiftGradeCount) }};
    var stbracketCount = {{ json_encode($stbracketCount) }};
    //var regionCount = {{-- json_encode($regionCount) --}};
    var shiftBracketCount = {{ json_encode($shiftBracketCount) }};

    var averageData = [];
    var semDifference = [];
    var attritionArray = [];
    var shiftArray = [];
    var divisionArray = [];
    //var employmentArray = [];
    var gradeArray = [];
    var shiftGradeArray = [];
    //var regionArray = [];
    var stbracketArray = [];
    var shiftBracketArray = [];

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});
        semDifference.push({year: yearKey, studentdifference: yearlySemDifference[yearKey]});
    }

    for(var batchKey in batchAttrition){
        attritionArray.push({batch: batchKey, attritionrate: batchAttrition[batchKey]});
        shiftArray.push({batch: batchKey, shiftrate: batchShiftRate[batchKey]});
    }

    for(var divKey in division){
        divisionArray.push({label: divKey, value: division[divKey]});
    }

    /*for(var employmentKey in employmentCount){
        employmentArray.push({label: employmentKey, value: employmentCount[employmentKey]});
    }*/

    for(var gradeKey in gradeCount){
        gradeArray.push({label: gradeKey, value: gradeCount[gradeKey]});
    }

    for(var shiftGradeKey in shiftGradeCount){
        shiftGradeArray.push({label: shiftGradeKey, value: shiftGradeCount[shiftGradeKey]});
    }

    /*
    for(var regionKey in regionCount){
        regionArray.push({label: regionKey, value: regionCount[regionKey]});
    }
    */

    for(var stbracketKey in stbracketCount){
        stbracketArray.push({label: stbracketKey, value: stbracketCount[stbracketKey]});
    }

    for(var shiftBracketKey in shiftBracketCount){
        shiftBracketArray.push({label: shiftBracketKey, value: shiftBracketCount[shiftBracketKey]});
    }

    new Morris.Area({
     element: 'program-yearly-number-students',
     data: averageData,
     xkey: 'year',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     parseTime: false
    });

    new Morris.Line({
     element: 'program-yearly-sem-difference',
     data: semDifference,
     xkey: 'year',
     ykeys: ['studentdifference'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     goals: [0],
     parseTime: false
    });

    new Morris.Line({
     element: 'program-ave-attrition-batch',
     data: attritionArray,
     xkey: 'batch',
     ykeys: ['attritionrate'],
     labels: ['Attrition Rate'],
     hideHover: 'auto',
     resize: true,
     goals: [0],
     parseTime: false
    });

    new Morris.Line({
     element: 'program-ave-shift-batch',
     data: shiftArray,
     xkey: 'batch',
     ykeys: ['shiftrate'],
     labels: ['Shift Rate'],
     hideHover: 'auto',
     resize: true,
     goals: [0],
     parseTime: false
    });

    new Morris.Donut({
      element: 'program-division',
      data: divisionArray,
      colors: ['#8FBFE0', '#0BC9CD', '#1D8A99']
    });

    /*new Morris.Donut({
      element: 'program-employment',
      data: employmentArray,
      colors: ['#114B5F', '#028090']
  });*/

    new Morris.Donut({
      element: 'program-grade',
      data: gradeArray,
      colors: ['#114B5F', '#028090']
    });

    new Morris.Donut({
      element: 'program-shiftgrade',
      data: shiftGradeArray,
      colors: ['#09BC8A', '#4FB286']
    });

    new Morris.Donut({
      element: 'program-stbracket',
      data: stbracketArray,
      colors: ['#114B5F', '#028090', '#07BEB8', '#9CEAEF', '#0B5351', '508991']
    });

    new Morris.Donut({
      element: 'program-shiftbracket',
      data: shiftBracketArray,
      colors: ['#09BC8A', '#4FB286', '#3C896D', '#546D64', '#4D685A', '#40C9A2']
    });

    /*new Morris.Bar({
     element: 'program-stbracket',
     data: stbracketArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#07BEB8', '#3DCCC7', '#68D8D6', '#9CEAEF', '#C4FFF9']
    });

    new Morris.Bar({
     element: 'program-region',
     data: regionArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#07BEB8', '#3DCCC7', '#68D8D6']
 });

    new Morris.Bar({
     element: 'program-shiftbracket',
     data: shiftBracketArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#BEE9E8', '#62B6CB', '#1B4965', '#CAE9FF', '#5FA8D3']
 });*/


</script>
