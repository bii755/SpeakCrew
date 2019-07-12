<?php
if(isset($_POST['snum'])) {
    $snum = $_POST['snum'];
}

if(isset($snum)) {
    } else {
    $msg = '결제를 할 수 없습니다.';
    ?>
    <script>
        alert("<?php echo $msg?>");
        history.back();
    </script>
    <?php
        exit;
    }
require_once("../review/dbconfig.php");
$snum = $_POST['snum'];
session_start();
if (isset($_SESSION['userid'])) {
  $id = $_SESSION['userid'];
  $name = $_SESSION['username'];
}
//상품 정보 가져오기
$sql = 'select id, title, place, detail, level, plan, leader, image, price, paypeople from study where num = '.$snum;
$result = $db->query($sql);
$row = $result->fetch_assoc();


//구매 목록에 넣을 데이테인데 리더의 이름, 스터디의 이름이 있다.
$sql = "select us.name from users as us join study as st on us.id = st.id where st.num = '$snum'";
$result = $db->query($sql);
$namerow = $result->fetch_assoc();
    $leader = $namerow['name'];
    $title = $row['title'];

    // 내 학생들 목록에 넣을 결제한 학생의 이름, 전화번호, 수강 동기등이다.
 $name = $_POST['name'];
 $phone = $_POST['phone'];
 $reason = $_POST['reason'];

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>

        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        <script>
        var IMP = window.IMP; // 생략가능
   IMP.init('imp00144304');  // 가맹점 식별 코드

   IMP.request_pay({
    pg : 'inicis', // version 1.1.0부터 지원.
    pay_method : 'card',
    merchant_uid : 'merchant_' + new Date().getTime(),
    name : '주문명:결제테스트',
    amount : <?php echo $row['price']?>,
    buyer_email : 'iamport@siot.do',
    buyer_name : '구매자이름',
    buyer_tel : '010-1234-5678',
    buyer_addr : '서울특별시 강남구 삼성동',
    buyer_postcode : '123-456',
    m_redirect_url : 'https://www.yourdomain.com/payments/complete'
}, function(rsp) {
    if (rsp.success ) {
        var msg = '결제에 성공했습니다.';
        var title = '<?= $title?>';
        var leader = '<?= $leader?>';
        var snum = '<?= $snum?>';
        var id = '<?= $id?>';
        var name = '<?= $name?>';
        var phone = '<?= $phone?>';
        var reason = '<?= $reason?>';
        console.log(phone);
        console.log(leader);
        console.log(snum);
        console.log(id);
         $.post('../paied.php',
          { stitle : title , name : leader, num : snum, userid : id, usname : name, usphone : phone , usreason : reason },
          function(data, status){

          }
          )


    } else {
        var msg = '결제에 실패하였습니다.';
        //msg += '에러내용 : ' + rsp.error_msg;
    }
    alert(msg);
    location.replace("./liststudy.php");
});
        </script>
    </body>
</html>
