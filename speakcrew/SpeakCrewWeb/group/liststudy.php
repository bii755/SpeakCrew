<?php
    require_once("../review/dbconfig.php");

    /* 페이징 시작 */
	//페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}




    /* 검색 시작 */

	if(isset($_GET['searchColumn'])) {
		$searchColumn = $_GET['searchColumn'];
		$subString .= '&amp;searchColumn=' . $searchColumn;
	}
	if(isset($_GET['searchText'])) {
		$searchText = $_GET['searchText'];
		$subString .= '&amp;searchText=' . $searchText;
	}

	if(isset($searchColumn) && isset($searchText)) {
		$searchSql = ' where ' . $searchColumn . ' like "%' . $searchText . '%"';
	} else {
		$searchSql = '';
	}

    //디비에 저장된 총 몇개의 데티터가 있니?
       $sql = 'select count(*) as cnt from study' . $searchSql;
       $result = $db->query($sql);
       $row = $result->fetch_assoc();

       $allPost = $row['cnt']; //전체 게시글의 수

       if(empty($allPost)) {
   		$emptyData = '<tr><td class="textCenter" col="5">글이 존재하지 않습니다.</td></tr>';
   	} else {

        $onePage = 8; // 한 페이지에 보여줄 게시글의 수.
		$allPage = ceil($allPost / $onePage); //전체 페이지의 수

		if($page < 1 && $page > $allPage) { //페이지가 없는 경우
?>
			<script>
				alert("존재하지 않는 페이지입니다.");
				history.back();
			</script>
<?php
			exit;
		}

        $oneSection = 10; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
		$currentSection = ceil($page / $oneSection); //현재 섹션
		$allSection = ceil($allPage / $oneSection); //전체 섹션의 수

		$firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

		if($currentSection == $allSection) {
			$lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
		} else {
			$lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
		}

		$prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
		$nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

		$paging = '<ul class="pagination pg-blue">'; // 페이징을 저장할 변수

		//첫 페이지가 아니라면 처음 버튼을 생성
		if($page != 1) {
			$paging .= '<li class="page-item"><a class="page-link" href="./liststudy.php?page=1' . $subString . '">처음</a></li>';
		}
		//첫 섹션이 아니라면 이전 버튼을 생성
		if($currentSection != 1) {
			$paging .= '<li class="page-item"><a class="page-link" href="./liststudy.php?page=' . $prevPage . $subString . '">이전</a></li>';
		}

		for($i = $firstPage; $i <= $lastPage; $i++) {
			if($i == $page) {
				$paging .= '<li class="page-item"><a class="page-link">' . $i . '</li>';
			} else {
				$paging .= '<li class="page-item"><a class="page-link" href="./liststudy.php?page=' . $i . $subString . '">' . $i . '</a></li>';
			}
		}

        //마지막 섹션이 아니라면 다음 버튼을 생성
		if($currentSection != $allSection) {
			$paging .= '<li class="page-item"><a class="page-link" href="./liststudy.php?page=' . $nextPage . $subString . '">다음</a></li>';
		}

		//마지막 페이지가 아니라면 끝 버튼을 생성
		if($page != $allPage) {
			$paging .= '<li class="page-item"><a class="page-link" href="./liststudy.php?page=' . $allPage . $subString . '">끝</a></li>';
		}
		$paging .= '</ul>';

		/* 페이징 끝 */


		$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
		$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문

		$sql = 'select * from study' . $searchSql . ' order by num desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
		$result = $db->query($sql);
    }
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
  <style type="text/css">
    html,
    body,
    header,
    .carousel {
      height: 60vh;
    }
    #small{height: 320px; width: 255px;}

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
      <a class="navbar-brand waves-effect" href="../index.php" >
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
              <a href="../bootpro.php" class="nav-link waves-effect">

                <span class="clearfix d-none d-sm-inline-block">최근에 본 스터디</span></a>
            </li>
          <li class="nav-item">
            <a href="../picklist.php" class="nav-link waves-effect">

              <span class="clearfix d-none d-sm-inline-block">마이 스터디</span></a>
          </li>

          <li class="nav-item">
              <a href="./write.php" class="nav-link waves-effect">
      <span class="clearfix d-none d-sm-inline-block"> 스터디 개설하기 </span>
        </a>
      </li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar -->

  <!--Carousel Wrapper-->
  <div id="carousel-example-1z" class="carousel slide carousel-fade pt-4" data-ride="carousel">

    <!--Indicators-->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-1z" data-slide-to="1"></li>
      <li data-target="#carousel-example-1z" data-slide-to="2"></li>
    </ol>
    <!--/.Indicators-->

    <!--Slides-->
    <div class="carousel-inner" role="listbox">
      <!--First slide-->
      <div class="carousel-item active">
        <div class="view" style="background-image: url('http://localhost/speakcrew/img/2.jpg'); background-repeat: no-repeat; background-size: cover;">

          <!-- Mask & flexbox options-->
          <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

            <!-- Content -->
            <div class="text-center white-text mx-5 wow fadeIn">
              <h1 class="mb-3">
                <strong>Learn and share!</strong>
              </h1>

              <p class="mb-3 d-none d-md-block">
                <strong>해외로 나가고 싶다고? 몸부터 움직여봐</strong>
              </p>
            </div>
            <!-- Content -->

          </div>
          <!-- Mask & flexbox options-->

        </div>
      </div>
      <!--/First slide-->

      <!--Second slide-->
      <div class="carousel-item">
        <div class="view" style="background-image: url('https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/8-col/img%283%29.jpg'); background-repeat: no-repeat; background-size: cover;">

          <!-- Mask & flexbox options-->
          <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

            <!-- Content -->
            <div class="text-center white-text mx-5 wow fadeIn">
              <h1 class="mb-4">
                <strong>Learn and share!</strong>
              </h1>

              <p class="mb-4 d-none d-md-block">
                <strong>해외로 나가고 싶다고? 몸부터 움직여봐</strong>
              </p>
            </div>
            <!-- Content -->

          </div>
          <!-- Mask & flexbox options-->

        </div>
      </div>
      <!--/Second slide-->

      <!--Third slide-->
      <div class="carousel-item">
        <div class="view" style="background-image: url('https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/8-col/img%285%29.jpg'); background-repeat: no-repeat; background-size: cover;">

          <!-- Mask & flexbox options-->
          <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

            <!-- Content -->
            <div class="text-center white-text mx-5 wow fadeIn">
              <h1 class="mb-4">
                <strong>Learn and share!</strong>
              </h1>

              <p class="mb-4 d-none d-md-block">
                <strong>해외로 나가고 싶다고? 몸부터 움직여봐</strong>
              </p>
            </div>
            <!-- Content -->

          </div>
          <!-- Mask & flexbox options-->

        </div>
      </div>
      <!--/Third slide-->

    </div>
    <!--/.Slides-->

    <!--Controls-->
    <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    <!--/.Controls-->

  </div>
  <!--/.Carousel Wrapper-->

  <!--Main layout-->
  <main>
    <div class="container">

      <!--Navbar-->
      <nav class="navbar navbar-expand-lg navbar-dark mdb-color lighten-3 mt-3 mb-5">

        <!-- Navbar brand -->
        <span class="navbar-brand">Categories:</span>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
          aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">



        <div class="searchBox">
          <form action="./liststudy.php" method="get"  class="form-inline">
            <div class="md-form my-0">
                <select name="searchColumn">
                    <option <?php echo $searchColumn=='title'?'selected="selected"':null?> value="title">제목</option>
                    <option <?php echo $searchColumn=='level'?'selected="selected"':null?> value="level">난이도</option>
                    <option <?php echo $searchColumn=='place'?'selected="selected"':null?> value="place">장소</option>
                </select>
              <input type="text" name="searchText" class="form-control mr-sm-2"  value="<?php echo isset($searchText)?$searchText:null?>" type="text" placeholder="Search" aria-label="Search">
              <button type="submit">검색</button>
            </div>
          </form>
          </div>
        </div>
        <!-- Collapsible content -->

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
                <a href="./studydesc.php?snum=<?php echo $row['num']?>"><img id="small" src="./leaderimage/<?php echo $row['image']?>" class="card-img-top"
                  alt="">

                  <div class="mask rgba-white-slight"></div>
                </a>
              </div>
              <!--Card image-->

              <!--Card content-->
              <div class="card-body text-center">
                <!--Category & Title-->
                <a href="./studydesc.php?snum=<?php echo $row['num']?>" class="grey-text">
                  <h5><?php echo $row['level']?> <?php echo $row['place']?></h5>
                </a>
                <h5>
                  <strong>
                    <a href="./studydesc.php?snum=<?php echo $row['num']?>" class="dark-grey-text"><?php echo $row['title']?>
                    </a>
                  </strong>
                </h5>

                <h4 class="font-weight-bold blue-text">
                  <a href="./studydesc.php?snum=<?php echo $row['num']?>" class="dark-grey-text">
                      <strong><?php echo $row['price']?></strong></a>
                </h4>

              </div>
              <!--Card content-->

            </div>
            <!--Card-->

          </div>
          <!--Grid column-->

          <?php
      }
      // $sql = 'select * from study order by num desc limit 5,8'; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
      // $result = $db->query($sql);

          ?>
      </div>
      <!--Grid row -->
          <div class="row wow fadeIn">
                    <?php
                while($row = $result->fetch_assoc()){

                ?>
                  <!--Grid row-->
                    <div class="col-lg-3 col-md-6 mb-4">

                      <!--Card-->
                      <div class="card">

                        <!--Card image-->
                        <div  class="view overlay">
                          <a href="./studydesc.php?snum=<?php echo $row['num']?>"><img id="small" src="./leaderimage/<?php echo $row['image']?>" class="card-img-top"
                            alt="">

                            <div class="mask rgba-white-slight"></div>
                          </a>
                        </div>
                        <!--Card image-->

                        <!--Card content-->
                        <div class="card-body text-center">
                          <!--Category & Title-->
                          <a href="./studydesc.php?snum=<?php echo $row['num']?>" class="grey-text">
                            <h5><?php echo $row['level']?></h5>
                          </a>
                          <h5>
                            <strong>
                              <a href="./studydesc.php?snum=<?php echo $row['num']?>" class="dark-grey-text"><?php echo $row['title']?>
                                <span class="badge badge-pill danger-color">마감 임박</span>
                              </a>
                            </strong>
                          </h5>
                          <a href="./studydesc.php?snum=<?php echo $row['num']?>" class="dark-grey-text">
                          <h4 class="font-weight-bold blue-text">
                            <strong><?php echo $row['price']?></strong></a>
                          </h4>

                        </div>
                        <!--Card content-->

                      </div>
                      <!--Card-->

                    </div>
                    <!--Grid column-->

                <?php
            }
?>
</div>
<!--Grid row -->
      </section>
      <!--Section: Products v.3-->

      <!--Pagination-->
      <nav class="d-flex justify-content-center wow fadeIn">

              <nav aria-label="Page navigation example">
  				<?php echo $paging ?>
  			</nav>

</nav>

    </div>
  </main>
  <!--Main layout-->

  <!--Footer-->
  <footer class="page-footer text-center font-small mt-4 wow fadeIn">


    <!--Copyright-->
    <div class="footer-copyright py-3">
      © 2018 Copyright:
      <a href="https://mdbootstrap.com/education/bootstrap/" target="_blank"> MDBootstrap.com </a>
    </div>
    <!--/.Copyright-->

  </footer>
  <!--/.Footer-->

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
