        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->
        <?php

        session_start();
        if (isset($_SESSION['userid'])) {

          $id = $_SESSION['userid'];
          $name = $_SESSION['username'];
        }else {
        $msg = '사용자만이 프로필 설정할 수 있습니다.';
        ?>
        <script>
            alert("<?php echo $msg?>");
            history.back(); //이전 페이지로 이동
        </script>
        <?php
            exit;
        }
        $con = mysqli_connect('localhost','root','1234');
        mysqli_select_db($con, 'speakcrew');

        $sql = "SELECT * FROM users WHERE id = '$id' ";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        //사용자 아이디에 해당하는 정보 가져 옴
        //패스워드랑 이메일은 필수
        $password = $row['password'];
        $email = $row['email'];
        $phone = $row['phone'];
        $image = $row['image'];

        //찜목록 가져올 거야~!!!
        $sql = "select * from list where id = '$id'";
        $result = mysqli_query($con, $sql);
        $listrow = mysqli_fetch_array($result);

        //상품 번호 가져올 거야

         ?>

    <!DOCTYPE html>
    <html>
    <head>
        <style>
        #small { height: 200px; width: 700px;}
        #small2 { height: 100px; }
        #pos{position: fixed;; top: 480px; left:930px;}
        #pos2{position: fixed;; top: 540px; left:720px;}
        input[type="file"]
    {
       color: transparent;
       background-color: #FFFFFF;
       width: 100%;
       height: 36px;
       border-radius: 3px;
    }
        </style>
      <title>Profile</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>

    <body>
    <script src="./profile.js"> </script>
    <hr>
    <div class="container bootstrap snippet">
        <div class="row">

      		<div class="col-sm-10"><h1><a class="navbar-brand" href="./index.php"><span>SpeakCrew</span></a></h1></div>
        	<div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" ></a></div>
        </div>
        <div class="row">

             <form enctype="multipart/form-data" action="profilesave.php" method="post">
          		<div class="col-sm-3"><!--left col-->
                    <div class="text-center">
                        <img id="small" src=<?php if ($image == "http://ssl.gstatic.com/accounts/ui/avatar_2x.png") {
                        echo "http://ssl.gstatic.com/accounts/ui/avatar_2x.png";
                        }else{
                        echo 'profileimage/'.$image;} ?> class="avatar img-circle img-thumbnail" alt="avatar"/>
                        <!-- // if (!isset($image)) {echo ; }else{  echo "profileimage/$_FILES['file']['name']"; }?> -->
                        <h6>프로필 사진 변경하기</h6>
                        <input name="file" type="file" class="text-center center-block file-upload"/>
                    </div><br>

              <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
                	<i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
                </div>
              </div>

            </div><!--/col-3-->
        	<div class="col-sm-9">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#info">내 정보</a></li>

                  </ul>


              <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <hr>
                          <div class="form-group">
                              <div class="col-xs-6">
                                  <label for="first_name"><h4>이름</h4></label>
                                  <input value="<?php echo $name; ?>"  type="text" class="form-control" name="name" id="first_name" placeholder="name" title="enter your first name if any." required>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-xs-6">
                                  <label for="phone"><h4>전화번호</h4></label>
                                  <input value="<?php echo $phone; ?>" type="text" class="form-control" name="phone" id="phone" placeholder="enter phone" title="enter your phone number if any.">
                              </div>
                          </div>


                          <div class="form-group">
                              <div class="col-xs-6">
                                  <label for="email"><h4>이메일</h4></label>
                                  <input value="<?php echo $email; ?>" type="email" class="form-control" name="email" id="email" placeholder="you@email.com" title="enter your email." required>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-xs-6">
                                  <label for="password"><h4>패스워드</h4></label>
                                  <input value="<?php echo $password; ?>" type="password" class="form-control" name="password" id="password" placeholder="password" title="enter your password." required>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-xs-6">
                                <label for="password2"><h4>패스워드 확인</h4></label>
                                  <input value="<?php echo $password; ?>" type="password" class="form-control" name="password2" id="password2" placeholder="passwordcheck" title="enter your password2." required>
                              </div>
                          </div>

                          <div class="form-group">
                               <div class="col-xs-12">
                                    <br>
                                     <input id="pos" type="submit" name="save" value="Save"/>
                                </div>
                          </div>

                  <hr>
                 </div><!--/tab-pane-->
                 <div class="tab-pane" id="pick">
                   <h2>dd</h2>
                   <hr>


                 </div><!--/tab-pane-->

                 <div class="tab-pane" id="paid">
                     <h2>22</h2>
                     <hr>

                          <div class="form-group">
                              <div class="col-xs-6">
                                  <label for="first_name"><h4>First name</h4></label>
                                  <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" title="enter your first name if any.">
                              </div>
                          </div>
                  </div>

                  </div><!--/tab-pane-->
              </div>
             </form>

        </div><!--/row-->
    </div>

    </body>
    </html>
