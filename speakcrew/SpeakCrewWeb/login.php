
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Main css -->
    <link rel="stylesheet" href="css/logregstyle.css">
    <meta name="google-signin-client_id" content="372361181870-hhfheo9aovja4hmucjoql5ad53ua1sku.apps.googleusercontent.com">

    <script>
    function onSignIn(googleUser) {
            if (googleUser.isSignedIn()) {

          var profile = googleUser.getBasicProfile();
          var id =profile.getId();
          var name =profile.getName();
          var image =profile.getImageUrl();
          var email =profile.getEmail();
          var google = "google";
          console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
          console.log('Name: ' + profile.getName());
          console.log('Image URL: ' + profile.getImageUrl());
          console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

          $.post("./validation.php",
          { gid : id , gname : name , gimage : image , gemail : email , gg : google},
          function(data, status){
              console.log("구글 로그인 성공");
              location.replace("./index.php");
        }
        )
    }else{
        console.log("구글로그인 전");
    }
    }
  </script>

</head>
<body>
    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="img/signin-image.jpg" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Create an account</a>
                    </div>


                    <form action="validation.php" method="POST" class="register-form" id="login-form">
                    <div class="signin-form">
                        <a class="navbar-brand" href="./index.php"><span>SpeakCrew</span></a>
                        <h2 class="form-title">로그인</h2>
                            <div class="form-group">
                                <label for="id"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="id" id="id" placeholder="Id"/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Auto Login</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>

                          <div class="g-signin2" data-onsuccess="onSignIn"></div>

                    </div>
                </div>
            </div>
        </section>

    </div>
<script src="https://apis.google.com/js/platform.js" async defer></script>
     <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
