<?php
    require_once("./review/dbconfig.php");

    session_start();

    if (isset($_SESSION['userid'])) {
        $id = $_SESSION['userid'];
        $name = $_SESSION['username'];
        
    }else {
        $msg = '회원만 이용가능합니다.';
        ?>
        <script>
            alert("<?php echo $msg?>");
            history.back();
        </script>
        <?php
            exit;
    }


    //유저 아이디에 있는 찜목록 가져오기
    $sql = "select li.snum, li.id, st.place, st.title, st.price, st.image, st.level from list as li join study as st on st.num = li.snum where li.id = '$id';";
    $result = $db->query($sql);

    //디비안에 해당 유저가 구매한 스터디 개수 알아보기
    $csql = "select count(*) as cnt from paied where id ='$id'";
    $cresult = $db->query($csql);
    $row = $cresult->fetch_assoc();
    $allpaied = $row['cnt']; //전체 게시글의 수

    if(empty($allpaied)) {
		$emptyData = '<tr><td class="textCenter" col="5">스터디를 구매하지 않았습니다.</td></tr>';
	}
    //유저가 결제한 스터기 가져오기
    $psql = "select * from paied where id = '$id' order by pnum desc";
    $presult = $db->query($psql);

    //내가 개시한 스터디에 대한 정보 가져오기
    $mesql = "select * from study where id= '$id' order by num asc";
    $meresult = $db->query($mesql);
    // $res = mysqli_query($mesql) or die(mysql_error();

    //내가 개설한 스터디의 개수
    $numsql = "select count(*) as my from study where id ='$id'";
    $numresult = $db->query($numsql);
    $numrow = $numresult->fetch_assoc();
    $numtotal = $numrow['my']; //내가 개설한 스터디의 수
    if(empty($numtotal)) {
		$vacantstudy = '<tr><td class="textCenter" col="5">스터디를 개설하지 않았습니다.</td></tr>';
	}


    ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>마이 스터디</title>

        <!-- Font Awesome -->
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <!Bootstrap core CSS -->
        <link href="./css/sellbootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="./css/sellmdb.min.css" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="./boot.css">

        <!-- Your custom styles (optional) -->
        <!-- <link href="./css/sellstyle.min.css" rel="stylesheet"> -->
        <style type="text/css">
          html,
          body,
          header,
          .carousel {
            height: 60vh;
          }
          #small{height: 320px; width: 255px;}
          #pick{height: 50px; width:50px}

          @media (max-width: 740px) {

            html,
            body,
            header,
            .carousel {
              height: 100vh;
            }
          }

          @media (min-width: 800px) and (max-width: 850px) {

            html,
            body,
            header,
            .carousel {
              height: 100vh;
            }
          }

        </style>
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

              <!-- Right -->
              <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                  <a href="./profile.php" class="nav-link waves-effect">

                    <span class="clearfix d-none d-sm-inline-block">내 프로필</span></a>
                </li>

                <li class="nav-item">
            <a href="./group/liststudy.php" class="nav-link waves-effect">
            <span class="clearfix d-none d-sm-inline-block">다른 스터디 보기</span>
            </a>
            </li>

              </ul>
            </div>
          </div>
        </nav>
        <!-- Navbar -->
        <br><br><br>
        <section id="tabs" class="project-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-pick" role="tab" aria-controls="nav-home" aria-selected="true">찜한 스터디</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-paied" role="tab" aria-controls="nav-profile" aria-selected="false">구매한 스터디 </a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-students" role="tab" aria-controls="nav-contact" aria-selected="false">내 학생들</a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-pick" role="tabpanel" aria-labelledby="nav-home-tab">

                            <!-- 찜 목록 시작 시작 -->
                            <main>
                            <div class="container">


                              <!--Navbar-->
                              <nav class="navbar navbar-expand-lg navbar-dark mdb-color lighten-3 mt-3 mb-5">

                              </nav>
                              <!--/.Navbar-->

                              <!--Section: Products v.3-->
                              <section class="text-center mb-4">
                                  <!--Grid row-->
                                  <div class="row wow fadeIn">


                              <?php

                              while($row = $result->fetch_assoc()){

                                  ?>

                                      <!--Grid column-->
                                  <div class="col-lg-3 col-md-6 mb-4">

                                    <!--Card-->
                                    <div class="card">

                                      <!--Card image-->
                                      <div  class="view overlay">
                                        <a href="./group/studydesc.php?snum=<?php echo $row['snum']?>"><img id="small" src="./group/leaderimage/<?php echo $row['image']?>" class="card-img-top"
                                          alt="asd">

                                          <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>
                                      <!--Card image-->

                                      <!--Card content-->
                                      <div class="card-body text-center">
                                        <!--Category & Title-->
                                        <a href="./group/studydesc.php?snum=<?php echo $row['snum']?>" class="grey-text">
                                          <h5><?php echo $row['level']?> <?php echo $row['place']?></h5>
                                        </a>
                                        <h5>
                                          <strong>
                                            <a href="./group/studydesc.php?snum=<?php echo $row['snum']?>" class="dark-grey-text"><?php echo $row['title']?>
                                            </a>
                                          </strong>
                                      </h5>

                                        <h4 class="font-weight-bold blue-text">
                                          <a id="forsnum" href="./group/studydesc.php?snum=<?php echo $row['snum']?>" class="dark-grey-text">
                                              <strong><?php echo $row['price']?></strong></a>

                                        </h4>
                                        <div  class="view overlay">
                                            <img id="pick" src="./img/pick.png" class="card-img-top" alt="<?php echo $row['snum']?>" onclick="deletepick(<?php echo $row['snum']?>)">

                                      </div>
                                      </div>
                                      <!--Card content-->
                                    </div>
                                    <!--Card-->

                                  </div>
                                  <!--Grid column-->

                                  <?php
                              }
                                ?>
                                <script>
                                function deletepick(snum) { //찜 목록에서 삭제
                                    var image = document.getElementById('pick');

                                    var imid = '<?= $id?>';
                                    var imsnum = image.alt;
                                    var imgatrri = snum;

                                    console.log(imid);
                                    console.log(imsnum);
                                    console.log(imgatrri);

                                    $.post('./savepick.php',{
                                        img : imgatrri, id : imid, snum : imgatrri
                                    },

                                    function(data, status){
                                      window.location.reload();
                                    })
                                    }
                                </script>
                              </div>

                              </section>
                              <!--Section: Products v.3-->

                            </div>
                            </main>
                            <!--찜 목록 끝-->

                            <!-- 구매 목록 -->
                                    </div>
                                    <div class="tab-pane fade" id="nav-paied" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <table class="table" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>스터디 이름</th>
                                                    <th>판매자 이름</th>
                                                    <th>구매 시간</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($emptyData)) {
                                                    echo $emptyData;
                                                } else {
                                                while($prow = $presult->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><a href="./group/studydesc.php?snum=<?php echo $prow['snum']?>"><?php echo $prow['title']?></a></td>
                                                    <td><?php echo $prow['leader']?></td>
                                                    <td><?php echo $prow['paiedtime']?></td>
                                                </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- 구매 목록 끝  -->

                                    <!-- 내 학생들 목록 시작 -->
                                    <div class="tab-pane fade" id="nav-students" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <table class="table" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>스터디 이름</th>
                                                    <th>레벨</th>
                                                    <th>총 신청한 인원 </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($vacantstudy)) {
                                                    echo $vacantstudy;
                                                } else {
                                                while($merow = $meresult->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $merow['title']?></td>
                                                    <td><?php echo $merow['level']?></td>
                                                    <td><a href = "./students.php?snum=<?php echo $merow['num']?>"><?php echo $merow['paypeople']?> 명</a></td>
                                                </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                    </div>
                                        <!-- 내 학생들 목록 끝 -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>



    </body>
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
     // new WOW().init();

    </script>
</html>
