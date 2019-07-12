<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php
require_once("../review/dbconfig.php");
session_start();

if (isset($_SESSION['userid']) || isset($_POST['snum'])) {
    $id = $_SESSION['userid'];
    $name = $_SESSION['username'];

    $snum = $_POST['snum'];
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

//사용자가 수정을 눌렀을 경우
if(isset($snum)) { //기존에 입력했던 것들을 가져온다.
    $sql = 'select * from study where num = '.$snum;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $selected = $row['level'];
}

if (isset($_SESSION['userid'])) {
 $id = $_SESSION['userid'];
 $name = $_SESSION['username'];
}else {
    echo "세션값 없음";
}

?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>스터디 내용</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
   <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

	<!-- <link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" /> -->

</head>
<body>
<script src="./write.js"> </script>
    <div class="container">
        <br><br>
          <h2><a class="navbar-brand" href="../index.php"><span>SpeakCrew</span></a></h2>
		<h3>스터디 <?php echo isset($snum)?'수정':'개설'?></h3>
			<form  enctype="multipart/form-data" action="./write_update.php" method="post" >
				<?php
				if(isset($snum)) {
					echo '<input type="hidden" name="update" value="'.$snum.'">';
				}
				?>
				<table class="table table-bordered" id="boardWrite">
					<caption class="readHide"></caption>
					<tbody>
						<tr>
							<th scope="row"><label for="title">제목</label></th>
							<td class="title"><input class="form-control" type="text" name="title" id="title" value="<?php echo isset($row['title'])?$row['title']:null?>" required></td>
						</tr>
                        <tr>
							<th scope="row"><label for="pay">가격</label></th>
							<td class="title"><input class="form-control" type="text" name="pay" id="pay" value="<?php echo isset($row['price'])?$row['price']:null?>" required ></td>
						</tr>
                        <tr>
							<th scope="row"><label for="place">지역</label></th>
							<td class="title"><input class="form-control" type="text" name="place" id="place" value="<?php echo isset($row['place'])?$row['place']:null?>" required ></td>
						</tr>
                        <tr>
                            <th scope="row"><label for="place">모임 상세 장소</label></th>
                            <td class="title"><input type="text" id="address" name="address" placeholder="주소" value="<?= isset($row['address'])?$row['address']:null?>" required >
                                <input type="button" onclick="execDaumPostcode()" value="주소 검색" ><br><div id="map" style="width:300px;height:300px;margin-top:10px;display:none"></div></td>
                        </tr>
                        <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
                        <script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=0720131a6c1b3eaa9ca2c7928b0d1944&libraries=services"></script>

                        <script>
                            var mapContainer = document.getElementById('map'), // 지도를 표시할 div
                                mapOption = {
                                    center: new daum.maps.LatLng(37.537187, 127.005476), // 지도의 중심좌표
                                    level: 5 // 지도의 확대 레벨
                                };

                            //지도를 미리 생성
                            var map = new daum.maps.Map(mapContainer, mapOption);
                            //주소-좌표 변환 객체를 생성
                            var geocoder = new daum.maps.services.Geocoder();
                            //마커를 미리 생성
                            var marker = new daum.maps.Marker({
                                position: new daum.maps.LatLng(37.537187, 127.005476),
                                map: map
                            });


                            function execDaumPostcode() {
                                new daum.Postcode({
                                    oncomplete: function(data) {
                                        var addr = data.address; // 최종 주소 변수 //동을 선택해도 도로명주소로 변환되서 나옴
                                        console.log(addr);
                                        // 주소 정보를 해당 필드에 넣는다.
                                        document.getElementById("address").value = addr;
                                        // 주소로 상세 정보를 검색
                                        geocoder.addressSearch(data.address, function(results, status) {
                                            // 정상적으로 검색이 완료됐으면
                                            if (status === daum.maps.services.Status.OK) {

                                                var result = results[0]; //첫번째 결과의 값을 활용

                                                // 해당 주소에 대한 좌표를 받아서
                                                var coords = new daum.maps.LatLng(result.y, result.x);
                                                console.log(coords);
                                                console.log(result.y);
                                                console.log(result.x);
                                                var snum = '<?=$snum?>';
                                                console.log(snum);
                                                // 지도를 보여준다.

                                                $.post('./xy.php',
                                                 { x : result.x , y : result.y, num : snum},
                                                 function(data, status){
                                                    
                                                 }
                                                 )

                                                mapContainer.style.display = "block";
                                                map.relayout();
                                                // 지도 중심을 변경한다.
                                                map.setCenter(coords);
                                                // 마커를 결과값으로 받은 위치로 옮긴다.
                                                marker.setPosition(coords)
                                            }
                                        });
                                    }
                                }).open();
                            }
                        </script>

                        <tr>
							<th scope="row"><label for="bTitle">난이도</label></th>
							<td class="title"><select name ="level">
                            <option <?php  if ($selected == '입문') {echo"selected= selected";} ?> value="입문">입문</option>
                            <option <?php  if ($selected == '중급') {echo"selected= selected";} ?>value="중급">중급</option>
                            <option <?php  if ($selected == '고급') {echo"selected= selected";} ?>value="고급">고급</option>
                        </select></td>
                        </tr>

						<tr>
							<th scope="row"><label for="bContent">스터디 구성</label></th>
							<td class="content"><textarea class="form-control" name="index" id="bContent" required ><?php echo isset($row['detail'])?$row['detail']:null?></textarea></td>
						</tr>
                        <tr>
							<th scope="row"><label for="plan">일정</label></th>
							<td class="content"><textarea class="form-control" name="plan" id="plan" required><?php echo isset($row['plan'])?$row['plan']:null?></textarea></td>
						</tr>
                        <tr>
							<th scope="row"><label for="leader">리더 사진</label></th>
							<td><input type="file" name="leader" <?php if ($snum == null){ echo required;} ?>></td>
						</tr>
                        <tr>
							<th scope="row"><label for="instruction">리더 소개</label></th>
							<td class="content"><textarea class="form-control" name="instruction" id="instruction" required><?php echo isset($row['leader'])?$row['leader']:null?></textarea></td>
						</tr>
					</tbody>
				</table>
				<div class="btnSet">
					<button class="btn btn-primary" type="submit" >
						<?php echo isset($snum)?'수정':'작성'?>
					</button>
					<input type="button" onclick="location.href='./liststudy.php'" class="btn btn-primary" value="목록"></button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
