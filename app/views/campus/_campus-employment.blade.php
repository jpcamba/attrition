<div class="row">
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Employment
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                Dropout trend
                <div id="employment-total-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
			      <div class="input-group pull-right" style="width:100px">
				    <select class="form-control" required="required" id="year" name="year">
					  <option value="Unemployed">Unemployed</option><option value="Part-time">Part-time</option><option value="Full-time">Full-time</option>
                    </select>
				  </div>
              </form>
                <!-- end of dropdown -->
                <div id="employment-total-dropouts-legend" class="legend"></div>
            </div>
            <div class="col-md-6">
                Dropouts per batch according to employment type
                <div id="employment-yearly-dropouts"></div>
                <!--Dropdown for prompt-->
                <form action="#" method="get">
			      <div class="input-group pull-right" style="width:100px">
				    <select class="form-control" required="required" id="year" name="year">
					  <option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option>
                      <option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option>
                      <option value="2014">2014</option><option value="2015">2015</option>
                    </select>
				  </div>
                </form>
                <!-- end of dropdown -->
                <div id="employment-yearly-dropouts-legend" class="legend"></div>
            </div>
        </div>
    </div>
</div>
</div>

@section('javascript')
<script>
    alert("one");

    var max = 3000;
    var min = 1000;

    function getRandom() {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    alert("two");

    //employment
    var employmentmap = {};
    employmentmap['2008'] = {year: '2008', unemployed: getRandom(), parttime: getRandom(), fulltime: getRandom()}; // add item
    employmentmap['2009'] = {year: '2009', unemployed: getRandom(), parttime: getRandom(), fulltime: getRandom()}; // add item
    employmentmap['2010'] = {year: '2010', unemployed: getRandom(), parttime: getRandom(), fulltime: getRandom()}; // add item
    employmentmap['2011'] = {year: '2011', unemployed: getRandom(), parttime: getRandom(), fulltime: getRandom()}; // add item
    employmentmap['2012'] = {year: '2012', unemployed: getRandom(), parttime: getRandom(), fulltime: getRandom()}; // add item
    employmentmap['2013'] = {year: '2013', unemployed: getRandom(), parttime: getRandom(), fulltime: getRandom()}; // add item
    employmentmap['2014'] = {year: '2014', unemployed: getRandom(), parttime: getRandom(), fulltime: getRandom()}; // add item
    employmentmap['2015'] = {year: '2015', unemployed: getRandom(), parttime: getRandom(), fulltime: getRandom()}; // add item

    alert("three");

    var employmentdata = [];
    for (var key in employmentmap){
     var value = employmentmap[key];
     employmentdata.push(value);
    }

    alert("three and a half");

    var employment1 = new Morris.Line({
     element: 'employment-total-dropouts',
     data: employmentdata,
     xkey: 'year',
     ykeys: ['unemployed', 'parttime', 'fulltime'],
     labels: ['Unemployed', 'Part-time', 'Full-time']
    });

    alert("four");

    employment1.options.labels.forEach(function(label, i){
    var legendItemE1 = $('<span></span>').text(label).css('color', employment1.options.lineColors[i])
    $('#employment-total-dropouts-legend').append(legendItemE1)
    });

    var employment2 = new Morris.Bar({
     element: 'employment-yearly-dropouts',
     data: employmentdata,
     xkey: 'year',
     ykeys: ['unemployed', 'parttime', 'fulltime'],
     labels: ['Unemployed', 'Part-time', 'Full-time']
    });

    employment2.options.labels.forEach(function(label, i){
    var legendItemE2 = $('<span></span>').text(label).css('color', employment2.options.barColors[i])
    $('#employment-yearly-dropouts-legend').append(legendItemE2)
    });

</script>
@stop
