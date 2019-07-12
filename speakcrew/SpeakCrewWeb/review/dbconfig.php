<?php
    header('Content-Type: text/html; charset=utf-8'); //모든 파일에서 include 되는 부분이라서 넣음
    //즉 모든 파일에 공통으로 해당되는 사항이다 == meta charset ='utf-8' 한국어를 인코딩할 수 있음= 나중에 웹페이지에 띄울 수 있다.
    $db = new mysqli('localhost', 'root', '1234', 'speakcrew');

	if ($db->connect_error) {
		die('데이터베이스 연결에 문제가 있습니다.\n관리자에게 문의 바랍니다.');
	}

	$db->set_charset('utf8');
?>
