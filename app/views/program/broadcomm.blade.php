@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('program/_program-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            BA Broadcast Communication <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropouts per batch
            </div>
            <div class="panel-body">
                <div id="program-total-dropouts"></div>
                <center>
                    <h4>Average Number of Dropouts</h4>
                    <h1>
                        <div id="program-ave-dropouts"></div>
                    </h1>
                </center>
            </div>
        </div>
    </div>
</div>


<div class="row">
<div class="col-md-12">
    <h3 class="page-header">
        Trends of Factors
    </h3>
</div>
</div>

<!-- employment -->
<div class="row">
    <div class="col-md-12">
        <h4 class="page-header">
            <b>Employment</b>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropout Trend
            </div>
            <div class="panel-body">
                <div id="employment-total-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:140px">
    			    <select class="form-control" required="required" id="employment-type-dropdown" name="employment-type-dropdown">
    				  <option value="unemployed">Unemployed</option><option value="parttime">Part-time</option><option value="fulltime">Full-time</option><option value="all" selected="selected">All</option>
                    </select>
    			  </div>
              </form>
              <!-- end of dropdown -->
              <div id="employment-total-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropouts per batch according to employment type
            </div>
            <div class="panel-body">
                <div id="employment-yearly-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:100px">
    			    <select class="form-control" required="required" id="employment-year-dropdown" name="employment-year-dropdown">
    				  <option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option>
                      <option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option>
                      <option value="2014">2014</option><option value="2015">2015</option><option value="All" selected="selected">All</option>
                    </select>
    			  </div>
                </form>
                <!-- end of dropdown -->
                <div id="employment-yearly-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
</div>

<!-- housing -->
<div class="row">
    <div class="col-md-12">
        <h4 class="page-header">
            <b>Housing</b>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropout Trend
            </div>
            <div class="panel-body">
                <div id="housing-total-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:140px">
    			    <select class="form-control" required="required" id="housing-type-dropdown" name="housing-type-dropdown">
    				  <option value="dorm">UP Dormitory</option>
                      <option value="ownhouse">Own House</option>
                      <option value="boardinghouseprogram">Boarding House on program</option>
                      <option value="boardinghouseout">Boarding House off program</option>
                      <option value="rented">Rented House</option>
                      <option value="relative">Relative's/Guardian's House</option>
                      <option value="others">Others</option>
                      <option value="all" selected="selected">All</option>
                    </select>
    			  </div>
              </form>
              <!-- end of dropdown -->
              <div id="housing-total-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropouts per batch according to housing type
            </div>
            <div class="panel-body">
                <div id="housing-yearly-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:100px">
    			    <select class="form-control" required="required" id="housing-year-dropdown" name="housing-year-dropdown">
    				  <option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option>
                      <option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option>
                      <option value="2014">2014</option><option value="2015">2015</option><option value="All" selected="selected">All</option>
                    </select>
    			  </div>
                </form>
                <!-- end of dropdown -->
                <div id="housing-yearly-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
</div>


<!-- grades -->
<div class="row">
    <div class="col-md-12">
        <h4 class="page-header">
            <b>Grades</b>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropout Trend
            </div>
            <div class="panel-body">
                <div id="grades-total-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:140px">
    			    <select class="form-control" required="required" id="grades-type-dropdown" name="grades-type-dropdown">
    				  <option value="lineof1">1-1.99</option>
                      <option value="lineof2">2-2.99</option>
                      <option value="lineof3">3-3.99</option>
                      <option value="lineof4">4-4.99</option>
                      <option value="lineof5">5</option>
                      <option value="all" selected="selected">All</option>
                    </select>
    			  </div>
              </form>
              <!-- end of dropdown -->
              <div id="grades-total-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropouts per batch according to grades
            </div>
            <div class="panel-body">
                <div id="grades-yearly-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:100px">
    			    <select class="form-control" required="required" id="grades-year-dropdown" name="grades-year-dropdown">
    				  <option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option>
                      <option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option>
                      <option value="2014">2014</option><option value="2015">2015</option><option value="All" selected="selected">All</option>
                    </select>
    			  </div>
                </form>
                <!-- end of dropdown -->
                <div id="grades-yearly-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
</div>


<!-- stdiscount -->
<div class="row">
    <div class="col-md-12">
        <h4 class="page-header">
            <b>ST Discount</b>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropout Trend
            </div>
            <div class="panel-body">
                <div id="stdiscount-total-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:140px">
    			    <select class="form-control" required="required" id="stdiscount-type-dropdown" name="stdiscount-type-dropdown">
    				  <option value="percent33">33% Discount</option>
                      <option value="percent60">60% Discount</option>
                      <option value="percent80">80% Discount</option>
                      <option value="percent100">100% Discount</option>
                      <option value="all" selected="selected">All</option>
                    </select>
    			  </div>
              </form>
              <!-- end of dropdown -->
              <div id="stdiscount-total-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropouts per batch according to ST Discount
            </div>
            <div class="panel-body">
                <div id="stdiscount-yearly-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:100px">
    			    <select class="form-control" required="required" id="stdiscount-year-dropdown" name="stdiscount-year-dropdown">
    				  <option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option>
                      <option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option>
                      <option value="2014">2014</option><option value="2015">2015</option><option value="All" selected="selected">All</option>
                    </select>
    			  </div>
                </form>
                <!-- end of dropdown -->
                <div id="stdiscount-yearly-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
</div>


<!-- units -->
<div class="row">
    <div class="col-md-12">
        <h4 class="page-header">
            <b>Units</b>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropout Trend
            </div>
            <div class="panel-body">
                <div id="units-total-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:140px">
    			    <select class="form-control" required="required" id="units-type-dropdown" name="units-type-dropdown">
    				  <option value="underload">Less than 15 units</option>
                      <option value="regular">15 to 21 units</option>
                      <option value="overload">More than 15 units</option>
                      <option value="all" selected="selected">All</option>
                    </select>
    			  </div>
              </form>
              <!-- end of dropdown -->
              <div id="units-total-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Dropouts per batch according to number of units
            </div>
            <div class="panel-body">
                <div id="units-yearly-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
    		      <div class="input-group pull-right" style="width:100px">
    			    <select class="form-control" required="required" id="units-year-dropdown" name="units-year-dropdown">
    				  <option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option>
                      <option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option>
                      <option value="2014">2014</option><option value="2015">2015</option><option value="All" selected="selected">All</option>
                    </select>
    			  </div>
                </form>
                <!-- end of dropdown -->
                <div id="units-yearly-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
</div>

<!-- additional info -->
<div class="row">
    <div class="col-md-12">
        <h3 class="page-header">
            Additional Information
        </h3>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Cost of Making a Student Graduate</h4>
                    <h1>P 600,000</h1>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Average Years to Graduate</h4>
                    <h1>4.5</h1>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Average Years to Shift</h4>
                    <h1>2</h1>
                </center>
            </div>
        </div>
    </div>
</div>

@stop
<!-- /. ROW  -->

@section('javascript')

<script>
    var max = 500;
    var min = 100;

    function getRandom() {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }


    //program
    var totaldata = [
     {year: '2008', value: getRandom()},
     {year: '2009', value: getRandom()},
     {year: '2010', value: getRandom()},
     {year: '2011', value: getRandom()},
     {year: '2012', value: getRandom()},
     {year: '2013', value: getRandom()},
     {year: '2014', value: getRandom()},
     {year: '2015', value: getRandom()}];

    new Morris.Area({
     // ID of the element in which to draw the chart.
     element: 'program-total-dropouts',
     // Chart data records -- each entry in this array corresponds to a point on the chart.

     data: totaldata,
     // The name of the data record attribute that contains x-values.
     xkey: 'year',

     ykeys: ['value'],
     labels: ['Students'],
     hideHover: 'auto',
    // resize: true
    });

    //average
    var count = totaldata.length;
    var total = 0;
    for (var x = 0; x < count; x++){
        total += totaldata[x]['value'];
    }
    var avg = total / count;
    $('#program-ave-dropouts').append(avg);


    //employment
    var employmentmap = {};
    employmentmap['2008'] = {year: '2008', unemployed: getRandom(), parttime: getRandom(),fulltime: getRandom()}; // add item
    employmentmap['2009'] = {year: '2009', unemployed: getRandom(), parttime: getRandom(),fulltime: getRandom()}; // add item
    employmentmap['2010'] = {year: '2010', unemployed: getRandom(), parttime: getRandom(),fulltime: getRandom()}; // add item
    employmentmap['2011'] = {year: '2011', unemployed: getRandom(), parttime: getRandom(),fulltime: getRandom()}; // add item
    employmentmap['2012'] = {year: '2012', unemployed: getRandom(), parttime: getRandom(),fulltime: getRandom()}; // add item
    employmentmap['2013'] = {year: '2013', unemployed: getRandom(), parttime: getRandom(),fulltime: getRandom()}; // add item
    employmentmap['2014'] = {year: '2014', unemployed: getRandom(), parttime: getRandom(),fulltime: getRandom()}; // add item
    employmentmap['2015'] = {year: '2015', unemployed: getRandom(), parttime: getRandom(),fulltime: getRandom()}; // add item

    var employmentdata = [];
    for (var key in employmentmap){
     var value = employmentmap[key];
     employmentdata.push(value);
    }

    //employment1 dropdown javascript
    $("#employment-type-dropdown").change(function () {
      var selectedType = $("#employment-type-dropdown").val();
      var selectedTypeData = [];
      var selectedTypeLabel = [];
      if( selectedType == "all" ){
          selectedTypeData = ['unemployed', 'parttime', 'fulltime'];
          selectedTypeLabel = ['Unemployed', 'Part-time', 'Full-time'];
      }
      else{
          selectedTypeData.push(selectedType);
          switch(selectedType){
              case 'unemployed': selectedTypeLabel.push('Unemployed'); break;
              case 'parttime': selectedTypeLabel.push('Part-time'); break;
              case 'fulltime': selectedTypeLabel.push('Full-time'); break;
          }
      }

      $( "#employment-total-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#employment-total-dropouts-legend').empty();

      var employment1 = new Morris.Line({
       element: 'employment-total-dropouts',
       data: employmentdata,
       xkey: 'year',
       ykeys: selectedTypeData,
       labels: selectedTypeLabel,
       hideHover: 'auto'
       //resize: true
      });
      //legend
      employment1.options.labels.forEach(function(label, i){
      var legendItemE1 = $('<span></span>').text(label).css('color', employment1.options.lineColors[i])
      $('#employment-total-dropouts-legend').append(legendItemE1)
      });
    }).change();

    //employment2 dropdown javascript
    $("#employment-year-dropdown").change(function () {
      var selectedYear = $("#employment-year-dropdown").val();

      var selectedYearData = [];
      if (selectedYear in employmentmap){
       var value = employmentmap[selectedYear];
       selectedYearData.push(value);
      }
      else{
          selectedYearData = employmentdata;
      }

      $( "#employment-yearly-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#employment-yearly-dropouts-legend').empty();

      var employment2 = new Morris.Bar({
       element: 'employment-yearly-dropouts',
       data: selectedYearData,
       xkey: 'year',
       ykeys: ['unemployed', 'parttime', 'fulltime'],
       labels: ['Unemployed', 'Part-time', 'Full-time'],
       hideHover: 'auto'
      // resize: true
      });
      //legend
      employment2.options.labels.forEach(function(label, i){
      var legendItemE2 = $('<span></span>').text(label).css('color', employment2.options.barColors[i])
      $('#employment-yearly-dropouts-legend').append(legendItemE2)
      });
    }).change();


    //housing
    var housingmap = {};
    housingmap['2008'] = {year: '2008', dorm: getRandom(), ownhouse: getRandom(), boardinghouseprogram: getRandom(),  boardinghouseout: getRandom(), rented: getRandom(), relative: getRandom(), others: getRandom()}; // add item
    housingmap['2009'] = {year: '2009', dorm: getRandom(), ownhouse: getRandom(), boardinghouseprogram: getRandom(),  boardinghouseout: getRandom(), rented: getRandom(), relative: getRandom(), others: getRandom()}; // add item
    housingmap['2010'] = {year: '2010', dorm: getRandom(), ownhouse: getRandom(), boardinghouseprogram: getRandom(),  boardinghouseout: getRandom(), rented: getRandom(), relative: getRandom(), others: getRandom()}; // add item
    housingmap['2011'] = {year: '2011', dorm: getRandom(), ownhouse: getRandom(), boardinghouseprogram: getRandom(),  boardinghouseout: getRandom(), rented: getRandom(), relative: getRandom(), others: getRandom()}; // add item
    housingmap['2012'] = {year: '2012', dorm: getRandom(), ownhouse: getRandom(), boardinghouseprogram: getRandom(),  boardinghouseout: getRandom(), rented: getRandom(), relative: getRandom(), others: getRandom()}; // add item
    housingmap['2013'] = {year: '2013', dorm: getRandom(), ownhouse: getRandom(), boardinghouseprogram: getRandom(),  boardinghouseout: getRandom(), rented: getRandom(), relative: getRandom(), others: getRandom()}; // add item
    housingmap['2014'] = {year: '2014', dorm: getRandom(), ownhouse: getRandom(), boardinghouseprogram: getRandom(),  boardinghouseout: getRandom(), rented: getRandom(), relative: getRandom(), others: getRandom()}; // add item
    housingmap['2015'] = {year: '2015', dorm: getRandom(), ownhouse: getRandom(), boardinghouseprogram: getRandom(),  boardinghouseout: getRandom(), rented: getRandom(), relative: getRandom(), others: getRandom()}; // add item

    var housingdata = [];
    for (var key in housingmap){
     var value = housingmap[key];
     housingdata.push(value);
    }

    //housing1 dropdown javascript
    $("#housing-type-dropdown").change(function () {
      var selectedType = $("#housing-type-dropdown").val();
      var selectedTypeData = [];
      var selectedTypeLabel = [];
      if( selectedType == "all" ){
          selectedTypeData = ['dorm', 'ownhouse', 'boardinghouseprogram',  'boardinghouseout', 'rented', 'relative', 'others'];
          selectedTypeLabel = ['UP Dormitory', 'Own House', 'Boarding House on program', 'Boarding House off program', 'Rented House', 'Relatives/Guardians House', 'Others'];
      }
      else{
          selectedTypeData.push(selectedType);
          switch(selectedType){
              case 'dorm': selectedTypeLabel.push('UP Dormitory'); break;
              case 'ownhouse': selectedTypeLabel.push('Own House'); break;
              case 'boardinghouseprogram': selectedTypeLabel.push('Boarding House on program'); break;
              case 'boardinghouseout': selectedTypeLabel.push('Boarding House off program'); break;
              case 'rented': selectedTypeLabel.push('Rented House'); break;
              case 'relative': selectedTypeLabel.push('Relatives/Guardians House'); break;
              case 'others': selectedTypeLabel.push('Others'); break;
          }
      }

      $( "#housing-total-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#housing-total-dropouts-legend').empty();

      var housing1 = new Morris.Line({
       element: 'housing-total-dropouts',
       data: housingdata,
       xkey: 'year',
       ykeys: selectedTypeData,
       labels: selectedTypeLabel,
       hideHover: 'auto'
       //resize: true
      });
      //legend
      housing1.options.labels.forEach(function(label, i){
      var legendItemE1 = $('<span></span>').text(label).css('color', housing1.options.lineColors[i])
      $('#housing-total-dropouts-legend').append(legendItemE1)
      });
    }).change();

    //housing2 dropdown javascript
    $("#housing-year-dropdown").change(function () {
      var selectedYear = $("#housing-year-dropdown").val();

      var selectedYearData = [];
      if (selectedYear in housingmap){
       var value = housingmap[selectedYear];
       selectedYearData.push(value);
      }
      else{
          selectedYearData = housingdata;
      }

      $( "#housing-yearly-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#housing-yearly-dropouts-legend').empty();

      var housing2 = new Morris.Bar({
       element: 'housing-yearly-dropouts',
       data: selectedYearData,
       xkey: 'year',
       ykeys: ['dorm', 'ownhouse', 'boardinghouseprogram',  'boardinghouseout', 'rented', 'relative', 'others'],
       labels: ['UP Dormitory', 'Own House', 'Boarding House on program', 'Boarding House off program', 'Rented House', 'Relatives/Guardians House', 'Others'],
       hideHover: 'auto'
      // resize: true
      });
      //legend
      housing2.options.labels.forEach(function(label, i){
      var legendItemE2 = $('<span></span>').text(label).css('color', housing2.options.barColors[i])
      $('#housing-yearly-dropouts-legend').append(legendItemE2)
      });
    }).change();


    //grades
    var gradesmap = {};
    gradesmap['2008'] = {year: '2008', lineof1: getRandom(), lineof2: getRandom(), lineof3: getRandom(),  lineof4: getRandom(), lineof5: getRandom()}; // add item
    gradesmap['2009'] = {year: '2009', lineof1: getRandom(), lineof2: getRandom(), lineof3: getRandom(),  lineof4: getRandom(), lineof5: getRandom()}; // add item
    gradesmap['2010'] = {year: '2010', lineof1: getRandom(), lineof2: getRandom(), lineof3: getRandom(),  lineof4: getRandom(), lineof5: getRandom()}; // add item
    gradesmap['2011'] = {year: '2011', lineof1: getRandom(), lineof2: getRandom(), lineof3: getRandom(),  lineof4: getRandom(), lineof5: getRandom()}; // add item
    gradesmap['2012'] = {year: '2012', lineof1: getRandom(), lineof2: getRandom(), lineof3: getRandom(),  lineof4: getRandom(), lineof5: getRandom()}; // add item
    gradesmap['2013'] = {year: '2013', lineof1: getRandom(), lineof2: getRandom(), lineof3: getRandom(),  lineof4: getRandom(), lineof5: getRandom()}; // add item
    gradesmap['2014'] = {year: '2014', lineof1: getRandom(), lineof2: getRandom(), lineof3: getRandom(),  lineof4: getRandom(), lineof5: getRandom()}; // add item
    gradesmap['2015'] = {year: '2015', lineof1: getRandom(), lineof2: getRandom(), lineof3: getRandom(),  lineof4: getRandom(), lineof5: getRandom()}; // add item

    var gradesdata = [];
    for (var key in gradesmap){
     var value = gradesmap[key];
     gradesdata.push(value);
    }

    //grades1 dropdown javascript
    $("#grades-type-dropdown").change(function () {
      var selectedType = $("#grades-type-dropdown").val();
      var selectedTypeData = [];
      var selectedTypeLabel = [];
      if( selectedType == "all" ){
          selectedTypeData = ['lineof1', 'lineof2', 'lineof3', 'lineof4', 'lineof5'];
          selectedTypeLabel = ['1-1.99', '2-2.99', '3-3.99', '4-4.99', '5'];
      }
      else{
          selectedTypeData.push(selectedType);
          switch(selectedType){
              case 'lineof1': selectedTypeLabel.push('1-1.99'); break;
              case 'lineof2': selectedTypeLabel.push('2-2.99'); break;
              case 'lineof3': selectedTypeLabel.push('3-3.99'); break;
              case 'lineof4': selectedTypeLabel.push('4-4.99'); break;
              case 'lineof5': selectedTypeLabel.push('5'); break;
          }
      }

      $( "#grades-total-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#grades-total-dropouts-legend').empty();

      var grades1 = new Morris.Line({
       element: 'grades-total-dropouts',
       data: gradesdata,
       xkey: 'year',
       ykeys: selectedTypeData,
       labels: selectedTypeLabel,
       hideHover: 'auto'
       //resize: true
      });
      //legend
      grades1.options.labels.forEach(function(label, i){
      var legendItemE1 = $('<span></span>').text(label).css('color', grades1.options.lineColors[i])
      $('#grades-total-dropouts-legend').append(legendItemE1)
      });
    }).change();

    //grades2 dropdown javascript
    $("#grades-year-dropdown").change(function () {
      var selectedYear = $("#grades-year-dropdown").val();

      var selectedYearData = [];
      if (selectedYear in gradesmap){
       var value = gradesmap[selectedYear];
       selectedYearData.push(value);
      }
      else{
          selectedYearData = gradesdata;
      }

      $( "#grades-yearly-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#grades-yearly-dropouts-legend').empty();

      var grades2 = new Morris.Bar({
       element: 'grades-yearly-dropouts',
       data: selectedYearData,
       xkey: 'year',
       ykeys: ['lineof1', 'lineof2', 'lineof3', 'lineof4', 'lineof5'],
       labels: ['1-1.99', '2-2.99', '3-3.99', '4-4.99', '5'],
       hideHover: 'auto'
      // resize: true
      });
      //legend
      grades2.options.labels.forEach(function(label, i){
      var legendItemE2 = $('<span></span>').text(label).css('color', grades2.options.barColors[i])
      $('#grades-yearly-dropouts-legend').append(legendItemE2)
      });
    }).change();




    //stdiscount
    var stdiscountmap = {};
    stdiscountmap['2008'] = {year: '2008', percent33: getRandom(), percent60: getRandom(), percent80: getRandom(),  percent100: getRandom()};
    stdiscountmap['2009'] = {year: '2009', percent33: getRandom(), percent60: getRandom(), percent80: getRandom(),  percent100: getRandom()};
    stdiscountmap['2010'] = {year: '2010', percent33: getRandom(), percent60: getRandom(), percent80: getRandom(),  percent100: getRandom()};
    stdiscountmap['2011'] = {year: '2011', percent33: getRandom(), percent60: getRandom(), percent80: getRandom(),  percent100: getRandom()};
    stdiscountmap['2012'] = {year: '2012', percent33: getRandom(), percent60: getRandom(), percent80: getRandom(),  percent100: getRandom()};
    stdiscountmap['2013'] = {year: '2013', percent33: getRandom(), percent60: getRandom(), percent80: getRandom(),  percent100: getRandom()};
    stdiscountmap['2014'] = {year: '2014', percent33: getRandom(), percent60: getRandom(), percent80: getRandom(),  percent100: getRandom()};
    stdiscountmap['2015'] = {year: '2015', percent33: getRandom(), percent60: getRandom(), percent80: getRandom(),  percent100: getRandom()};

    var stdiscountdata = [];
    for (var key in stdiscountmap){
     var value = stdiscountmap[key];
     stdiscountdata.push(value);
    }

    //stdiscount1 dropdown javascript
    $("#stdiscount-type-dropdown").change(function () {
      var selectedType = $("#stdiscount-type-dropdown").val();
      var selectedTypeData = [];
      var selectedTypeLabel = [];
      if( selectedType == "all" ){
          selectedTypeData = ['percent33', 'percent60', 'percent80', 'percent100'];
          selectedTypeLabel = ['33% Discount', '60% Discount', '80% Discount', '100% Discount'];
      }
      else{
          selectedTypeData.push(selectedType);
          switch(selectedType){
              case 'percent33': selectedTypeLabel.push('33% Discount'); break;
              case 'percent60': selectedTypeLabel.push('60% Discount'); break;
              case 'percent80': selectedTypeLabel.push('80% Discount'); break;
              case 'percent100': selectedTypeLabel.push('100% Discount'); break;
          }
      }

      $( "#stdiscount-total-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#stdiscount-total-dropouts-legend').empty();

      var stdiscount1 = new Morris.Line({
       element: 'stdiscount-total-dropouts',
       data: stdiscountdata,
       xkey: 'year',
       ykeys: selectedTypeData,
       labels: selectedTypeLabel,
       hideHover: 'auto'
       //resize: true
      });
      //legend
      stdiscount1.options.labels.forEach(function(label, i){
      var legendItemE1 = $('<span></span>').text(label).css('color', stdiscount1.options.lineColors[i])
      $('#stdiscount-total-dropouts-legend').append(legendItemE1)
      });
    }).change();

    //stdiscount2 dropdown javascript
    $("#stdiscount-year-dropdown").change(function () {
      var selectedYear = $("#stdiscount-year-dropdown").val();

      var selectedYearData = [];
      if (selectedYear in stdiscountmap){
       var value = stdiscountmap[selectedYear];
       selectedYearData.push(value);
      }
      else{
          selectedYearData = stdiscountdata;
      }

      $( "#stdiscount-yearly-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#stdiscount-yearly-dropouts-legend').empty();

      var stdiscount2 = new Morris.Bar({
       element: 'stdiscount-yearly-dropouts',
       data: selectedYearData,
       xkey: 'year',
       ykeys: ['percent33', 'percent60', 'percent80', 'percent100'],
       labels: ['33% Discount', '60% Discount', '80% Discount', '100% Discount'],
       hideHover: 'auto'
      // resize: true
      });
      //legend
      stdiscount2.options.labels.forEach(function(label, i){
      var legendItemE2 = $('<span></span>').text(label).css('color', stdiscount2.options.barColors[i])
      $('#stdiscount-yearly-dropouts-legend').append(legendItemE2)
      });
    }).change();



    //units
    var unitsmap = {};
    unitsmap['2008'] = {year: '2008', underload: getRandom(), regular: getRandom(), overload: getRandom()};
    unitsmap['2009'] = {year: '2009', underload: getRandom(), regular: getRandom(), overload: getRandom()};
    unitsmap['2010'] = {year: '2010', underload: getRandom(), regular: getRandom(), overload: getRandom()};
    unitsmap['2011'] = {year: '2011', underload: getRandom(), regular: getRandom(), overload: getRandom()};
    unitsmap['2012'] = {year: '2012', underload: getRandom(), regular: getRandom(), overload: getRandom()};
    unitsmap['2013'] = {year: '2013', underload: getRandom(), regular: getRandom(), overload: getRandom()};
    unitsmap['2014'] = {year: '2014', underload: getRandom(), regular: getRandom(), overload: getRandom()};
    unitsmap['2015'] = {year: '2015', underload: getRandom(), regular: getRandom(), overload: getRandom()};

    var unitsdata = [];
    for (var key in unitsmap){
     var value = unitsmap[key];
     unitsdata.push(value);
    }

    //units1 dropdown javascript
    $("#units-type-dropdown").change(function () {
      var selectedType = $("#units-type-dropdown").val();
      var selectedTypeData = [];
      var selectedTypeLabel = [];
      if( selectedType == "all" ){
          selectedTypeData = ['underload', 'regular', 'overload'];
          selectedTypeLabel = ['Less than 15 units', '15 to 21 units', 'More than 21 units'];
      }
      else{
          selectedTypeData.push(selectedType);
          switch(selectedType){
              case 'underload': selectedTypeLabel.push('Less than 15 units'); break;
              case 'regular': selectedTypeLabel.push('15 to 21 units'); break;
              case 'overload': selectedTypeLabel.push('More than 21 units'); break;
          }
      }

      $( "#units-total-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#units-total-dropouts-legend').empty();

      var units1 = new Morris.Line({
       element: 'units-total-dropouts',
       data: unitsdata,
       xkey: 'year',
       ykeys: selectedTypeData,
       labels: selectedTypeLabel,
       hideHover: 'auto'
       //resize: true
      });
      //legend
      units1.options.labels.forEach(function(label, i){
      var legendItemE1 = $('<span></span>').text(label).css('color', units1.options.lineColors[i])
      $('#units-total-dropouts-legend').append(legendItemE1)
      });
    }).change();

    //units2 dropdown javascript
    $("#units-year-dropdown").change(function () {
      var selectedYear = $("#units-year-dropdown").val();

      var selectedYearData = [];
      if (selectedYear in unitsmap){
       var value = unitsmap[selectedYear];
       selectedYearData.push(value);
      }
      else{
          selectedYearData = unitsdata;
      }

      $( "#units-yearly-dropouts" ).empty(); //clear content of div so graph will be replaced
      $('#units-yearly-dropouts-legend').empty();

      var units2 = new Morris.Bar({
       element: 'units-yearly-dropouts',
       data: selectedYearData,
       xkey: 'year',
       ykeys: ['underload', 'regular', 'overload'],
       labels: ['Less than 15 units', '15 to 21 units', 'More than 21 units'],
       hideHover: 'auto'
      // resize: true
      });
      //legend
      units2.options.labels.forEach(function(label, i){
      var legendItemE2 = $('<span></span>').text(label).css('color', units2.options.barColors[i])
      $('#units-yearly-dropouts-legend').append(legendItemE2)
      });
    }).change();





</script>

@stop
