<script>
//program
    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    var yearlySemDifference = {{ json_encode($yearlySemDifference) }};
    var batchAttrition = {{ json_encode($batchAttrition) }};
    var batchShiftRate = {{ json_encode($batchShiftRate) }};
    var division = {{ json_encode($division) }};
    var averageData = [];
    var semDifference = [];
    var attritionArray = [];
    var shiftArray = [];
    var divisionArray = [];

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
      data: divisionArray
    });

</script>
