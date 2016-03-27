<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        @section('title')
            UP Undergraduate Attrition Study
        @show
        </title>
    <!-- Bootstrap Styles-->
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="{{asset('assets/css/font-awesome.css')}}" rel="stylesheet" />
     <!-- Morris Chart Styles-->
    <link href="{{asset('assets/js/morris/morris-0.4.3.min.css')}}" rel="stylesheet" />
        <!-- Custom Styles-->
    <link href="{{asset('assets/css/custom-styles.css')}}" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation" style="height: 50px;width: 100vw;">
            <div class="navbar-header">
                <a class="navbar-brand" href="/" style="padding-bottom: 0px; padding-top: 10px; padding-right: 0px; width: 500px; height: 50px; padding-left: 10px;"><strong>UP Undergraduate Attrition Study</strong></a>
            </div>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation" style="top: 50px; left: 0px;">
		<div id="sideNav" href="" style="top: 0px;"><i class="fa fa-caret-right" style="top: -10; top: 0px;"></i></div>
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <!-- Insert sidebar -->
                    @yield('sidebar')

                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" style="padding-top: 0px; top: 50px; margin-left: 260px;">
            <div id="page-inner" style="margin-top: 0px;">

                <!--Insert individual page content-->
                @yield('content')

                <footer><p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p></footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script type="text/javascript" src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
    <!-- Bootstrap Js -->
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <!-- Metis Menu Js -->
    <script type="text/javascript" src="{{asset('assets/js/jquery.metisMenu.js')}}"></script>
    <!-- Morris Chart Js -->
    <script type="text/javascript" src="{{asset('assets/js/morris/raphael-2.1.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/morris/morris.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/easypiechart.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/easypiechart-data.js')}}"></script>
    <!-- Custom Js -->
    <script type="text/javascript" src="{{asset('assets/js/custom-scripts.js')}}"></script>
    <!-- DATA TABLE SCRIPTS -->
    <!--<script type="text/javascript" src="{{asset('assets/js/dataTables/jquery.dataTables.js')}}"></script>-->
    <!--<script type="text/javascript" src="{{asset('assets/js/dataTables/dataTables.bootstrap.js')}}"></script>-->

    <!-- Javascript -->
    @yield('javascript')

<!--        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>-->


</body>
</html>
