<script>
//college
    var collegeAveArray = {{ json_encode($collegeAveArray) }};
    var collegeAveAttritionArray = {{ json_encode($collegeAveAttritionArray) }};
    var averageData = [];
    var collAttritionArray = [];

    for(var collegeTitle in collegeAveArray){
        averageData.push({college: collegeTitle, studentcount: collegeAveArray[collegeTitle]});
        collAttritionArray.push({college: collegeTitle, attritionrate: collegeAveAttritionArray[collegeTitle]});
    }

    var collegesAve = new Morris.Bar({
     element: 'college-ave-number-students',
     data: averageData,
     xkey: 'college',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     parseTime: false
   });

   new Morris.Bar({
    element: 'college-ave-attrition-rate',
    data: collAttritionArray,
    xkey: 'college',
    ykeys: ['attritionrate'],
    labels: ['Attrition Rate'],
    hideHover: 'auto',
    resize: true,
    parseTime: false,
    barColors: ['#0BC9CD']
   });


</script>
