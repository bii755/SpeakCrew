<?php
//사용자가 회원가입 버튼 클릭 했을 경우
session_start();
$con = mysqli_connect('localhost','root','1234');// mysql 서버 연결
mysqli_select_db($con, 'speakcrew'); // 저장할 디비 결정
$id = $_POST['id'];   //사용자가 입력한 아이디
$pass = $_POST['password'];
$re_pass = $_POST['repassword']; //사용자가 입력한 비번
$name = $_POST['name'];
$email = $_POST['email'];

//아이디, 패스워드, 이메일 정규식//i는 대소문자를 구분하지 않는다.
$idReg = preg_match("/^[a-z0-9]{5,15}$/",$id);
$check_email=preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
$passReg = preg_match("/^[A-Za-z0-9]{5,15}$/",$pass);
if ($pass != $re_pass || $pass ==null || $idReg ==false || $passReg ==false) { //패스워드가 일치하지 않은 경우 정규식과 다른 경우 이동
     header('Location:/speakcrew/register.php');
}else{
$s = " select * from users where id = '$id'";
//사용자가 입력한 아이디을 전부 가져와!라는 디비가 알아들을 수 있는 언어
$sql = " select * from users where email = '$email'";  //이메일 중복체크
$result = mysqli_query($con,$s);
//같은 아이디이 담긴 변수에 담았지
$emresult = mysqli_query($con,$sql);
$num = mysqli_num_rows($result);
//같은 이름의 수 즉 0아니면 1
$emnum = mysqli_num_rows($emresult);
if ($num ==1 || $emnum >=1) { //같은 아이디, 이메일이 있을경우
    header('Location:/speakcrew/register.php'); //회원가입 화면으로 이동
}
else{
$reg = "insert into users(id, password, name, email, phone, image) values ('$id', '$pass', '$name', '$email', '', 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png')";
//디비에 이름이랑 비번 저장할걸 디비가 알아듣게 만들자
mysqli_query($con,$reg);
//디비야 저장해줘~
$_SESSION['username'] = $name;
$_SESSION['userid'] =$id;//전역변수 즉 다른 페이지에서 사용하게 세션에 담음
$_SESSION['image'] ='http://ssl.gstatic.com/accounts/ui/avatar_2x.png';
echo "Registration Successful";
header('location:index.php'); //메인으로 이동
}
}
?>
