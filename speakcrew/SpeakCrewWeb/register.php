
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
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
           <script src="vendor/jquery/jquery.min.js"></script>
           <script src="js/main.js"></script>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Main css -->
    <link rel="stylesheet" href="css/logregstyle.css">
</head>
<body>



    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                         <a class="navbar-brand" href="./index.php"><span>SpeakCrew</span></a>

                        <h2 class="form-title">
                            회원가입</h2>
                             <div class="g-signin2" data-onsuccess="onSignIn">구글 계정으로 가입하기</div>
                             <br/>
                        <form name="input" action="regvalidation.php" method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="id"><i class="zmdi zmdi-email"></i></label>
                                <input type="text" name="id" id="id" placeholder="Id" onfocusout="id_check()" required/>
                            </div>
                        <div id ="about-id">
                        </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="email" onfocusout="email_match()" required/>
                            </div>
                            <div id ="about-email">
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input  type="password" name="password" id="pass" placeholder="Password" required />
                            </div>
                            <div class="form-group">
                                <label for="repassword"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input  type="password" name="repassword" id="repassword" placeholder="Repeat password" onfocusout="password_match()" required/>
                            </div>
                            <div id ="show-result">
                            </div>
                            <script src="js/jquery-3.3.1.min.js"></script>

                            <script>

                            function id_check(){ //아이디 중복체크
                                //사용자 입력 아이디 가져옴
                                var id = document.getElementById('id').value;

                                //기존에 있는 아이딘지 확인하고 글씨 띄어주어 사용자에게 알려줌
                                $.post('check.php',{
                                    id1: id
                                },

                                function(data, status){
                                    document.getElementById('about-id').innerHTML = data;
                                })
                                }

                            function password_match(){ //패스워드 일치확인
                                //사용자 입력 패스워드 가져옴
                                var password1 =document.getElementById('pass').value;
                                var password2 =document.getElementById('repassword').value;

                                //패스워드 일치여부에 따라 다른 글씨 띄어줌
                                $.post("check.php",{
                                    pass1: password1, pass2: password2
                                },

                                function(data, status){
                                    document.getElementById('show-result').innerHTML =data;
                                })
                            }
                            function email_match(){
                                var email = document.getElementById('email').value;
                                $.post("check.php",{
                                    email1: email
                                },

                                function(data, status){
                                    document.getElementById('about-email').innerHTML =data;
                                })
                            }
                            </script>
                            <!-- <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div> -->
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>

                    </div>
                    <div class="signup-image">
                        <figure><img src="img/signup-image.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">이미 회원인 경우</a>
                    </div>
                </div>
            </div>
        </section>
<script src="https://apis.google.com/js/platform.js" async defer></script>
    <!-- JS -->
     <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
