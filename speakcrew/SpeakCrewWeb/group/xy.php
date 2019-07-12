<?php
require_once("../review/dbconfig.php");
session_start();



if (isset($_POST['num'])) {
//공통으로 사용될 위도,경도
    $x = $_POST['x'];
    $y = $_POST['y'];

if ($_POST['num'] =='' ) { // 새로 글 쓰는 경우 새로운 글 번호를 가져온다.

    $sql = "select num from study order by num desc limit 1";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $num = $row['num']+1;

    //스터디 새로 만들 경우 장소를 수정할 때 이미 경위도 등록한 스터디 있는지 확인
    $s = " select * from xy where num = '$num'";
    $result = $db->query($s);
    $agnum = mysqli_num_rows($result);


    if ($agnum == 1) { // 이미 경위도 등록했었으면 새로운 것으로 변경해줘

         $sql ="update xy set x = '$x', y = '$y' where num ='$num'";
         $result = $db->query($sql);
    }else{
        //새로운 글과 위도경도 저장
        $newsql = "insert into xy (num, x, y) values('$num','$x','$y')";
        $result = $db->query($newsql);
    }


}else{ //글 수정인 경우 원래 글 번호에 있는 것을 업데이트 하면 됨
    $num = $_POST['num'];

    //스터디 수정할 때 장소를 반복적으로 변경하는 경우, 수정
    $s = " select * from xy where num = '$num'";
    $result = $db->query($s);
    $agnum = mysqli_num_rows($result);

    if ($agnum == 1) { // 스터디 새로 만들 경우 장소를 수정할 때

         $sql ="update xy set x = '$x', y = '$y' where num ='$num'";
         $result = $db->query($sql);
    }else{
        $newsql = "insert into xy (num, x, y) values('$num','$x','$y')";
        $result = $db->query($newsql);
    }


}
}
?>
