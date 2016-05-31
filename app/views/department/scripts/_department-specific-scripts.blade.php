<script>
//department
    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    var departmentProgramsAverage = {{ json_encode($departmentProgramsAverage) }};
    var batchAttrition = {{ json_encode($batchAttrition) }};
    var programsAttrition = {{ json_encode($programsAttrition) }};
    var gradeCount = {{ json_encode($gradeCount) }};
    var shiftGradeCount = {{ json_encode($shiftGradeCount) }};
    var stbracketCount = {{ json_encode($stbracketCount) }};
    var shiftBracketCount = {{ json_encode($shiftBracketCount) }};

    var averageData = [];
    var departmentPrograms = [];
    var batchAttritionArray = [];
    var programsAttritionArray = [];
    var gradeArray = [];
    var shiftGradeArray = [];
    var stbracketArray = [];
    var shiftBracketArray = [];

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});
    }

    for(var programKey in departmentProgramsAverage){
        departmentPrograms.push({program: programKey, studentcount: departmentProgramsAverage[programKey]});
        programsAttritionArray.push({program: programKey, attritionrate: programsAttrition[programKey]});
    }

    for(var batchKey in batchAttrition){
        batchAttritionArray.push({batch: batchKey, attritionrate: batchAttrition[batchKey]});
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

</script>
