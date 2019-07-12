<?php
require_once("./review/dbconfig.php");

session_start();
//상품 번호
$snum = $_GET['snum'];

//상품 번호에서 가져올 제목,레벨,아이디 유저 이름
$stsql = "select st.id, st.title, st.level, us.name from study as st left join users as us on st.id =us.id where num = '$snum'";
$stresult = $db->query($stsql);
$strow = mysqli_fetch_array($stresult);

if (isset($_SESSION['userid']) && $strow['id'] == $_SESSION['userid']) {
 $id = $_SESSION['userid'];
 $name = $_SESSION['username'];
}else {
    $msg = '해당 스터디 작성자만 이용가능합니다.';
    ?>
    <script>
        alert("<?php echo $msg?>");
        history.back();
    </script>
    <?php
        exit;
}

    //내 강의 신청자 총 인원
    $numsql = "select count(*) as my from paied where snum ='$snum'";
    $numresult = $db->query($numsql);
    $numrow = $numresult->fetch_assoc();
    $numtotal = $numrow['my']; //내가 개설한 스터디의 수
    if(empty($numtotal)) {
		$zerostudent = '<p>등록한 학생이 없습니다.</p>';
	}

//총 결제 목록에서 사용자가 올린 게시물에 등록한 사용자의 개인정보를 볼 수 있게 한 곳.
//사용자 이름, 번호, 신청 이유 가져오자
    $sql = "select * from paied where snum =$snum order by pnum desc";
    $result = $db->query($sql);



?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->
        <meta charset="utf-8">
        <title></title>
        <style>
            #small{height : 80px ; weight :80px};
        </style>
        <link rel="stylesheet" href="./students.css">
    </head>
    <body>

        <div class="section">
            <div class="container">
            	<div class="row">
                    <div class="col-md-12">
            	    </div>
            	</div>
            	<div class="row">
            		<div class="col-md-4 ">
            		    <div class="promote">
                    	    <h1 class="text-center h3">제목 :<?= $strow['title'] ?></h1><br>
                            <h3 class="text-center h3">리더 :<?= $strow['name'] ?></h3>
                            <h4 class="text-center h4">레벨 :<?= $strow['level'] ?></h4>
                        </div>
        		    </div>
                    <!--학생 첫 번째  -->
                    <?php

                    if(isset($zerostudent)) {
                        echo $zerostudent; //등록한 학생이 없는 경우

                    }else{ //등록한 학생이 있는 경우
                        while($row = $result->fetch_assoc()){

                    ?>
            		<div class="col-md-4 first">
            		    <div class="card profile-card-2">

                            <div class="card-body pt-5">
                                <img id="small" src="<?php if ($row['image'] == "http://ssl.gstatic.com/accounts/ui/avatar_2x.png") {
                                echo "http://ssl.gstatic.com/accounts/ui/avatar_2x.png";
                            }else{
                                echo './profileimage/'.$row['image']; 
                              }?>" alt="profile-image" class="profile"/>
                                <h5 class="card-title">이름 : <?php echo $row['name']?></h5>
                                <p class="card-text">전화번호 : <?php echo $row['phone']?> </p>
                                <p class="card-text">신청 목적 : <?php echo $row['reason']?></p>
                                <div class="icon-block"></div>
                            </div>
                        </div>
            		</div>

                    <?php
                    }
                        }
                    ?>
                    <!--학생 2번째  -->
            		<!-- <div class="col-md-4">
            		    <div class="card profile-card-2">
                            <div class="card-img-block">
                                <img class="img-fluid" src="https://images.pexels.com/photos/877695/pexels-photo-877695.jpeg?auto=compress&cs=tinysrgb&h=350" alt="Card image cap" />
                            </div>
                            <div class="card-body pt-5">
                                <img src="https://randomuser.me/api/portraits/women/81.jpg" alt="profile-image" class="profile"/>
                                <h5 class="card-title">Shurvir Mori </h5>
                                <p class="card-text">Lorem Ipsum is simply dummy text Lorem Ipsum has been the industry's standard dummy text</p>
                                <div class="icon-block"></div>
                            </div>
                        </div>
            		</div>
            		<div class="col-md-4">
            		    <div class="card profile-card-2">
                            <div class="card-img-block">
                                <img class="img-fluid" src="https://images.pexels.com/photos/877695/pexels-photo-877695.jpeg?auto=compress&cs=tinysrgb&h=350" alt="Card image cap" />
                            </div>
                            <div class="card-body pt-5">
                                <img src="https://randomuser.me/api/portraits/women/81.jpg" alt="profile-image" class="profile"/>
                                <h5 class="card-title">Shurvir Mori</h5>
                                <p class="card-text">Lorem Ipsum is simply dummy text Lorem Ipsum has been the industry's standard dummy text</p>
                                <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div>
                            </div>
                        </div>
            		</div>
            		<div class="col-md-4">
            		    <div class="card profile-card-2">
                            <div class="card-img-block">
                                <img class="img-fluid" src="https://images.pexels.com/photos/877695/pexels-photo-877695.jpeg?auto=compress&cs=tinysrgb&h=350" alt="Card image cap" />
                            </div>
                            <div class="card-body pt-5">
                                <img src="https://randomuser.me/api/portraits/women/81.jpg" alt="profile-image" class="profile"/>
                                <h5 class="card-title">Shurvir Mori</h5>
                                <p class="card-text">Lorem Ipsum is simply dummy text Lorem Ipsum has been the industry's standard dummy text</p>
                                <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div>
                            </div>
                        </div>
            		</div>
            		<div class="col-md-4">
            		    <div class="card profile-card-2">
                            <div class="card-img-block">
                                <img class="img-fluid" src="https://images.pexels.com/photos/877695/pexels-photo-877695.jpeg?auto=compress&cs=tinysrgb&h=350" alt="Card image cap" />
                            </div>
                            <div class="card-body pt-5">
                                <img src="https://randomuser.me/api/portraits/women/81.jpg" alt="profile-image" class="profile"/>
                                <h5 class="card-title">Shurvir Mori</h5>
                                <p class="card-text">Lorem Ipsum is simply dummy text Lorem Ipsum has been the industry's standard dummy text</p>
                                <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div>
                            </div>
                        </div>
            		</div>
            		<div class="col-md-4">
            		    <div class="card profile-card-2">
                            <div class="card-img-block">
                                <img class="img-fluid" src="https://images.pexels.com/photos/877695/pexels-photo-877695.jpeg?auto=compress&cs=tinysrgb&h=350" alt="Card image cap" />
                            </div>
                            <div class="card-body pt-5">
                                <img src="https://randomuser.me/api/portraits/women/81.jpg" alt="profile-image" class="profile"/>
                                <h5 class="card-title">Shurvir Mori</h5>
                                <p class="card-text">Lorem Ipsum is simply dummy text Lorem Ipsum has been the industry's standard dummy text</p>
                                <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div>
                            </div>
                        </div>
            		</div> -->

            	</div>
            </div>
        </div>

    </body>
</html>
