<script>

    var yearlyStudentsArray = {{ json_encode($yearlyStudentsArray) }};
    var totaldata = [];

    for(var yearKey in yearlyStudentsArray){
        totaldata.push({year: yearKey, studentcount: yearlyStudentsArray[yearKey]});
    }

    new Morris.Area({
     element: 'campus-number-students',
     data: totaldata,
     xkey: 'year',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true
    });


</script>
