<script>
//college
    var yearlyStudentAverage = {{ json_encode($yearlyStudentAverage) }};
    //var yearlySemDifference = {{-- json_encode($yearlySemDifference) --}};
    var collegeDepartmentsAverage = {{ json_encode($collegeDepartmentsAverage) }};
    var batchAttrition = {{ json_encode($batchAttrition) }};
    var departmentsAttrition = {{ json_encode($departmentsAttrition) }};
    var employmentCount = {{ json_encode($employmentCount) }};
    var gradeCount = {{ json_encode($gradeCount) }};
    var shiftGradeCount = {{ json_encode($shiftGradeCount) }};
    var stbracketCount = {{ json_encode($stbracketCount) }};
    //var regionCount = {{-- json_encode($regionCount) --}};
    var shiftBracketCount = {{ json_encode($shiftBracketCount) }};

    var averageData = [];
    //var semDifference = [];
    var collegeDepartments = [];
    var batchAttritionArray = [];
    var departmentsAttritionArray = [];
    var employmentArray = [];
    var gradeArray = [];
    var shiftGradeArray = [];
    //var regionArray = [];
    var stbracketArray = [];
    var shiftBracketArray = [];
    var deptAcronyms = {};

    for(var yearKey in yearlyStudentAverage){
        averageData.push({year: yearKey, studentcount: yearlyStudentAverage[yearKey]});
        //semDifference.push({year: yearKey, studentdifference: yearlySemDifference[yearKey]});
    }

    for(var departmentKey in collegeDepartmentsAverage){
        var acronym = departmentKey.replace("of", "");
        acronym = acronym.replace("and", "");
        acronym = acronym.match(/\b\w/g).join('').toUpperCase();
        deptAcronyms[acronym] = { unitname: departmentKey };

        collegeDepartments.push({department: acronym, deptTitle: departmentKey, studentcount: collegeDepartmentsAverage[departmentKey]});
        departmentsAttritionArray.push({department: acronym, deptTitle: departmentKey, attritionrate: departmentsAttrition[departmentKey]});
    }

    for(var batchKey in batchAttrition){
        batchAttritionArray.push({batch: batchKey, attritionrate: batchAttrition[batchKey]});
    }

    for(var employmentKey in employmentCount){
        employmentArray.push({label: employmentKey, value: employmentCount[employmentKey]});
    }

    for(var gradeKey in gradeCount){
        gradeArray.push({label: gradeKey, value: gradeCount[gradeKey]});
    }

    for(var shiftGradeKey in shiftGradeCount){
        shiftGradeArray.push({label: shiftGradeKey, value: shiftGradeCount[shiftGradeKey]});
    }

    for(var stbracketKey in stbracketCount){
        stbracketArray.push({label: stbracketKey, value: stbracketCount[stbracketKey]});
    }

    /*for(var regionKey in regionCount){
        regionArray.push({label: regionKey, value: regionCount[regionKey]});
    }*/

    for(var shiftBracketKey in shiftBracketCount){
        shiftBracketArray.push({label: shiftBracketKey, value: shiftBracketCount[shiftBracketKey]});
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
     hoverCallback: function(index, options, content){
         var data = options.data[index];
	     $(".morris-hover").html('<div><center> <b>' + data.deptTitle + '</b> <br/> <font color="#0b62a4"> Students: ' + data.studentcount + '</font></center></div>');
     },
     hideHover: 'auto',
     xLabelMargin: 10,
     padding: 40,
     resize: true,
     parseTime: false
    });

    new Morris.Bar({
     element: 'collegedepartments-ave-batch-attrition',
     data: departmentsAttritionArray,
     xkey: 'department',
     ykeys: ['attritionrate'],
     labels: ['Attrition Rate'],
     hoverCallback: function(index, options, content){
         var data = options.data[index];
		$(".morris-hover").html('<div><center> <b>' + data.deptTitle + '</b> <br/> <font color="#0BC9CD"> Attrition Rate: ' + data.attritionrate + '</font></center></div>');
     },
     hideHover: 'auto',
     xLabelMargin: 10,
     padding: 40,
     resize: true,
     parseTime: false,
     barColors: ['#0BC9CD']
    });

    new Morris.Donut({
      element: 'college-employment',
      data: employmentArray,
      colors: ['#114B5F', '#028090']
    });

    new Morris.Donut({
      element: 'college-grade',
      data: gradeArray,
      colors: ['#114B5F', '#028090']
    });

    new Morris.Donut({
      element: 'college-shiftgrade',
      data: shiftGradeArray,
      colors: ['#07BEB8', '#9CEAEF']
    });

    new Morris.Donut({
      element: 'college-stbracket',
      data: stbracketArray,
      colors: ['#114B5F', '#028090', '#07BEB8', '#9CEAEF', '#0B5351', '508991']
    });

    new Morris.Donut({
      element: 'college-shiftbracket',
      data: shiftBracketArray,
      colors: ['#09BC8A', '#4FB286', '#3C896D', '#546D64', '#4D685A', '#40C9A2']
    });

    //department legend
    var colors = ['#2D3047', '#1B998B'];
    var i = 0;
    for(var acr in deptAcronyms){
        if(i % 2 == 0){
            var legendItem1 = $('<span></span>').text(acr.concat(" - ", deptAcronyms[acr].unitname)).css('color', colors[0]);
            var legendItem2 = $('<span></span>').text(acr.concat(" - ", deptAcronyms[acr].unitname)).css('color', colors[1]);
        }
        else{
            var legendItem1 = $('<span></span>').text(acr.concat(" - ", deptAcronyms[acr].unitname)).css('color', colors[1]);
            var legendItem2 = $('<span></span>').text(acr.concat(" - ", deptAcronyms[acr].unitname)).css('color', colors[0]);
        }
        i++;
        $('#collegedepartments-ave-number-students-legend').append(legendItem1);
        $('#collegedepartments-ave-number-students-legend').append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
        $('#collegedepartments-ave-batch-attrition-legend').append(legendItem2);
        $('#collegedepartments-ave-batch-attrition-legend').append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
    }

    /*new Morris.Bar({
     element: 'college-stbracket',
     data: stbracketArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#07BEB8', '#3DCCC7', '#68D8D6', '#9CEAEF', '#C4FFF9']
    });

    new Morris.Bar({
     element: 'college-region',
     data: regionArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#07BEB8', '#3DCCC7', '#68D8D6']
    });

    new Morris.Bar({
     element: 'college-shiftbracket',
     data: shiftBracketArray,
     xkey: 'label',
     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
     resize: true,
     barColors: ['#BEE9E8', '#62B6CB', '#1B4965', '#CAE9FF', '#5FA8D3']
 });*/

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
