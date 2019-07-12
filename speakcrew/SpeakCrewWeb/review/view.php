<?php
	require_once("./dbconfig.php");
	$bNo = $_GET['bno'];

    session_start();
    if (isset($_SESSION['userid'])) {
     //사용자의 아이디와 이름
     $id = $_SESSION['userid'];
     $name = $_SESSION['username'];

    }

     //조회 수 증가
	if(!empty($bNo) && empty($_COOKIE['board_free_' . $bNo])) {
		$sql = 'update board_free set b_hit = b_hit + 1 where b_no = ' . $bNo;
		$result = $db->query($sql);
		if(empty($result)) {
			?>
			<script>
				alert('오류가 발생했습니다.');
				history.back();
			</script>
			<?php
		} else {
			setcookie('board_free_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
		}
	}

	$sql = 'select b_title, b_content, b_date, b_hit, id, name from board_free where b_no = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="./css/normalize.css" />
        <link rel="stylesheet" href="./css/board.css" /> -->

	<title>후기</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <!-- <link rel="stylesheet" href="./css/bootstrap.css">
	<script src="./js/jquery-2.1.3.min.js"></script> -->
</head>
<body>
    <div class="container">
        <br><br><br><br>
		<h3>후기 보기</h3>
        <div class="container-fluid gedf-wrapper">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
			<div class="h2">제목 : <?php echo $row['b_title']?></div>
            <div class="btnSet">
            <p class="text-right">
                <?php if (isset($id) && $id == $row['id']){
                 ?>

                <a class="pull-right" href="./write.php?bno=<?php echo $bNo?>">수정</a>
                <a class="pull-right" href="./delete_update.php?bno=<?php echo $bNo?>">삭제</a>

                <?php
                }
                ?>
                <a class="pull-right" href="./review.php">목록</a></p>
            </div>

			<div class="h6 text-muted">작성자 : <?php echo $row['name']?></div>
				<div class="h6">작성일 : <?php echo $row['b_date']?></div>
				<div class="h6">조회 : <?php echo $row['b_hit']?></div>
                <br><br>
                <div class="h5">후기 : <br><?php echo $row['b_content']?></div>
			         </div>
                 </div>
        <div class="card">
            <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="h4 text-muted">댓글</div>
                <div>
                    <?php require_once('./comment.php')?>
                </div>
            </li>
                </div>
                </div>

                <!-- <div id="boardComment">
                    <?php // require_once('./comment.php')?>
                </div> -->
</div>
</div>
</div>
</div>

</body>
</html>
