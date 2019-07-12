
<?php
require_once("../review/dbconfig.php");

if(isset($_POST['snum'])) {
    $snum = $_POST['snum'];
}

if(isset($snum)) {
    } else {
    $msg = '결제를 할 수 없습니다.';
    ?>
    <script>
        alert("<?php echo $msg?>");
        history.back();
    </script>
    <?php
        exit;
    }

    session_start();
    if (isset($_SESSION['userid'])) {
      $id = $_SESSION['userid'];
      $name = $_SESSION['username'];
    }
	$sql = 'select id, title, place, detail, level, plan, leader, image, price, paypeople from study where num = '.$snum;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>결제 </title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="../css/sellbootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="../css/sellmdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="../css/sellstyle.min.css" rel="stylesheet">
</head>

<body class="grey lighten-3">

  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container">

      <!-- Brand -->
      <a class="navbar-brand waves-effect" href="https://mdbootstrap.com/docs/jquery/" target="_blank">
        <strong class="blue-text">SPEAKCREW</strong>
      </a>

      <!-- Collapse -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">



        <!-- Right -->
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a class="nav-link waves-effect">
              <span class="badge red z-depth-1 mr-1"> 1 </span>
              <i class="fas fa-shopping-cart"></i>
              <span class="clearfix d-none d-sm-inline-block"> Cart </span>
            </a>
          </li>

        </ul>

      </div>

    </div>
  </nav>
  <!-- Navbar -->

  <!--Main layout-->
  <main class="mt-5 pt-4">
    <div class="container wow fadeIn">

      <!-- Heading -->
      <h2 class="my-5 h2 text-center">결제</h2>

      <!--Grid row-->
      <div class="row">


        <!--Grid column-->
        <div class="col-md-8 mb-4">

          <!--Card-->
          <div class="card">

            <!--Card content-->
            <form method="post" action="pay.php" class="card-body">

              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-md-6 mb-2">

                  <!--firstName-->
                  <div class="md-form ">
                    <input name ="name" type="text" id="firstName" class="form-control" required>
                    <label for="firstName" class="">이름</label>
                  </div>

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6 mb-2">

                  <!--lastName-->
                  <div class="md-form">
                    <input name="phone" type="text" id="lastName" class="form-control" required>
                    <label for="lastName" class="">핸드폰 번호</label>
                  </div>

                </div>
                <!--Grid column-->

              </div>
              <!--Grid row-->
              <!--Grid row-->
              <div class="row">

                <!--Grid column-->
                <div class="col-md-6 mb-2">
                    <div class="md-form">
                      <input name="reason" type="text" id="lastName" class="form-control" required>
                      <label for="lastName" class="">신청동기</label>
                    </div>

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-4 col-md-12 mb-4">



                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-4 col-md-6 mb-4">


                </div>
                <!--Grid column-->

              </div>
              <!--Grid row-->
              <h2 class="my-2 h2 text-center">제목 :  <?php echo $row['title']?></h2>
              <h3 class="my-2 h2 text-center">장소 : <?php echo $row['place']?></h3>
              <h4 class="my-2 h2 text-center">난이도 : <?php echo $row['level']?></h4>

              <div class="row">

              </div>
              <div class="row">
                <div class="col-md-3 mb-3">

                </div>
                <div class="col-md-3 mb-3">

                </div>
              </div>
              <hr class="mb-4">
             <input type="hidden" name="snum" value="<?php echo $snum?>">
              <button class="btn btn-primary btn-lg btn-block" type="submit">결제하기</button>

            </form>

          </div>
          <!--/.Card-->

        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-4 mb-4">

          <!-- Heading -->
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">결제 금액</span>
            <span class="badge badge-secondary badge-pill">1</span>
          </h4>

          <!-- Cart -->
          <ul class="list-group mb-3 z-depth-1">
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">스터디</h6>

              </div>
              <span class="text-muted"><?php echo $row['price']?></span>
            </li>

          </ul>
          <!-- Cart -->
        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->

    </div>
  </main>
  <!--Main layout-->

  <!--Footer-->
  <footer class="page-footer text-center font-small mt-4 wow fadeIn">

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
