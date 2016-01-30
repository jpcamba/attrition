@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('college/_college-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Program <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                View attrition for a specific program
            </div>
            <div class="panel-body">
                <h4>Choose a college</h4>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group">
    			    <select class="form-control" required="required" id="college-type-dropdown" name="college-type-dropdown">
                        <option value="">College of Arts and Letters</option>
                        <option value="">College of Fine Arts</option>
                        <option value="">College of Human Kinetics</option>
                        <option value="">College of Mass Communication</option>
                        <option value="">College of Music</option>
                        <option value="">Asian Institute of Tourism</option>
                        <option value="">Cesar E.A. Virata School of Business</option>
                        <option value="">School of Economics</option>
                        <option value="">School of Labor and Industrial Relations</option>
                        <option value="">National College of Public Administration and Governance</option>
                        <option value="">School of Urban and Regional Planning</option>
                        <option value="">Archaeological Studies Program</option>
                        <option value="">College of Architecture</option>
                        <option value="" >College of Engineering</option>
                        <option value="">College of Home Economics</option>
                        <option value="">College of Science</option>
                        <option value="">School of Library and Information Studies</option>
                        <option value="">School of Statistics</option>
                        <option value="">Asian Center</option>
                        <option value="">College of Education</option>
                        <option value="">Institute of Islamic Studies</option>
                        <option value="">College of Law</option>
                        <option value="">College of Social Sciences and Philosophy</option>
                        <option value="">College of Social Work and Community Development</option>
                    </select>
    			  </div>
                </form>
              <!-- end of dropdown -->
                </br>
                <h4>Choose a program</h4>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
                  <div class="input-group">
                    <select class="form-control" required="required" id="program-dropdown" name="program-dropdown">
                        <option value="">BA Broadcast Communication</option>
                        <option value="">BA Communication Research</option>
                        <option value="">BA Film</option>
                        <option value="">BA Journalism</option>
                    </select>
                  </div>
                  <br/>
                  <button type="button" class="btn btn-default">View Program</button>
                </form>
                <!-- end of dropdown -->
            </div>
        </div>
    </div>
</div>

@stop
<!-- /. ROW  -->

@section('javascript')

<script>
    var max = 3000;
    var min = 1000;

    function getRandom() {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

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
        //alert(color);
        randomColorsArray.push(color);
    }


    //college
    var collegemap = {};
    collegemap['2008'] = {year: '2008',
    CollegeofArtsandLetters: getRandom(),
    CollegeofFineArts: getRandom(),
    CollegeofHumanKinetics: getRandom(),
    CollegeofMassCommunication: getRandom(),
    CollegeofMusic: getRandom(),
    AsianInstituteofTourism: getRandom(),
    CesarEVirataSchoolofBusiness: getRandom(),
    SchoolofEconomics: getRandom(),
    SchoolofLaborandIndustrialRelations: getRandom(),
    NationalCollegeofPublicAdministrationandGovernance: getRandom(),
    SchoolofUrbanandRegionalPlanning: getRandom(),
    ArchaeologicalStudiesProgram: getRandom(),
    CollegeofArchitecture: getRandom(),
    CollegeofEngineering: getRandom(),
    CollegeofHomeEconomics: getRandom(),
    CollegeofScience: getRandom(),
    SchoolofLibraryandInformationStudies: getRandom(),
    SchoolofStatistics: getRandom(),
    AsianCenter: getRandom(),
    CollegeofEducation: getRandom(),
    InstituteofIslamicStudies: getRandom(),
    CollegeofLaw: getRandom(),
    CollegeofSocialSciencesandPhilosophy: getRandom(),
    CollegeofSocialWorkandCommunityDevelopment: getRandom()};

    collegemap['2009'] = {year: '2009',
    CollegeofArtsandLetters: getRandom(),
    CollegeofFineArts: getRandom(),
    CollegeofHumanKinetics: getRandom(),
    CollegeofMassCommunication: getRandom(),
    CollegeofMusic: getRandom(),
    AsianInstituteofTourism: getRandom(),
    CesarEVirataSchoolofBusiness: getRandom(),
    SchoolofEconomics: getRandom(),
    SchoolofLaborandIndustrialRelations: getRandom(),
    NationalCollegeofPublicAdministrationandGovernance: getRandom(),
    SchoolofUrbanandRegionalPlanning: getRandom(),
    ArchaeologicalStudiesProgram: getRandom(),
    CollegeofArchitecture: getRandom(),
    CollegeofEngineering: getRandom(),
    CollegeofHomeEconomics: getRandom(),
    CollegeofScience: getRandom(),
    SchoolofLibraryandInformationStudies: getRandom(),
    SchoolofStatistics: getRandom(),
    AsianCenter: getRandom(),
    CollegeofEducation: getRandom(),
    InstituteofIslamicStudies: getRandom(),
    CollegeofLaw: getRandom(),
    CollegeofSocialSciencesandPhilosophy: getRandom(),
    CollegeofSocialWorkandCommunityDevelopment: getRandom()};

    collegemap['2010'] = {year: '2010',
    CollegeofArtsandLetters: getRandom(),
    CollegeofFineArts: getRandom(),
    CollegeofHumanKinetics: getRandom(),
    CollegeofMassCommunication: getRandom(),
    CollegeofMusic: getRandom(),
    AsianInstituteofTourism: getRandom(),
    CesarEVirataSchoolofBusiness: getRandom(),
    SchoolofEconomics: getRandom(),
    SchoolofLaborandIndustrialRelations: getRandom(),
    NationalCollegeofPublicAdministrationandGovernance: getRandom(),
    SchoolofUrbanandRegionalPlanning: getRandom(),
    ArchaeologicalStudiesProgram: getRandom(),
    CollegeofArchitecture: getRandom(),
    CollegeofEngineering: getRandom(),
    CollegeofHomeEconomics: getRandom(),
    CollegeofScience: getRandom(),
    SchoolofLibraryandInformationStudies: getRandom(),
    SchoolofStatistics: getRandom(),
    AsianCenter: getRandom(),
    CollegeofEducation: getRandom(),
    InstituteofIslamicStudies: getRandom(),
    CollegeofLaw: getRandom(),
    CollegeofSocialSciencesandPhilosophy: getRandom(),
    CollegeofSocialWorkandCommunityDevelopment: getRandom()};

    collegemap['2011'] = {year: '2011',
    CollegeofArtsandLetters: getRandom(),
    CollegeofFineArts: getRandom(),
    CollegeofHumanKinetics: getRandom(),
    CollegeofMassCommunication: getRandom(),
    CollegeofMusic: getRandom(),
    AsianInstituteofTourism: getRandom(),
    CesarEVirataSchoolofBusiness: getRandom(),
    SchoolofEconomics: getRandom(),
    SchoolofLaborandIndustrialRelations: getRandom(),
    NationalCollegeofPublicAdministrationandGovernance: getRandom(),
    SchoolofUrbanandRegionalPlanning: getRandom(),
    ArchaeologicalStudiesProgram: getRandom(),
    CollegeofArchitecture: getRandom(),
    CollegeofEngineering: getRandom(),
    CollegeofHomeEconomics: getRandom(),
    CollegeofScience: getRandom(),
    SchoolofLibraryandInformationStudies: getRandom(),
    SchoolofStatistics: getRandom(),
    AsianCenter: getRandom(),
    CollegeofEducation: getRandom(),
    InstituteofIslamicStudies: getRandom(),
    CollegeofLaw: getRandom(),
    CollegeofSocialSciencesandPhilosophy: getRandom(),
    CollegeofSocialWorkandCommunityDevelopment: getRandom()};

    var collegedata = [];
    for (var key in collegemap){
     var value = collegemap[key];
     collegedata.push(value);
    }

    $("#college-year-dropdown").change(function () {
      var selectedYear = $("#college-year-dropdown").val();

      var selectedYearData = [];
      if (selectedYear in collegemap){
       var value = collegemap[selectedYear];
       selectedYearData.push(value);
      }
      else{
          selectedYearData = collegedata;
      }

      $( "#college-yearly-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#college-yearly-dropouts-legend').empty();

      var college = new Morris.Bar({
       element: 'college-yearly-dropouts',
       data: selectedYearData,
       xkey: 'year',
       ykeys: ['CollegeofArtsandLetters','CollegeofFineArts','CollegeofHumanKinetics','CollegeofMassCommunication','CollegeofMusic','AsianInstituteofTourism','CesarEVirataSchoolofBusiness','SchoolofEconomics','SchoolofLaborandIndustrialRelations','NationalCollegeofPublicAdministrationandGovernance','SchoolofUrbanandRegionalPlanning','ArchaeologicalStudiesProgram','CollegeofArchitecture','CollegeofEngineering','CollegeofHomeEconomics','CollegeofScience','SchoolofLibraryandInformationStudies','SchoolofStatistics','AsianCenter','CollegeofEducation','InstituteofIslamicStudies','CollegeofLaw','CollegeofSocialSciencesandPhilosophy','CollegeofSocialWorkandCommunityDevelopment'],
       labels: ['College of Arts and Letters','College of Fine Arts','College of Human Kinetics','College of Mass Communication','College of Music','Asian Institute of Tourism','Cesar E.A. Virata School of Business','School of Economics','School of Labor and Industrial Relations','National College of Public Administration and Governance','School of Urban and Regional Planning','Archaeological Studies Program','College of Architecture','College of Engineering','College of Home Economics','College of Science','School of Library and Information Studies','School of Statistics','Asian Center','College of Education','Institute of Islamic Studies','College of Law','College of Social Sciences and Philosophy','College of Social Work and Community Development'],
       hideHover: 'auto',
       barColors: randomColorsArray
      // resize: true
      });
      //legend
      college.options.labels.forEach(function(label, i){
      var legendItemE2 = $('<span></span>').text(label).css('color', college.options.barColors[i])
      $('#college-yearly-dropouts-legend').append(legendItemE2)
      });
    }).change();


</script>

@stop
