<script>
//department
    var departmentAveArray = {{ json_encode($departmentAveArray) }};
    var departmentAveAttritionArray = {{ json_encode($departmentAveAttritionArray) }};
    var averageData = [];
    var deptAttritionArray = [];

    for(var departmentTitle in departmentAveArray){
        averageData.push({department: departmentTitle, studentcount: departmentAveArray[departmentTitle]});
        deptAttritionArray.push({department: departmentTitle, attritionrate: departmentAveAttritionArray[departmentTitle]});
    }

    var departmentsAve = new Morris.Bar({
     element: 'department-ave-number-students',
     data: averageData,
     xkey: 'department',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     parseTime: false
    });

    new Morris.Bar({
     element: 'department-ave-attrition-rate',
     data: deptAttritionArray,
     xkey: 'department',
     ykeys: ['attritionrate'],
     labels: ['Attrition Rate'],
     hideHover: 'auto',
     resize: true,
     parseTime: false,
     barColors: ['#0BC9CD']
    });


</script>
