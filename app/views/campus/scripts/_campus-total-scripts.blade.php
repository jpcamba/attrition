<script>
//campus
    //Average Attrition Rate
    $('#campus-average-attrition').empty();
    $('#campus-average-attrition').append({{json_encode($aveAttrition)}} + '%');

    //Batch Attrition Rate
    var batchAttritionRaw = {{json_encode($batchAttrition)}};
    var batchAttrition = [];

    /*var employmentCount = {{-- json_encode($employmentCount) --}};
    var gradeCount = {{-- json_encode($gradeCount) --}};
    var stbracketCount = {{-- json_encode($stbracketCount) --}};
    var regionCount = {{-- json_encode($regionCount) --}};
    var employmentArray = [];
    var gradeArray = [];
    var regionArray = [];
    var stbracketArray = [];*/


    for (var batchKey in batchAttritionRaw) {
        batchAttrition.push({batch: batchKey, attritionrate: batchAttritionRaw[batchKey]});
    }

    /*for(var employmentKey in employmentCount){
        employmentArray.push({label: employmentKey, value: employmentCount[employmentKey]});
    }

    for(var gradeKey in gradeCount){
        gradeArray.push({label: gradeKey, value: gradeCount[gradeKey]});
    }

    for(var stbracketKey in stbracketCount){
        stbracketArray.push({label: stbracketKey, value: stbracketCount[stbracketKey]});
    }

    for(var regionKey in regionCount){
        regionArray.push({label: regionKey, value: regionCount[regionKey]});
    }*/



    new Morris.Line({
        element: 'campus-batch-attrition',
        data: batchAttrition,
        xkey: 'batch',
        ykeys: ['attritionrate'],
        labels: ['Attrition Rate'],
        hideHover: 'auto',
        resize: true
    });

    //Average Dropouts
    $('#campus-average-dropouts').empty();
    $('#campus-average-dropouts').append({{json_encode($aveDropouts)}});

    //Batch Dropouts
    var batchDropoutsRaw = {{json_encode($batchDropouts)}};
    var batchDropouts = [];

    for (var batchKey in batchDropoutsRaw) {
        batchDropouts.push({batch: batchKey, dropouts: batchDropoutsRaw[batchKey]});
    }

    new Morris.Line({
        element: 'campus-batch-dropouts',
        data: batchDropouts,
        xkey: 'batch',
        ykeys: ['dropouts'],
        labels: ['Dropouts'],
        hideHover: 'auto',
        resize: true
    });

    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    var yearlySemDifference = {{ json_encode($yearlySemDifference) }};
    var averageData = [];
    var semDifference = [];

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});
        semDifference.push({year: yearKey, studentdifference: yearlySemDifference[yearKey]});
    }

    new Morris.Area({
     element: 'campus-number-students',
     data: averageData,
     xkey: 'year',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true
    });

    new Morris.Line({
     element: 'campus-sem-difference',
     data: semDifference,
     xkey: 'year',
     ykeys: ['studentdifference'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     goals: [0]
     });

     /*new Morris.Donut({
      element: 'campus-employment',
      data: employmentArray,
      colors: ['#114B5F', '#028090']
    });

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
