@section('sidebar')

<li><a href="/campus"><i class="fa fa-dashboard"></i> Campus</a></li>
<li><a href="/college"><i class="fa fa-desktop"></i> College</a></li>
<li><a href="/program"><i class="fa fa-bar-chart-o"></i> Program</a></li>
<li><a class="active-menu" href="/correlation"><i class="fa fa-dashboard"></i> Correlation</a></li>
<li><a href="/prediction"><i class="fa fa-qrcode"></i> Prediction</a></li>
<li><a><i class="fa fa-table"></i> Simulation<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li><a href="/simulation/employment">Employment</a></li>
        <li><a href="/simulation/housing">Housing</a></li>
        <li><a href="/simulation/grades">Grades</a></li>
        <li><a href="/simulation/stdiscount">ST Discount</a></li>
        <li><a href="/simulation/units">Units</a></li>
     </ul>
</li>
@stop
