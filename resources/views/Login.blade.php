<html>
<head>
    <link rel='stylesheet' href='/css/login.css' />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">

    <div class="row" id="pwd-container">
        <div class="col-md-4"></div>

        <div class="col-md-4">
            <section class="login-form">
                <form method="post"  role="login">
                    <img src="http://opentech.ma/wp-content/uploads/2017/06/logo-website_new.png" class="img-responsive" alt="" />
                    <input type="text" name="username" placeholder="Username" required class="form-control input-lg"  />

                    <input type="password" class="form-control input-lg" id="Password" placeholder="Password" required="" />


                    <div class="pwstrength_viewport_progress"></div>


                    <button  name="go" class="btn btn-lg btn-primary btn-block" onclick="window.open('client.html','_self' )">Sign in</button>

                </form>

            </section>
        </div>

        <div class="col-md-4"></div>


    </div>

    <script type="text/javascript">

    </script>

</div>
</body>
</html>