<?php
//디비 연결
	require_once("../review/dbconfig.php");
    session_start();
    //글 쓰기 혹은 글 수정일 경우가 아닐경우 url로 접근할 경우 접근을 제어 함

    if (isset($_SESSION['userid']) || isset($_POST['update'])) {
     $name = $_SESSION['username'];
     $snum = $_POST['update'];
    }else {
        $msg = '접근할 수 없습니다.';
        ?>
        <script>
            alert("<?php echo $msg?>");
            history.back();
        </script>
        <?php
            exit;
    }
    if (!isset($_POST['title'])) {
        $msg = '접근할 수 없습니다.';
        ?>
        <script>
            alert("<?php echo $msg?>");
            history.back();
        </script>
        <?php
            exit;
    }

	// //bno이 없다면(글 쓰기라면) 변수 선언
	// if(empty($bNo)) {
	// 	$bID = $_SESSION['userid'];
	// }
	$sid= $_SESSION['userid'];
	//디비에 저장할 것 들
	$stitle = $_POST['title'];


    $splace = $_POST['place'];
    $saddress = $_POST['address'];
	$spay = $_POST['pay'];
	$slevel = $_POST['level'];
    $sindex = $_POST['index'];
    $splan = $_POST['plan'];
    $sinstruction = $_POST['instruction'];


    if (isset($_FILES['leader'])) { //업로드 파일 가져오기
        $file = $_FILES['leader'];
        $filename=$_FILES['leader']['name'];

        //이미지 등록이 안된경우 에러
        ini_set("display_errors","1");
        //이미지가 저장될 경로
        $uploaddir = '/usr/local/victolee/apache2.4.37/htdocs/speakcrew/group/leaderimage/';
        //이미지 저장될 경로+이미지 이름
        $uploadfile = $uploaddir.basename($_FILES['leader']['name']);
        //echo '<pre>'; //pre가 멀까? 에러 찍어주었다.
        //이미지 원하는 경로로 이동했을 경우
        if (move_uploaded_file($_FILES['leader']['tmp_name'],$uploadfile)) {


        }else{ //파일 이동이 안됬을 경우 다시 이동
        print "</pre>";
        header('Location:./studydesc.php?snum='.$snum);
        }

        }

    if (isset($snum)) {     //수정할 경우

        //이미지를 가져온다.
        $sql = "SELECT * FROM study WHERE num = '$snum'";
        $result = $db->query($sql);
        $row = mysqli_fetch_array($result);
        $image = $row['image'];

        if ($filename ==null) { //사용자가 이미지를 변경하지 않았을 경우
            $sql = "update study set title ='$stitle', place = '$splace', address = '$saddress' , detail = '$sindex', level = '$slevel',
             plan = '$splan', leader = '$sinstruction', price = '$spay' where num  = '$snum'";
         }else{ //이미지를 변경했을 경우 디비에 저장된 이미지를 다시 등록한다.
             $sql = "update study set title ='$stitle', place = '$splace', address = '$saddress' , detail = '$sindex', level = '$slevel',
                plan = '$splan', leader = '$sinstruction', image = '$filename', price = '$spay' where num  = '$snum'";
            }

    $msgState = "수정";
    }else{

    //글 추가
    $sql = "insert into study (id, title, place, address, detail, level, plan, leader, image, price, paypeople) values('$sid', '$stitle','$splace', '$saddress', '$sindex','$slevel','$splan','$sinstruction','$filename','$spay','0')";
    $msgState = "등록";
    }
    //글을 수정,삭제
    $result = $db->query($sql);

    if ($result) {

        if (empty($snum)) {
            $sql3 = 'SET @COUNT =0';
            $sql4 = 'update study set study.num = @COUNT:=@COUNT+1';
            $result3 = $db->query($sql3);
            $result4 = $db->query($sql4);
            $sql = "select num from study order by num desc limit 1";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $snum = $row['num'];

            }
            $msg = '정상적으로 글이 ' . $msgState . '되었습니다.';
            $replaceURL = './studydesc.php?snum='.$snum;


        }else{
        		$msg = '글을 ' . $msgState . '하지 못했습니다.';
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
        	alert("<?php echo $msg?>");
        	location.replace("<?php echo $replaceURL?>");
        </script>
