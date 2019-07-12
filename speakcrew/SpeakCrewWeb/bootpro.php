<?php
session_start();
$con = mysqli_connect('localhost','root','1234');
//마이스퀠 서버 연결확인

mysqli_select_db($con, 'speakcrew');
if ($_SESSION['userid']) {
    $id= $_SESSION['userid'];
}

$sub_today = explode(",", $_COOKIE['recent'.$id]);
$real=array_reverse($sub_today);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>

        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link href="./css/sellmdb.min.css" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

        <!------ Include the above in your HEAD tag ---------->
        <meta charset="utf-8">
        <link rel="stylesheet" href="./bootpro.css">
        <title>최근에 본 스터디</title>
    </head>

<body>

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
      <div class="container">

        <!-- Brand -->
        <a class="navbar-brand waves-effect" href="./index.php" >
          <strong class="blue-text">SPEAKCREW</strong>
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            </li>
          </ul>


        </div>
      </div>
    </nav>


        <div class="container page-top">

            <div class="container">
                <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="9000">
                    <div class="carousel-inner row w-100 mx-auto" role="listbox">

                        <?php


                            echo $real[0];
                        if ($real[0] !="" || isset($real)) { //로그인을 한 사용자만이 저장된 이미지를 가져올 수 있다.
                            for ($i=0; $i < count($real); $i++) {
                                $snum = $real[$i];
                                $sql= "select num, title, image from study where num ='$snum'";
                                $result = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($result); //담긴 배열 값


                    ?>
                        <div class="carousel-item col-md-3  active">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="myback-img ">
                                        <img href="./group/studydesc.php" src="./group/leaderimage/<?=$row['image']?>" class="">
                                    </div>
                                    <div class="myoverlay"></div>
                                    <div class="profile-img">
                                        <div class="borders avatar-profile">
                                            <img href="./group/studydesc.php?snum =".<?=$row['num']?> src="./group/leaderimage/<?=$row['image']?>">
                                        </div>
                                    </div>
                                    <div class="profile-title">
                                        <a href="./group/studydesc.php?snum=<?= $row['num']?>">
                                            <h3> <?= $row['title'] ?></h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                                                }
                                            }else{
                                            echo "최근에 본 스터디가 없습니다.";
                                            }

                                     ?>





                    </div>

                </div>
            </div>
            <script type="text/javascript" src="./bootpro.js">

            </script>
        </body>
</html>
