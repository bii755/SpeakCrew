<?php
	require_once("./dbconfig.php");
    session_start();
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
	//$_GET['bno']이 있을 때만 $bno 선언
	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}

	if(isset($bNo)) {
		$sql = 'select b_title, b_content from board_free where b_no = ' . $bNo;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>후기 작성 </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<!-- <link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" /> -->
</head>
<body>
    <div class="container">
        <br><br><br><br>
		<h3>후기 작성</h3>
			<form action="./write_update.php" method="post" encType="multiplart/form-data">
				<?php
				if(isset($bNo)) {
					echo '<input type="hidden" name="bno" value="' . $bNo . '">';
				}
				?>
				<table class="table table-bordered" id="boardWrite">
					<caption class="readHide"></caption>

					<tbody>
						<tr>
							<th scope="row"><label for="bTitle">제목</label></th>
							<td class="title"><input class="form-control" type="text" name="bTitle" id="bTitle" value="<?php echo isset($row['b_title'])?$row['b_title']:null?>" required></td>
						</tr>
						<tr>
							<th scope="row"><label for="bContent">내용</label></th>
							<td class="content"><textarea class="form-control" name="bContent" id="bContent" required><?php echo isset($row['b_content'])?$row['b_content']:null?></textarea></td>
						</tr>
					</tbody>
				</table>
				<div class="btnSet">
					<button class="btn btn-primary" type="submit" >
						<?php echo isset($bNo)?'수정':'작성'?>
					</button>
					<input type="button" onclick="location.href='./review.php'" class="btn btn-primary" value="목록"></button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
