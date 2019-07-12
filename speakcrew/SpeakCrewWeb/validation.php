<?php
//로그인 버튼 클릭시
session_start();
  //다시 로그인 페이지로

$con = mysqli_connect('localhost','root','1234');
//마이스퀠 서버 연결확인

mysqli_select_db($con, 'speakcrew');

if (isset($_POST['gg'])) {
    //구글 계정에서 받아온 사용자 정보
    $id = $_POST['gid'];
    $name = $_POST['gname'];
    $image = $_POST['gimage'];
    $email = $_POST['gemail'];

    $s = " select * from users where id = '$id'";
    //이름과 비번이 해당하는 게 있으면 다나와
    $result = mysqli_query($con,$s);
    //디비에게 가져온 결과가 담김
    $num = mysqli_num_rows($result);
    //그것의 수를 셀게요.
    if ($num ==1) {
        //예전에 같은 구글 계정으로 로그인 한 경우
    }else{
        //구글로그인한 계정이 처음으로 로그인인 경우
        //회원 목록에 저장
    $reg = "insert into users(id, password, name, email, phone, image) values ('$id', '$id', '$name', '$email', '', 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png')";
    mysqli_query($con,$reg);
    }
    //세션에 저장해 사용함
    $_SESSION['username'] = $name;
    $_SESSION['userid'] =$id;//전역변수 즉 다른 페이지에서 사용하게 세션에 담음
    $_SESSION['image'] ='http://ssl.gstatic.com/accounts/ui/avatar_2x.png';
    header('location:index.php');
    exit();

}else{
    //구글 로그인이 아닌경우


//기존에 등록된 회원인지 파악하기 위해 회원 목록 가져옴
$id = $_POST['id']; //사용자가 입력한 이름과 비번
$pass = $_POST['password'];

$sql = "SELECT * FROM users WHERE id = '$id' ";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$name = $row['name'];


$s = " select * from users where id = '$id' && password = '$pass'";
//이름과 비번이 해당하는 게 있으면 다나와
$result = mysqli_query($con,$s);
//디비에게 가져온 결과가 담김
$num = mysqli_num_rows($result);
//그것의 수를 셀게요.
if ($num ==1) { //같은게 있으면

    //사용자가 이미지를 등록한 경우 이미지를 가져옴
    $sql= "select image from users where id= '$id'";
    $result = mysqli_query($con, $sql);
    $imagerow = mysqli_fetch_array($result);
    if (isset($imagerow['image'])) {
    // 사용자 프로필 이미지가 있으면 채팅할 때 보여줄 이미지
    $_SESSION['image'] = $imagerow['image'];
    }else{
    //이미지를 등록하지 않은 경우
    $_SESSION['image'] = "http://ssl.gstatic.com/accounts/ui/avatar_2x.png";
    }


//이미 사용자가 활동중이라면
    if (isset($_SESSION['userid'])) {

    $_SESSION['otherid'] = $id;
    $_SESSION['othername'] = $name;
    }else{
    $_SESSION['otherid'] = $id;
    $_SESSION['username'] = $name;
    $_SESSION['userid'] =$id;//전역변수 즉 다른 페이지에서 사용하게 세션에 담음
    }
    if (isset($_POST['remember']))  {   //자동 로그인 체크했을 경우
        $changedid=md5($id);    //입력 아이디 암호화
        $s = " select * from permission where id = '$id'";
    //사용자가 입력한 아이디을 전부 가져와!라는 디비가 알아들을 수 있는 언어
        $result = mysqli_query($con,$s);
        $num = mysqli_num_rows($result);
    //같은 아이디이 담긴 변수에 담았지
    if ($num ==1 ) {    //이미 아이디를 자동로그인 등록했던 경우
    header('location:index.php'); //바로 자동로그인 됨
    exit;
    }else{  //쿠키에 자동로그인 등록함
        setcookie('remember', $changedid, time()+60*60*7);
        $cosql ="insert into permission(id, idchanged) values('$id','$changedid')";
        $result = mysqli_query($con,$cosql);
    }
    }
    header('location:index.php'); //홈으로
}else {                         //다르면
    header('location:login.php'); //로그인으로
}
}

?>
