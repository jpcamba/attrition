<script>
//college
    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    //var yearlySemDifference = {{-- json_encode($yearlySemDifference) --}};
    var collegeDepartmentsAverage = {{ json_encode($collegeDepartmentsAverage) }};
    var batchAttrition = {{ json_encode($batchAttrition) }};
    var departmentsAttrition = {{ json_encode($departmentsAttrition) }};
    var averageData = [];
    //var semDifference = [];
    var collegeDepartments = [];
    var batchAttritionArray = [];
    var departmentsAttritionArray = [];

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});
        //semDifference.push({year: yearKey, studentdifference: yearlySemDifference[yearKey]});
    }

    for(var departmentKey in collegeDepartmentsAverage){
        collegeDepartments.push({department: departmentKey, studentcount: collegeDepartmentsAverage[departmentKey]});
        departmentsAttritionArray.push({department: departmentKey, attritionrate: departmentsAttrition[departmentKey]});
    }

    for(var batchKey in batchAttrition){
        batchAttritionArray.push({batch: batchKey, attritionrate: batchAttrition[batchKey]});
    }

    new Morris.Bar({
     element: 'college-ave-batch-attrition',
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
     element: 'college-yearly-number-students',
     data: averageData,
     xkey: 'year',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     parseTime: false
    });

    new Morris.Bar({
     element: 'collegedepartments-ave-number-students',
     data: collegeDepartments,
     xkey: 'department',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     parseTime: false
    });

    new Morris.Bar({
     element: 'collegedepartments-ave-batch-attrition',
     data: departmentsAttritionArray,
     xkey: 'department',
     ykeys: ['attritionrate'],
     labels: ['Attrition Rate'],
     hideHover: 'auto',
     resize: true,
     parseTime: false,
     barColors: ['#0BC9CD']
    });

    /*
        new Morris.Line({
         element: 'college-yearly-sem-difference',
         data: semDifference,
         xkey: 'year',
         ykeys: ['studentdifference'],
         labels: ['Students'],
         hideHover: 'auto',
         resize: true,
         goals: [0],
         parseTime: false
        });

      //random colors for graphs
        function randomColors() {
          // 30 random hues with step of 12 degrees
          var color = "#";
          for (k = 0; k < 3; k++) {
            color += ("0" + (Math.random()*256|0).toString(16)).substr(-2);
          }
          return color;
        }

        var randomColorsArray = ['#0b62a4', '#7A92A3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed'];
        for(var x = 0; x < 27; x++){
            var color = randomColors();
            randomColorsArray.push(color);
        }*/

</script>
