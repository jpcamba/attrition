<script>
//college
    var collegeAveArray = {{ json_encode($collegeAveArray) }};
    var averageData = [];

    for(var collegeTitle in collegeAveArray){
        averageData.push({college: collegeTitle, studentcount: collegeAveArray[collegeTitle]});
    }

    var collegesAve = new Morris.Bar({
     element: 'college-ave-number-students',
     data: averageData,
     xkey: 'college',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true
    });


</script>
