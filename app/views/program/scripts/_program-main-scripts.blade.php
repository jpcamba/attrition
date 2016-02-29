<script>
//program
    var programAveArray = {{ json_encode($programAveArray) }};
    var averageData = [];

    for(var programTitle in programAveArray){
        averageData.push({program: programTitle, studentcount: programAveArray[programTitle]});
    }

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
