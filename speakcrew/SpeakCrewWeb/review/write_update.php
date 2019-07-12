<?php
	require_once("./dbconfig.php");
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);


    session_start();
     $id = $_SESSION['userid'];
    if (isset($_SESSION['userid'])) {
     //사용자의 아이디와 이름
     $id = $_SESSION['userid'];
     $name = $_SESSION['username'];

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
	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_POST['bno'])) {
		$bNo = $_POST['bno'];
	}
	//bno이 없다면(글 쓰기라면) 변수 선언
	if(empty($bNo)) {
		$date = date('Y-m-d H:i:s');
	}
	$bTitle = $_POST['bTitle'];
	$bContent = $_POST['bContent'];

//글 수정
if(isset($bNo)) {
	//수정 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
		$sql = 'update board_free set b_title="' . $bTitle . '", b_content="' . $bContent . '" where b_no = ' . $bNo;
		$msgState = '수정';
	//틀리다면 메시지 출력 후 이전화면으로

//글 등록
} else {
	$sql = "insert into board_free ( b_title, b_content, b_date, b_hit, id, name) values('$bTitle', '$bContent', '$date', 0, '$id', '$name')";
	$msgState = '등록';
}


//메시지가 없다면 (오류가 없다면)
if(empty($msg)) {
	$result = $db->query($sql);

    $sql2 = 'alter table board_free auto_increment =1';
    $result2 = $db->query($sql2);
    $sql3 = 'SET @COUNT =0';
    $sql4 = 'update board_free set board_free.b_no = @COUNT:=@COUNT+1';
    $result3 = $db->query($sql3);
    $result4 = $db->query($sql4);
	//쿼리가 정상 실행 됐다면,

	if($result) {
		$msg = '정상적으로 글이 ' . $msgState . '되었습니다.';
		if(empty($bNo)) {
                $sql ="SELECT count(*) as ct from board_free";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                //가장 최신의 글 번호
                $bNo = $row['ct'];
            //    $bNo = $db->insert_id;
		}
		$replaceURL = './view.php?bno=' . $bNo;
	} else {
		$msg = '글을 ' . $msgState . '하지 못했습니다.';
?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>
<?php
		exit;
	}
}

?>
<script>
	alert("<?php echo $msg?>");
	location.replace("<?php echo $replaceURL?>");
</script>
