<html>
<head>
    <title>OMS| @yield('title')</title>
    @section('import')
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="http://oms.opentech.codes/dist/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <link rel="stylesheet" href="/css/menu.css" />
        <link rel="stylesheet" href="/css/mobile.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>




<style>
    #alert
    {
        border-bottom: 2px solid #3498DB;
        padding-bottom: 4%;


    }
</style>
    @show
</head>
<body>
@section('sidebar')
@show




<header>
    <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><img src="/img/notifications-button.png" id="setting">
            </button>
    </div>

    <div class="user">
        <i class="glyphicon glyphicon-user" style="    float: left;
    padding-right: 8px;   "></i>Bonjour : Admin
    </div>
</header>
<div  class="container-fluid">

    <div class="row" style="    margin-left: -15px;">
        <div class="col-sm-3">
            <div class="nav-side-menu">

                <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

                <div class="menu-list">

                    <ul id="menu-content" class="menu-content collapse out">

                        <div class="brand" style="color: #337ab7">  <a href="/home"><img src="http://opentech.ma/wp-content/uploads/2017/06/logo-website_new.png"></a></div>

                        <li >
                            <a href="/clients"  class="submenu-toggle">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>CLIENTS</span>
                            </a>

                        </li>

                        <li >
                            <a href="/dashboard"  class="submenu-toggle">
                                <i class="glyphicon glyphicon-signal"></i>
                                <span>DASHBOARD</span>
                            </a>

                        </li>


                        <li >
                            <a href="/contrat"  class="submenu-toggle">
                                <i class="glyphicon glyphicon-file"></i>
                                <span>CONTRATS</span>
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>



@yield('content')



</body>
</html>