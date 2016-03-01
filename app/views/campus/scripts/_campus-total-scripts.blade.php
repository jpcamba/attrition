<script>
//campus
    //Total Attrition Rate
    $('#campus-total-attrition').empty();
    $('#campus-total-attrition').append({{json_encode($totalAttrition)}} + '%');

    //Batch Attrition Rate
    var batchAttritionRaw = {{json_encode($batchAttrition)}};
    var batchAttrition = [];

    for (var batchKey in batchAttritionRaw) {
        batchAttrition.push({batch: batchKey, attritionrate: batchAttritionRaw[batchKey]});
    }

    new Morris.Line({
        element: 'campus-batch-attrition',
        data: batchAttrition,
        xkey: 'batch',
        ykeys: ['attritionrate'],
        labels: ['Students'],
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


</script>
