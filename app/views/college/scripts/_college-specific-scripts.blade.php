<script>
//college
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
    }

    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    var yearlySemDifference = {{ json_encode($yearlySemDifference) }};
    var collegeProgramsAverage = {{ json_encode($collegeProgramsAverage) }};
    var averageData = [];
    var semDifference = [];
    var collegePrograms = [];

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});
        semDifference.push({year: yearKey, studentdifference: yearlySemDifference[yearKey]});
    }

    for(var programKey in collegeProgramsAverage){
        collegePrograms.push({program: programKey, studentcount: collegeProgramsAverage[programKey]});
    }

    new Morris.Area({
     element: 'college-yearly-number-students',
     data: averageData,
     xkey: 'year',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true
    });

    new Morris.Line({
     element: 'college-yearly-sem-difference',
     data: semDifference,
     xkey: 'year',
     ykeys: ['studentdifference'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     goals: [0]
    });

    new Morris.Bar({
     element: 'collegeprograms-ave-number-students',
     data: collegePrograms,
     xkey: 'program',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true
    });


</script>
