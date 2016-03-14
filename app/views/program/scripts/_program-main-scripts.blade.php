<script>
//program
    var programAveArray = {{ json_encode($programAveArray) }};
    var programBatchAttrition = {{ json_encode($programBatchAttrition) }};
    var averageData = [];
    var attritionData = [];

    for(var programTitle in programAveArray){
        averageData.push({program: programTitle, studentcount: programAveArray[programTitle]});
        attritionData.push({program: programTitle, attritionrate: programBatchAttrition[programTitle]});
    }

    var programsAttrition = new Morris.Bar({
     element: 'program-ave-batch-attrition',
     data: attritionData,
     xkey: 'program',
     ykeys: ['attritionrate'],
     labels: ['Attrition Rate'],
     hideHover: 'auto',
     resize: true
    });

    var programsAve = new Morris.Bar({
     element: 'program-ave-number-students',
     data: averageData,
     xkey: 'program',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true
    });

    /*programsAve.options.labels.forEach(function(label, i){
      var legendItemE2 = $('<span></span>').text(label).css('color', programsAve.options.barColors[i])
      $('#employment-yearly-dropouts-legend').append(legendItemE2)
  });*/


</script>
