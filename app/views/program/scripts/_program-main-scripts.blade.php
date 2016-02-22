<script>
//program
    var programAveArray = {{ json_encode($programAveArray) }};
    var averageData = [];

    for(var programTitle in programAveArray){
        averageData.push({program: programTitle, studentcount: programAveArray[programTitle]});
    }

    var programsAve = new Morris.Bar({
     element: 'program-yearly-ave-number-students',
     data: averageData,
     xkey: 'program',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true
    });


</script>
