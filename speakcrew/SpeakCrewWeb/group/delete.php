<?php
	require_once("../review/dbconfig.php");
    if(isset($_POST['snum'])) {
		$snum = $_POST['snum'];
	}

    //글 삭제
    if(isset($snum)) {
    	$sql = 'delete from study where num = '.$snum;
        $sqlxy = "delete from xy where num = '$snum'";
    	//틀리다면 메시지 출력 후 이전화면으로
    	} else {
    	$msg = '사용자만이 글을 제거할 수 있습니다.';
    	?>
    	<script>
    		alert("<?php echo $msg?>");
    		history.back(); //이전 페이지로 이동
    	</script>
    	<?php
    		exit;
    	}


    $result = $db->query($sql);
    $result = $db->query($sqlxy);
    $sql2 = 'alter table study auto_increment =1';
    $result2 = $db->query($sql2);
    $sql3 = 'SET @COUNT =0';
    $sql4 = 'update study set study.num = @COUNT:=@COUNT+1';
    $result3 = $db->query($sql3);
    $result4 = $db->query($sql4);



//쿼리가 정상 실행 됐다면,
if($result4) {
	$msg = '정상적으로 글이 삭제되었습니다.';
	$replaceURL = './liststudy.php';
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
<script> //글이 삭제되었을 경우 메세지 띄어주고 리스트로 간다.
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>
