    <?php
    session_start();
    $con = mysqli_connect('localhost','root','1234');// mysql 서버 연결
    mysqli_select_db($con, 'speakcrew'); // 저장할 디비 결정
    //로그인한 아이디
    if (isset($_SESSION['userid'])) {
     $id = $_SESSION['userid'];
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

    // 사용자가 변경한 신상정보
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password2 =$_POST['password2'];

    //패스워드 일치 여부
     if ($password != $password2) {
         // 수정 페이지로
        header('Location:/speakcrew/profile.php');
        exit;
    }

    //이미지를 등록한 경우
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $filename=$_FILES['file']['name'];
        //이미지 등록이 안된경우 에러
        ini_set("display_errors","1");
        //이미지가 저장될 경로
        $uploaddir = '/usr/local/victolee/apache2.4.37/htdocs/speakcrew/profileimage/';
        //이미지 저장될 경로+이미지 이름
        $uploadfile = $uploaddir.basename($_FILES['file']['name']);
        //echo '<pre>'; //pre가 멀까? 에러 찍어주었다.
        //이미지 원하는 경로로 이동했을 경우
        if (move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)) {

        }else{ //파일 이동이 안됬을 경우 다시 이동
            print "</pre>";
            header('Location:/speakcrew/profile.php');
            }


        $sqlimg = "SELECT * FROM users WHERE id = '$id'";
        $resultimg = mysqli_query($con,$sqlimg);
        $row = mysqli_fetch_array($resultimg);
        $image = $row['image'];
        if ($filename ==null) { //사용자가 이미지를 변경하지 않았을 경우
           $sql = "UPDATE users SET name = '$name', password = '$password',
            email = '$email', phone = '$phone' where id = '$id' ";
       }else{ //이미지를 변경했을 경우 디비에 저장된 이미지를 다시 등록한다.
        $sql = "UPDATE users SET name = '$name', password = '$password',
         email = '$email', phone = '$phone', image='$filename' where id = '$id' ";
         //이미지 변경한 경우 세션을 사용해서 이미지에 저장 왜?
         //사용자가 결재할 때 결재 정보에 사용자의 이미지도 같이 저장하려고
         $_SESSION['image'] = $filename;
         }

         $_SESSION['username'] = $name;
         $result = mysqli_query($con,$sql);
      header('Location:/speakcrew/profile.php');
}else{
        print "</pre>";
}

    // //이미지랑 폰 번호를 안 적은 경우
    // if (!isset($phone) && !isset($_FILES['file'])) { //이미지,폰번호 제외하고 개인정보 수정
    //     $sql = "UPDATE users SET name = '$name', password = '$password',
    //      email = '$email' where id = '$id'";
    // }else if(!isset($phone)) { //폰번호를 안 적은 경우 이미지만 추가 등록
    //     $sql = "UPDATE users SET name = '$name', password = '$password',
    //      email = '$email', image='$filename'  where id = '$id'";
    // }else if (!isset($_FILES['file'])) { //이미지를 안 등록 했을 경우 폰 번호만 추가 등록
    //     $sql = "UPDATE users SET name = '$name', password = '$password',
    //      email = '$email', phone='$phone'  where id = '$id'";
    // }else{ //이미지, 폰 번호 다 기입한 경우
    //
    // }


    ?>
