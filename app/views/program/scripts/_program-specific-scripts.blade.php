<script>
//program
    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    var batchAttrition = {{ json_encode($batchAttrition) }};
    var batchShiftRate = {{ json_encode($batchShiftRate) }};
    var division = {{ json_encode($division) }};
    var gradeCount = {{ json_encode($gradeCount) }};
    var shiftGradeCount = {{ json_encode($shiftGradeCount) }};
    var stbracketCount = {{ json_encode($stbracketCount) }};
    var shiftBracketCount = {{ json_encode($shiftBracketCount) }};

    var averageData = [];
    var attritionArray = [];
    var shiftArray = [];
    var divisionArray = [];
    var gradeArray = [];
    var shiftGradeArray = [];
    var stbracketArray = [];
    var shiftBracketArray = [];

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});

    }

    for(var batchKey in batchAttrition){
        attritionArray.push({batch: batchKey, attritionrate: batchAttrition[batchKey]});
        shiftArray.push({batch: batchKey, shiftrate: batchShiftRate[batchKey]});
    }

    for(var divKey in division){
        divisionArray.push({label: divKey, value: division[divKey]});
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

    
</script>
