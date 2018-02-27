<html>
<head>
    <title>Gestion Abonement - @yield('title')</title>
    @section('import')
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/menu.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
             #layout { width:100%;  margin:0; padding:0;}
            body { margin:0; padding:0;}
            .row {  margin:0; padding:0;}
        </style>
    @show
</head>
<body>
@section('sidebar')
@show

<div class="container" id="layout">


                            <nav class="navbar navbar-default sidebar" role="navigation">
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
                                                <a href="http://127.0.0.1:8000/clients/">CLIENTS<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a>
                                            </li>
                                            <li >
                                                <a href="#">DASHBOARD<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-signal"></span></a>
                                            </li>
                                            <li >
                                                <a href="#">ALERTS<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-bullhorn"></span></a>
                                            </li>

                                            <li >
                                                <a href="#">ABONNEMENTS<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-file"></span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>



                           @yield('content')



</body>
</html>