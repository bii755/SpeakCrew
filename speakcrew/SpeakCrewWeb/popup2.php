
<html>
<head>
<title></title>
<head>
<SCRIPT language="JavaScript">
<!--
function setCookie( name, value, expiredays )
{
var todayDate = new Date();
todayDate.setDate( todayDate.getDate() + expiredays );
document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function closeWin()
{
if ( document.forms[0].Notice.checked )
setCookie( "Notice", "done" , 1);
self.close();
}
//-->
</script>
</head>
<body onunload="closeWin()">
<img src="./img/instruction/five edit.jpg"  height="300px" width="300px">
<p>놀면서 하실래요?</p>
<form>
<input type=CHECKBOX name="Notice" value="">24시간 동안 팝업 안 보기
<a href="javascript:window.close()">닫기</a>
</form>
</body>
</html>
