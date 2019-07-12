<?php

if (isset($_POST['pass1'])) {
    $pass =$_POST['pass1'];
    $passReg = preg_match("/^[A-Za-z0-9]{5,15}$/",$pass);
    if ($passReg == false) {
        echo "<p style='color:red'>5-15자의 영문 대 소문자와 숫자만 사용 가능합니다.</p>";
    }else if ($_POST['pass1'] == $_POST['pass2']) { //일치 여부 확인
        echo "<p style='color:green'>비밀번호가 일치합니다</p>";
    }else{
        echo "<p style='color:red'>비밀번호가 일치하지 않습니다.</p>";
    }
}
if (isset($_POST['id1'])){
    $id = $_POST['id1'];
    $con = mysqli_connect('localhost','root','1234','speakcrew');
    $sql = "select * from users where id = '$id' ";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    $idReg = preg_match("/^[a-z0-9]{5,15}$/",$id);
    if ($idReg== true && $num ==0) { //정규식에 일치하고 아이디 중복체크
        echo "<p style='color:green'>사용 가능한 아이디입니다!</p>";
    }else if($idReg== false){
    echo "<p style='color:red ; font-size:small'>5-15자의 영문 소문자와 숫자만 사용 가능합니다.</p>";
    } else{
    echo "<p style='color:red'>이미 사용 중인 아이디입니다.</p>";
}
}

if (isset($_POST['email1'])){
    $email = $_POST['email1'];
    $con = mysqli_connect('localhost','root','1234','speakcrew');
    $sql = "select * from users where email = '$email' ";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    $check_email=preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);

    if($check_email==true && $num ==0) {
       echo "<p style='color:green'>사용 가능한 이메일입니다!</p>";
    }else{
        echo "<p style='color:red ; font-size:small'>중복이거나 형식에 맞지 않은 이메일입니다.</p>";
    }
}
 ?>
