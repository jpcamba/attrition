<script>
//campus
    //Average Attrition Rate
    $('#campus-average-attrition').empty();
    $('#campus-average-attrition').append({{json_encode($aveAttrition)}} + '%');

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
        labels: ['Dropout Rate'],
        hideHover: 'auto',
        resize: true
    });

    //Average Delayed
    $('#campus-average-delayed').empty();
    $('#campus-average-delayed').append({{json_encode($aveDelayed)}});

    //Batch
    var batchDelayedRaw = {{json_encode($batchDelayed)}};
    var batchDelayed = [];

    for (var batchKey in batchDelayedRaw) {
        batchDelayed.push({batch: batchKey, delayed: batchDelayedRaw[batchKey]});
    }

    new Morris.Line({
        element: 'campus-batch-delayed',
        data: batchDelayed,
        xkey: 'batch',
        ykeys: ['delayed'],
        labels: ['Delayed Rate'],
        hideHover: 'auto',
        resize: true
    });

    //student count
    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    var averageData = [];

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});
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

</script>
