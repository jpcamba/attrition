<script>
//program
    var programAveArray = {{ json_encode($programAveArray) }};
    var programBatchAttrition = {{ json_encode($programBatchAttrition) }};
    var averageData = [];
    var attritionData = [];
    var progAcronyms = {};

    for(var programTitle in programAveArray){
        var acronym = programTitle.replace("Bachelor Of Science In ", "");
        acronym = acronym.replace("Bachelor Of Arts In ", "");
        acronym = acronym.replace("(Area Studies)", ""); //case of social sciences
        acronym = acronym.replace("Liberal Arts - ", ""); //case of intarmed
        acronym = acronym.replace("Biochemistry", "B C"); //case of biochemistry
        acronym = acronym.replace("Doctor Of ", ""); //case of dentistry

        acronym = acronym.match(/\b\w/g).join('').toUpperCase();
        progAcronyms[acronym] = { programname: programTitle };

        averageData.push({program: acronym, progTitle: programTitle, studentcount: programAveArray[programTitle]});
        attritionData.push({program: acronym, progTitle: programTitle, attritionrate: programBatchAttrition[programTitle]});
    }

    var programsAttrition = new Morris.Bar({
     element: 'program-ave-batch-attrition',
     data: attritionData,
     xkey: 'program',
     ykeys: ['attritionrate'],
     labels: ['Attrition Rate'],
     hoverCallback: function(index, options, content){
         var data = options.data[index];
        $(".morris-hover").html('<div><center> <b>' + data.progTitle + '</b> <br/> <font color="#0b62a4"> Attrition Rate: ' + data.attritionrate + '</font></center></div>');
     },
     hideHover: 'auto',
     xLabelMargin: 10,
     resize: true,
     barColors: ['#0BC9CD']
    });


    var programsAve = new Morris.Bar({
     element: 'program-ave-number-students',
     data: averageData,
     xkey: 'program',
     ykeys: ['studentcount'],
     labels: ['Students'],
     hoverCallback: function(index, options, content){
         var data = options.data[index];
        $(".morris-hover").html('<div><center> <b>' + data.progTitle + '</b> <br/> <font color="#0b62a4"> Students: ' + data.studentcount + '</font></center></div>');
     },
     hideHover: 'auto',
     xLabelMargin: 10,
     resize: true
    });

    //legend
    var colors = ['#2D3047', '#1B998B'];
    var i = 0;
    for(var acr in progAcronyms){
        if(i % 2 == 0){
            var legendItem1 = $('<span></span>').text(acr.concat(" - ", progAcronyms[acr].programname)).css('color', colors[0]);
            var legendItem2 = $('<span></span>').text(acr.concat(" - ", progAcronyms[acr].programname)).css('color', colors[1]);
        }
        else{
            var legendItem1 = $('<span></span>').text(acr.concat(" - ", progAcronyms[acr].programname)).css('color', colors[1]);
            var legendItem2 = $('<span></span>').text(acr.concat(" - ", progAcronyms[acr].programname)).css('color', colors[0]);
        }
        i++;
        $('#program-ave-batch-attrition-legend').append(legendItem1);
        $('#program-ave-batch-attrition-legend').append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
        $('#program-ave-number-students-legend').append(legendItem2);
        $('#program-ave-number-students-legend').append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
    }


</script>
