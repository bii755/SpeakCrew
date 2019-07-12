<?php
$con = mysqli_connect('localhost','root','1234');
//마이스퀠 서버 연결확인
mysqli_select_db($con, 'speakcrew');
session_start();//프로필 이미지를 저장하려고

$id = $_POST['userid'];
if (isset($_SESSION['userid']) && $id == $_SESSION['userid']) {
 $id = $_SESSION['userid'];
 $name = $_SESSION['username'];
}else {
    $msg = '해당 사용자만 이용 가능합니다.';
    ?>
    <script>
        alert("<?php echo $msg?>");
        history.back();
    </script>
    <?php
        exit;
}
    //사용자가 구매한 상품, 시간, 판매자 이름을 저장
    //사용자의 구매목록에 띄울 내용들
    $snum = $_POST['num'];
    $leader = $_POST['name'];
    $title = $_POST['stitle'];
    $id = $_POST['userid'];
    $date = date('Y-m-d H:i:s');

    //내 수강생들의 이름, 폰, 이유, 프로필 저장

    $name = $_POST['usname'];
    $phone = $_POST['usphone'];
    $reason = $_POST['usreason'];

    if ($_SESSION['image'] != "http://ssl.gstatic.com/accounts/ui/avatar_2x.png") {
    $image = $_SESSION['image'];
    }else{  // 프로필 이미지 없으면 기본이미지
    $image = 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png';
    }
    $sql = "insert into paied (id, snum, paiedtime, leader, title, name, phone, reason, image) values('$id', $snum, '$date', '$leader', '$title', '$name', '$phone', '$reason', '$image')";
    $result = mysqli_query($con, $sql);

    //리더가 만든 수업에 총 몇명의 사용자가 등록했는지 수정함
    //몇 명이 결제했는지에 대한 정보 가저오고
    //총 인원수를 저장함

    //몇 명이 지금 스터디를 구매했을까?
    $sql= "select count(*) as coun from paied where snum = '$snum'";
    $result = mysqli_query($con, $sql);
    $row = $result->fetch_assoc();
    $stutotal = $row['coun']; //전체 게시글의 수

    //총 인원 수 저장
    $sql = "update study set paypeople = '$stutotal' where num = '$snum'";
    $result = mysqli_query($con, $sql);


?>
