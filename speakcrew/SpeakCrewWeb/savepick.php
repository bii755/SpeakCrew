<?php

$con = mysqli_connect('localhost','root','1234');
//마이스퀠 서버 연결확인
mysqli_select_db($con, 'speakcrew');
    if (isset($_POST['img'])) { //사용자가 찜하기를 한경우
        $id = $_POST['id'];
        $leaderid = $_POST['leaderid'];
        $snum = $_POST['snum'];

        if ($_POST['img'] == "http://localhost/speakcrew/img/not.png") {
            ini_set("display_errors", 1);
            $sql = "insert into list(id, leaderid, snum) values('$id','$leaderid','$snum')";
            $result = mysqli_query($con, $sql);
            echo "해당 스터디를 찜했습니다.";
        }else{
            //사용자가 찜 목록에서 삭제한 경우
         $sql= "delete from list where id ='$id' and snum ='$snum'";
         $result=mysqli_query($con, $sql);
         $sql2 = 'alter table list auto_increment =1';
         $result2=mysqli_query($con, $sql2);
         $sql3 = 'SET @COUNT =0';
         $sql4 = 'update list set list.listnum = @COUNT:=@COUNT+1';
         $result3 =mysqli_query($con, $sql3);
         $result4 =mysqli_query($con, $sql4);
         echo "찜한 스터디에서 삭제되었습니다. ";
     }
 }else {
     $msg = '회원만 이용가능합니다.';
     ?>
     <script>
         alert("<?php echo $msg?>");
         history.back();
     </script>
     <?php
         exit;
 }

?>
