<?php
 session_start();
 ini_set('display_errors', 1);
 ini_set('error_reporting', E_ALL);

if (isset($_SESSION['userid'])) {
     //사용자의 이름 보여주기 위해
 $id = $_SESSION['userid'];
 $name = $_SESSION['username'];
    if (isset($_SESSION['image'])) {
    //사용자의 이미지를 보여주기 위해
 $image = $_SESSION['image'];
    }else{
    //프로필 이미지를 등록하지 않았으면 기본이미지 보여주기
 $image = 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png';
    }

}else{
    $msg = '회원만 이용 가능합니다.';
    ?>
    <script>
        alert("<?php echo $msg?>");
        history.back();
    </script>
    <?php
        exit;
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>자유 수다방</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.js"></script>
        <link href="./style.css" rel="stylesheet" />
        <style>
        #small{height : 60px ; weight : 60px};
        </style>
    </head>
    <body>

        <div id="mario-chat">
            <h2>수다방</h2>
            <div id="chat-window">
                <!-- 나와 너의 채팅내역 -->
                <div id="output"></div>
                <!-- 누가 작성중인지 보여주는 부분 -->
                <div id="feedback"></div>
            </div>
            <input type="hidden" id="users" value="<?=$image?>,<?=$name?>"/>
            <input id="message" type="text" placeholder="메세지"/>
            <button id="send">Send</button>
        </div>

    </body>
    <script src="./chat.js"></script>
</html>
