<?php
 session_start();
 $con = mysqli_connect('localhost','root','1234');
//마이스퀠 서버 연결확인
mysqli_select_db($con, 'speakcrew');

    if (isset($_SESSION['userid'])) { //자동로그인이 아닌 로그인
     //사용자의 아이디와 이름
     $id = $_SESSION['userid'];
     $name = $_SESSION['username'];
     $_SESSION['image'];

    }else if (isset($_COOKIE['remember'])) { //자동로그인 한 이후 웹브라우저 다시 실행한 경우
     //쿠키에 저장된 암호화된 사용자 아이디 가져오기
     $mdid = $_COOKIE['remember'];
     //자동로그인할 때 저장된 암호화된 아이디를 사용해서 디비에서 순수한 아이디를 가져오기
     $sql = "select id from permission where idchanged = '$mdid'";
     $result = mysqli_query($con,$sql);
     $row = mysqli_fetch_array($result);
     $id = $row['id'];
     //순수한 아이디를 사용해서 사용자의 이름 가져오기
     $sql= "select name from users where id = '$id'";
     $result = mysqli_query($con, $sql);
     $row = mysqli_fetch_array($result);
     $name = $row['name'];
     //세션값이 없으므로 세션 아이디와 이름, 이미지에 저장
     $_SESSION['username'] = $name;
     $_SESSION['userid'] =$id;
    }


    if (isset($id)) {
    $mypick ="<li class='nav-item'> <a class='nav-link' href='picklist.php'>마이 스터디</a> </li>";
    }

    //조회수 많은 리뷰 4개 가져오기
    $sql = "select b_no, b_title, name from board_free order by b_hit desc limit 4";
    $reresult = mysqli_query($con,$sql);

    //가장 최신 스터디 3개 가져오기
    $sql = "select * from study order by num desc limit 3";
    $stresult = mysqli_query($con,$sql);

 ?>


<!DOCTYPE html>
<html lang="en">
<head>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href=" ">
<title>Speak Cast</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="css/custom.css" rel="stylesheet">

<!-- Helper Styles -->
<link href="css/loaders.css" rel="stylesheet">
<link href="css/swiper.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="css/nivo-lightbox.css">
<link rel="stylesheet" href="css/nivo_themes/default/default.css">




<style>
#white {color : GhostWhite;}
#small {width :300px ; height:300px;}
</style>

<!-- Font Awesome Style -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
<!-- 팝업  -->
    <SCRIPT LANGUAGE="JavaScript">
    <!--
    function change(form)
    {
    if (form.url.selectedIndex !=0)
    parent.location = form.url.options[form.url.selectedIndex].value
    }
    function setCookie( name, value, expiredays )
    {
    var todayDate = new Date();
    todayDate.setDate( todayDate.getDate() + expiredays );
    document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
    }
    function getCookie( name )
    {
    var nameOfCookie = name + "=";
    var x = 0;
    while ( x <= document.cookie.length )
    {
    var y = (x+nameOfCookie.length);
    if ( document.cookie.substring( x, y ) == nameOfCookie ) {
    if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
    endOfCookie = document.cookie.length;
    return unescape( document.cookie.substring( y, endOfCookie ) );
    }
    x = document.cookie.indexOf( " ", x ) + 1;
    if ( x == 0 )
    break;
    }
    return "";
    }
    if ( getCookie( "Notice") != "done" )
    {
    noticeWindow = window.open('popup2.php','notice','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no, resizable=no,width=400,height=400');
    //winddow.open의 ()의 것은 한줄에 계속 붙여써야 오류가 안남, 줄바뀌면 오류남
    noticeWindow.opener = self;
    }
    //-->
    </script>


<div class="loader loader-bg">
  <div class="loader-inner ball-clip-rotate-pulse">
    <div></div>
    <div></div>
  </div>
</div>

<!-- Top Navigation -->
    <nav class="navbar navbar-toggleable-md mb-4 top-bar navbar-static-top sps sps--abv">
        <div class="container">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse1" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">Speak<span>Crew</span></a>
      <div class="collapse navbar-collapse" id="navbarCollapse1">
        <ul class="navbar-nav ml-auto">
         <li class="nav-item active"> <a class="nav-link" href="#myCarousel">메인<span class="sr-only">(current)</span></a> </li>
        <li class="nav-item"> <a class="nav-link" href="#benefits">후기</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#blog">스터디</a> </li>
         <li class="nav-item"> <a class="nav-link" href="./iochat/public/index.php">채팅</a> </li>
        <!-- <li class="nav-item"> <a class="nav-link" href="#contact">Contact</a> </li> -->
        <?= $mypick?>
        <li class="nav-item"> <a  class="nav-link" href="<?php if (!isset($id)){
            echo "login.php";}else{
            echo"profile.php";}?>"><?php if (!isset($id)) {
            echo "로그인";}else{
            echo $name;}?></a></li>
        <li class="nav-item"> <a class="nav-link" <?php if (!isset($id)) {
            echo "href='register.php'";}else{
            echo "href ='./logout.php'";}?>><?php if (!isset($id)) {
            echo "회원가입";}else{
            echo '로그아웃'; } ?></a></li>
        </ul>
      </div>
            </div>
    </nav>



<!-- Swiper Silder
    ================================================== -->
<!-- Slider main container -->
<div class="swiper-container main-slider" id="myCarousel">
  <div class="swiper-wrapper">

    <div class="swiper-slide slider-bg-position" style="background:url('img/instruction/01.jpg')" data-hash="slide1">
      <h2>Jenny-유쾌한 회화 같이해요!</h2>
    </div>
    <div class="swiper-slide slider-bg-position" style="background:url('img/instruction/02.jpg')" data-hash="slide1">
      <h2>Bruno- 재밌게 배우는 영어</h2>
    </div>
    <div class="swiper-slide slider-bg-position" style="background:url('img/instruction/03.jpg')" data-hash="slide1">
      <h2>Steve- 당신도 할 수 있어요!</h2>
    </div>
    <div class="swiper-slide slider-bg-position" style="background:url('img/instruction/04.jpg')" data-hash="slide1">
      <h2>Ed- 2달안에 끝내요!</h2>
    </div>
    <div class="swiper-slide slider-bg-position" style="background:url('img/instruction/five edit.jpg')" data-hash="slide1">
      <h2>Drake- 노래로 배우는 영어</h2>
    </div>
  </div>
  <!-- Add Pagination -->
  <div class="swiper-pagination"></div>
  <!-- Add Navigation -->
  <div class="swiper-button-prev"><i class="fa fa-chevron-left"></i></div>
  <div class="swiper-button-next"><i class="fa fa-chevron-right"></i></div>
</div>

<!-- Benefits
    ================================================== -->
<section class="service-sec" id="benefits">
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="heading text-md-center text-xs-center">
      <h2><small>후기</small>사람들이 어떻게 했는지 봐요!</h2>
      <h2><a href="./review/review.php">다른 후기 보기</a></h2>
    </div>
        </div>
      <div class="col-md-8">
        <div class="row">

            <?php
            while($reviewrow = mysqli_fetch_assoc($reresult)){
            ?>

            <a href= "./review/view.php?bno=<?= $reviewrow['b_no']?>"><div class="col-md-6 text-sm-center service-block"> <i class="fa fa-plus" aria-hidden="true"></i>
          <h3><?= $reviewrow['name']?></h3>
          <p><?= $reviewrow['b_title']?><p></a>
            </div>
            <?php }?>

        </div>
      </div>
      <div class="col-md-4"> <img src="img/instruction/dddd.jpg" class="img-fluid" /> </div>
    </div>
    <!-- /.row -->
  </div>
</section>

<!-- About
    ================================================== -->

<!-- <section class="about-sec parallax-section" id="about">
  <div class="container">
    <div class="row">
       <div class="col-md-3">
        <h2><small>Who We Are</small>About<br>
          Our Blog</h2>
      </div>
      <div class="col-md-4">
        <p>To enjoy good health, to bring true happiness to one's family, to bring peace to all, one must first discipline and control one's own mind. If a man can control his mind he can find the way to Enlightenment, and all wisdom and virtue will naturally come to him.</p>
        <p>Saving our planet, lifting people out of poverty, advancing economic growth... these are one and the same fight. We must connect the dots between climate change, water scarcity, energy shortages, global health, food security and women's empowerment. Solutions to one problem must be solutions for all.</p>
      </div>
      <div class="col-md-4">
        <p>Our greatest happiness does not depend on the condition of life in which chance has placed us, but is always the result of a good conscience, good health, occupation, and freedom in all just pursuits.</p>
        <p>Being in control of your life and having realistic expectations about your day-to-day challenges are the keys to stress management, which is perhaps the most important ingredient to living a happy, healthy and rewarding life.</p>
        <p><a href="#" class="btn btn-transparent-white btn-capsul">Explore More</a></p>
      </div>
    </div>
  </div>
-->

<!-- BLOG
    ================================================== -->

<section style="background-color:rgba(117, 190, 218, 0.5);"; class="blog-sec" id="blog">

  <div  class="container">
      <div class="row">
         <div class="col-md-12">
    <div class="heading text-md-center text-xs-center">
      <h2><small>SPEAKCREW는 오프라인 영어 스터디 플랫폼 입니다.</small><a href='./group/liststudy.php'>전체보기</a></h2>
    </div>
    </div>
    <?php
    while($streviewrow = mysqli_fetch_assoc($stresult)){
    ?>
      <div class="col-md-4 blog-box">
        <div class="blog-image-block"> <a href="./group/studydesc.php?snum=<?=$streviewrow['num']?>"> <img id="small" src="group/leaderimage/<?=$streviewrow['image']?>" alt="Image" class="img-fluid"> </div>
        <h3 class="blog-title"><small><?=$streviewrow['title']?></small>대상 : <?=$streviewrow['level']?></a></h3>
        <p class="blog-content">가격 : <?=$streviewrow['price']?></p>
      </div>

      <?php
    }?>

    </div>
  </div>
</section>

<!-- VIDEO
    ================================================== -->
<section class="video-sec parallax-section">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="wow fadeInUp" data-wow-delay="0.5s">Watch the video<small>Without health life is not life; it is only a state of langour and suffering - an image of death.</small></h2>
        <a href="#" ><i class="fa fa-play"></i></a> <small><em>Video by: Grafreez Health Tips</em></small> </div>
    </div>
  </div>
</section>
<section class="gallery-sec" id="gallery">
  <div class="container">
      <div class="row">
          <div class="col-md-12">
    <div class="heading text-md-center text-xs-center">
      <h2><small>Stroy Through Images</small>Fitness Image Gallery</h2>
    </div>
    </div>
      <div class="col-md-12">
        <!-- iso section -->
        <div class="iso-section text-md-center text-xs-center" data-wow-delay="0.5">
          <ul class="filter-wrapper clearfix">
            <li><a href="#" data-filter="*" class="selected opc-main-bg">All</a></li>
            <li><a href="#" class="opc-main-bg" data-filter=".london">London</a></li>
            <li><a href="#" class="opc-main-bg" data-filter=".paris">Paris</a></li>
            <li><a href="#" class="opc-main-bg" data-filter=".ny">New York</a></li>
            <li><a href="#" class="opc-main-bg" data-filter=".hn">Hong Kong</a></li>
          </ul>

          <!-- iso box section -->
          <div class="iso-box-section wow fadeInUp" data-wow-delay="0.9s">
            <div class="iso-box-wrapper col4-iso-box">
              <div class="iso-box london paris ny col-md-4 col-sm-6">
                <div class="gallery-thumb"> <a href="img/photo-gallery-01.jpg" data-lightbox-gallery="food-gallery"> <img src="img/photo-gallery-01.jpg" class="fluid-img" alt="Gallery">
                  <div class="gallery-overlay">
                    <div class="gallery-item"> <i class="fa fa-search"></i> </div>
                  </div>
                  </a> </div>
              </div>
              <div class="iso-box london ny hn col-md-4 col-sm-6">
                <div class="gallery-thumb"> <a href="img/photo-gallery-02.jpg" data-lightbox-gallery="food-gallery"> <img src="img/photo-gallery-02.jpg" class="fluid-img" alt="Gallery">
                  <div class="gallery-overlay">
                    <div class="gallery-item"> <i class="fa fa-search"></i> </div>
                  </div>
                  </a> </div>
              </div>
              <div class="iso-box hn col-md-4 col-sm-6">
                <div class="gallery-thumb"> <a href="img/photo-gallery-03.jpg" data-lightbox-gallery="food-gallery"> <img src="img/photo-gallery-03.jpg" class="fluid-img" alt="Gallery">
                  <div class="gallery-overlay">
                    <div class="gallery-item"> <i class="fa fa-search"></i> </div>
                  </div>
                  </a> </div>
              </div>
              <div class="iso-box london col-md-4 col-sm-6">
                <div class="gallery-thumb"> <a href="img/photo-gallery-04.jpg" data-lightbox-gallery="food-gallery"> <img src="img/photo-gallery-04.jpg" class="fluid-img" alt="Gallery">
                  <div class="gallery-overlay">
                    <div class="gallery-item"> <i class="fa fa-search"></i> </div>
                  </div>
                  </a> </div>
              </div>
              <div class="iso-box ny col-md-4 col-sm-6">
                <div class="gallery-thumb"> <a href="img/photo-gallery-05.jpg" data-lightbox-gallery="food-gallery"> <img src="img/photo-gallery-05.jpg" class="fluid-img" alt="Gallery">
                  <div class="gallery-overlay">
                    <div class="gallery-item"> <i class="fa fa-search"></i> </div>
                  </div>
                  </a> </div>
              </div>
              <div class="iso-box paris lunch col-md-4 col-sm-6">
                <div class="gallery-thumb"> <a href="img/photo-gallery-06.jpg" data-lightbox-gallery="food-gallery"> <img src="img/photo-gallery-06.jpg" class="fluid-img" alt="Gallery">
                  <div class="gallery-overlay">
                    <div class="gallery-item"> <i class="fa fa-search"></i> </div>
                  </div>
                  </a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="contact-sec" id="contact">
  <div class="container">
    <h2>Get in Touch <small>Our work is the presentation of our capabilities.</small> </h2>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="exampleName">Name</label>
          <input type="text" class="form-control" id="exampleName" aria-describedby="emailHelp">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="examplePhone">Phone Number</label>
          <input type="text" class="form-control" id="examplePhone" aria-describedby="emailHelp">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> </div>
      </div>
      <div class="col-md-12">
        <label for="exampleTextarea">Enter your Message</label>
        <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
      </div>
      <div class="col-md-12 text-xs-center action-block"> <a href="#" class="btn btn-capsul btn-aqua">Submit</a> </div>
    </div>
  </div>
</section>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-2 col-sm-4">
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Benefits</a></li>
          <li><a href="#">About</a></li>
        </ul>
      </div>
      <div class="col-md-2 col-sm-4">
        <ul>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Image Gallery</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-2 col-sm-4">
        <ul>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Term and Services</a></li>
          <li><a href="#">About Grafreez</a></li>
        </ul>
      </div>
      <div class="col-md-6 col-sm-12">
        <h2>About our Blog</h2>
        <p>To enjoy good health, to bring true happiness to one's family, to bring peace to all, one must first discipline and control one's own mind. If a man can control his mind he can find the way to Enlightenment.</p>
      </div>
    </div>
    <div class="row copy-footer">
      <div class="col-sm-6 col-md-3"> &copy;<script type="text/javascript">document.write(new Date().getFullYear());</script> Grafreez.com </div>
      <div class="col-sm-6 col-md-3 pull-right text-xs-right">Created with <i class="fa fa-heart"></i></div>
    </div>
  </div>
</footer>

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js" ></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scrollPosStyler.js"></script>
<script src="js/swiper.min.js"></script>
<script src="js/isotope.min.js"></script>
<script src="js/nivo-lightbox.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/core.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>


</body>
</html>
