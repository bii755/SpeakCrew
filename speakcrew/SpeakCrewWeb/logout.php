<?php
session_start();
session_destroy();//회원 나갈거야


setcookie("remember","",time()-3600);
?>

<?php
$con = mysqli_connect('localhost','root','1234');
//마이스퀠 서버 연결확인
mysqli_select_db($con, 'speakcrew');
$sql = "delete from permission";
$result= mysqli_query($con,$sql);
//header('location:index.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
        <script>

        function checkLoginStatus(){
           if (gauth.isSignedIn.listen()) {
               console.log('logined');
           }else{
               console.log('logouted');
           }
        }

        function init(){
          console.log('init');
          gapi.load('auth2', function() {
            console.log('auth2');
           window.gauth = gapi.auth2.init({
                client_id: '372361181870-hhfheo9aovja4hmucjoql5ad53ua1sku.apps.googleusercontent.com'
            })
            gauth.then(function(){
                gauth.signOut().then(function(){
                    console.log('gauth.signOut()');
                gauth.disconnect();
                window.location.href='./index.php';
                        });
               console.log('googleauth success');
               checkLoginStatus();

            }, function(){
               console.log('googleauth fail');
            });
          });
        }

        </script>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

    </body>
</html>
