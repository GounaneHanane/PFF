<html>
<head>
    <title>Gestion Abonement - @yield('title')</title>
    @section('import')
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/menu.css">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>

        </style>
    @show
</head>
<body>
@section('sidebar')
@show



<nav class="navbar navbar-default sidebar nav-side-menu" role="navigation" >
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a><img src="http://opentech.ma/wp-content/uploads/2017/06/logo-website_new.png"></a>
                </li>
                <li >
                    <a href="client.html">CLIENTS<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a>
                </li>
                <li >
                    <a href="DASHBOARD.html">DASHBOARD<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-signal"></span></a>
                </li>
                <li >
                    <a href="ALERTeS.html">ALERTS<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-bullhorn"></span></a>
                </li>
                <li >
                    <a href="abonnements.html">ABONNEMENTS<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-file"></span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>


                           @yield('content')



</body>
</html>