<script>
//department
    var departmentAveArray = {{ json_encode($departmentAveArray) }};
    var departmentAveAttritionArray = {{ json_encode($departmentAveAttritionArray) }};
    var averageData = [];
    var deptAttritionArray = [];
    var deptAcronyms = {};

    for(var departmentTitle in departmentAveArray){
        var acronym = departmentTitle.replace("of", "");
        acronym = acronym.replace("and", "");
        acronym = acronym.match(/\b\w/g).join('').toUpperCase();
        deptAcronyms[acronym] = { unitname: departmentTitle };

        averageData.push({department: acronym, deptTitle: departmentTitle, studentcount: departmentAveArray[departmentTitle]});
        deptAttritionArray.push({department: acronym, deptTitle: departmentTitle, attritionrate: departmentAveAttritionArray[departmentTitle]});
    }

    var departmentsAveStudents = new Morris.Bar({
     element: 'department-ave-number-students',
     data: averageData,
     xkey: 'department',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hoverCallback: function(index, options, content){
         var data = options.data[index];
	     $(".morris-hover").html('<div><center> <b>' + data.deptTitle + '</b> <br/> <font color="#0b62a4"> Students: ' + data.studentcount + '</font></center></div>');
     },
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
     hoverCallback: function(index, options, content){
         var data = options.data[index];
		$(".morris-hover").html('<div><center> <b>' + data.deptTitle + '</b> <br/> <font color="#0BC9CD"> Attrition Rate: ' + data.attritionrate + '</font></center></div>');
     },
     hideHover: 'auto',
     resize: true,
     parseTime: false,
     barColors: ['#0BC9CD']
    });

    //legend
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
        $('#department-ave-number-students-legend').append(legendItem1);
        $('#department-ave-number-students-legend').append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
        $('#department-ave-attrition-rate-legend').append(legendItem2);
        $('#department-ave-attrition-rate-legend').append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
    }


</script>
