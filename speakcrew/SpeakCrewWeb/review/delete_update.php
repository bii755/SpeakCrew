<?php
	require_once("./dbconfig.php");

    if (isset($_SESSION['userid']) && isset($_GET['bno'])) {
     //사용자의 아이디와 이름
     $id = $_SESSION['userid'];
     $name = $_SESSION['username'];


     $sql = "select * from board_free where b_no = $bNo";
     $result = $db->query($sql);
     $row = $result->fetch_assoc();
    if ($row['id'] != $id) { //게시물 작성자만 삭제 가능
        $msg = '작성자만 삭제 가능합니다.';
        ?>
        <script>
            alert("<?php echo $msg?>");
            history.back();
        </script>
        <?php
            exit;
    }

    }
 $bNo = $_GET['bno'];
//글 삭제
if(isset($bNo)) {
		$sql = 'delete from board_free where b_no = ' . $bNo;
}

	$result = $db->query($sql);
    $sql2 = 'alter table board_free auto_increment =1';
    $result2 = $db->query($sql2);
    $sql3 = 'SET @COUNT =0';
    $sql4 = 'update board_free set board_free.b_no = @COUNT:=@COUNT+1';
    $result3 = $db->query($sql3);
    $result4 = $db->query($sql4);



//쿼리가 정상 실행 됐다면,
if($result4) {
	$msg = '정상적으로 글이 삭제되었습니다.';
	$replaceURL = './review.php';
} else {
	$msg = '글을 삭제하지 못했습니다.';
?>
	<script>
		alert("<?php echo $msg?>");
		history.back();
	</script>
<?php
	exit;
}


?>
<script>
//정상적으로 삭제되었을 경우
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>
