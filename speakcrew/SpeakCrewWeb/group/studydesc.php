<?php
	require_once("../review/dbconfig.php");
	$snum = $_GET['snum'];
    session_start();
    if (isset($_SESSION['userid'])) {
      $id = $_SESSION['userid'];
      $name = $_SESSION['username'];
    }
    //상품에 대한 정보 가져오기
	$sql = 'select id, title, place, address ,detail, level, plan, leader, image, price, paypeople from study where num = '.$snum;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
    $leaderid = $row['id'];
    //사용자가 찜했는지 확인
    $sql = "select * from list where snum = '$snum' and id = '$id'";
    $result = $db->query($sql);
    $pickrow =  $result->fetch_assoc();

    //사용자가 구매했는지 확인
    $psql = "select * from paied where snum = '$snum' and id = '$id'";
    $presult = $db->query($psql);
    $num = mysqli_num_rows($presult);



    // 최근 본상품 쿠키를 이용
    if ( $_COOKIE['recent'.$id] == "" ) {
        //가장 처음에 본 상품을 등록
    setcookie('recent'.$id, $snum, time() + 60*60*24, "/");
    }
    //처음 이후에 본 상품
    $item_id = $snum; // 상품 아이디
    $index = 0;
    $today = $_COOKIE['recent'.$id];
    $sub_today = explode(",", $_COOKIE['recent'.$id]); //문자열을 , 기준으로 배열로 만듬
    $arr_today = array_reverse($sub_today); //배열을 역순으로 해서 가장 최근에 등록된게 0번 인덱스로

    while ( $index < count($arr_today)) { //총 5개만 가저오겠다.  하지만 중복으로 본 것은 안 가져오겠다.!

    if ( $item_id == $arr_today[$index] ) {
    $save = 'no';
    }

    $index++;
    }
    //중복검사 이후에 5개만 추리겠다.
    if ( $_COOKIE['recent'.$id] != "" && $save != 'no' ) {
    setcookie('recent'.$id, $today.",".$item_id, time() + 60*60*24, "/");
    //setcookie(goods, $_GET[item_id], time() + 86400, "/");
    }

    //경위도 가져오기
    $sql = "select * from xy where num ='$snum'";
    $xyresult = $db->query($sql);
    $xyrow =  $xyresult->fetch_assoc();
    ?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>SpeakCrew</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="../css/sellbootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="../css/sellmdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="../css/sellstyle.min.css" rel="stylesheet">
  <style>
  #small { height: 400px; }
  #back { color: #2196F3; background-color: transparent;}
  #font {font-size: 15px;}
</style>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container">

      <!-- Brand -->
      <a class="navbar-brand waves-effect" href="../index.php">
        <strong class="blue-text">SPEAKCREW</strong>
      </a>

      <!-- Collapse -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Left -->

        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
          </li>
        </ul>

        <!-- Right -->
        <ul class="navbar-nav nav-flex-icons">
            <?php
            if ($row['id']==$id) {

            ?>
            <li class="nav-item active">
                <form action="./write.php" method="post">
                <input type="hidden" name="snum" value="<?php echo $snum?>">
                <button id="back" type="submit" class="nav-link waves-effect">
                <span id="back" class="clearfix d-none d-sm-inline-block">수정하기</span></button>
                </form>
                </li>
            <li class="nav-item active">
                <form action="./delete.php" method="post">
                <input type="hidden" name="snum" value="<?php echo $snum?>">
                <button id="back" type="submit" class="nav-link waves-effect">
                <span class="clearfix d-none d-sm-inline-block">삭제하기</span></button>
                </form>
                </li>
        <?php    } ?>

            <li class="nav-item active">
                <a id="back" href="./liststudy.php" class="nav-link waves-effect">
                  <span class="clearfix d-none d-sm-inline-block">다른 스터디</span></a>
            </li>
            <li class="nav-item active">
                <a  id="back" href="../picklist.php" class="nav-link waves-effect">
                  <span class="clearfix d-none d-sm-inline-block">마이 스터디</span></a>

            </li>
        </ul>

      </div>

    </div>
  </nav>
  <!-- Navbar -->

  <!--Main layout-->
  <main class="mt-5 pt-4">
    <div class="container dark-grey-text mt-5">

      <!--Grid row-->
      <div class="row wow fadeIn">

        <!--Grid column-->
        <div class="col-md-6 mb-4">

          <img id="small" src="./leaderimage/<?php echo $row['image']?>" class="img-fluid" alt="리더이미지">
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-6 mb-4">

          <!--Content-->
          <div class="p-4">
                <p>난이도 : <?php echo $row['level']?></p>
                <p>계획 :  <?php echo $row['plan']?></p>
            <p class="lead">
              <span>가격 : <?php echo $row['price']?></span>
            </p>

            <p class="lead font-weight-bold">제목 :  <?php echo $row['title']?></p>

            <p class="lead font-weight-bold">리더 소개 : <?php echo $row['leader']?> </p>

            <?php
            if ($leaderid != $id) {

            ?>

            <form  class="d-flex justify-content-left">
              <img id ='pick' onclick="changeimage()" src=<?php echo ($pickrow['id'] == $id && isset($id))?'../img/pick.png':'../img/not.png';?> alt="찜하기">
            </form>

            <script>
            function changeimage() { //이미지 변경

                var image = document.getElementById('pick');

                var imid = '<?= $id?>';
                var imsnum = '<?= $snum?>';
                var imleaderid = '<?= $leaderid?>';
                var imgatrri = image.src;


                if (imid == '') {
                alert("로그인 이후에 이용할 수 있습니다.");
                }else{
                $.post('../savepick.php',{
                    img : imgatrri, id : imid, leaderid : imleaderid, snum : imsnum
                },

                function(data, status){
                    alert(data);
                })


                if (image.src.match("pick")) {
                    image.src = "../img/not.png";
                } else {
                    image.src = "../img/pick.png";
                }
                    }
                }

            </script>
            <br>

            <?php if ($num !=1) {

            ?>

            <form method="post" action="./checkout-page.php" class="d-flex justify-content-left">
                <input type="hidden" name="snum" value="<?php echo $snum?>">
              <button id="font" class="btn btn-primary btn-md my-0 p" type="submit" >
                구매하기
              </button>
            </form>
            <?php
        }
        }
            ?>

          </div>
          <!--Content-->

        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->

      <hr>

      <!--Grid row-->
      <div class="row d-flex justify-content-center wow fadeIn">

        <!--Grid column-->
        <div class="col-md-6 text-center">

          <h4 class="my-4 h3">스터디 모임 장소</h4>

           <a target="_blank" href="http://map.daum.net/link/to/<?=$row['address'].','.$xyrow['y'].','.$xyrow['x']?>"><h3 class="my-4 h4">길찾기</h3></a>

          <p><div id="map" style="width:100%;height:350px;"></div></p>
        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->

      <!--Grid row-->
      <div class="row d-flex justify-content-center wow fadeIn">

        <!--Grid column-->
        <div class="col-md-6 text-center">

          <h4 class="my-4 h4">스터디 기획</h4>

          <p><?php echo $row['detail']?></p>
        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->
    </div>
  </main>
  <!--Main layout-->

  <!--Footer-->
  <footer class="page-footer text-center font-small mt-4 wow fadeIn">
    <hr class="my-4">

    <!--/.Copyright-->
  </footer>
  <!--/.Footer-->

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=0720131a6c1b3eaa9ca2c7928b0d1944&libraries=services"></script>
<script>
var mapContainer = document.getElementById('map'), // 지도를 표시할 div
    mapOption = {
        center: new daum.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
        level: 3 // 지도의 확대 레벨
    };

// 지도를 생성합니다
var map = new daum.maps.Map(mapContainer, mapOption);

// 주소-좌표 변환 객체를 생성합니다
var geocoder = new daum.maps.services.Geocoder();
console.log('<?=$row['address']?>');
console.log(geocoder);

// 주소로 좌표를 검색합니다
geocoder.addressSearch('<?=$row['address']?>', function(result, status) {

    // 정상적으로 검색이 완료됐으면
     if (status === daum.maps.services.Status.OK) {

        var coords = new daum.maps.LatLng(result[0].y, result[0].x);
        console.log(result[0].y);
        console.log(result[0].x);
        $.post('./studydesc.php?snum=<?=$_GET['snum']?>',
         { x : result[0].x , y : result[0].y},
         function(data, status){

         }
         )

        // 결과값으로 받은 위치를 마커로 표시합니다
        var marker = new daum.maps.Marker({
            map: map,
            position: coords
        });

        // 인포윈도우로 장소에 대한 설명을 표시합니다
        var infowindow = new daum.maps.InfoWindow({
            content: '<div style="width:150px;text-align:center;padding:6px 0;">우리 스터디</div>'
        });
        infowindow.open(map, marker);

        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
        map.setCenter(coords);
    }
});
</script>

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="../js/selljquery-3.3.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="../js/sellpopper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="../js/sellbootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="../js/sellmdb.min.js"></script>
  <!-- Initializations -->
  <script type="text/javascript">
    // Animations initialization
    new WOW().init();

  </script>
</body>

</html>
