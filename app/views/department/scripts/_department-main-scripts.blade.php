<script>
//department
    var departmentAveArray = {{ json_encode($departmentAveArray) }};
    var averageData = [];

    for(var departmentTitle in departmentAveArray){
        averageData.push({department: departmentTitle, studentcount: departmentAveArray[departmentTitle]});
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


</script>
