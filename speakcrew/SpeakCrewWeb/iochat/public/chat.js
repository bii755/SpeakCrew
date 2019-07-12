//make connection

// Make connection
var socket = io.connect('http://localhost:4000');

// Query DOM
var message = document.getElementById('message')
// var name= document.getElementById('name');
var btn = document.getElementById('send');
var image = document.getElementById('users');
var output = document.getElementById('output');
var feedback= document.getElementById('feedback');
var realimg;
//이미지랑 이름 가져오고 나누기
data = image.value.split(",");
img =data[0];
name =data[1];
console.log(data[0]);
console.log(data[1]);

//이미지가 기본 이미지인지 변경한 이미지인지 구분하기
if (img =="http://ssl.gstatic.com/accounts/ui/avatar_2x.png") {
     realimg = img;
}else{
     realimg = "/speakcrew/profileimage/"+img;
}
console.log(realimg);

// Emit events //버튼 클릭시 소켓을 사용해 서버에 데이터를 보내고 사용자의 입력창을 비워준다.
btn.addEventListener('click', function(){
    if (message.value !='') {
        socket.emit('chat', {
            message: message.value,
            name: name,
            image: realimg
        });
    };
  message.value = "";
});

//사용자가 메세지를 작성하면 누가 작성중 인지를 소켓을 사용해서 서버에 보낸다.
message.addEventListener('keypress',function(){
    socket.emit('typing',name);
});

// Listen for events //서버에서 받은 나와 너가 작성한 메세지
socket.on('chat', function(data){
    feedback.innerHTML = '';
    output.innerHTML += "<div><div style='float:left;'><img id ='small' src="+data.image+" alter='images'/></div><div style='float: left;'><strong>"
     +data.name+" : <br></strong>" + data.message + "</div></div><br><br><br><br>";
});

//서버에서 받은 데이터 : 너가 글을 작성중인지를 알려준다.
socket.on('typing', function(data){
    console.log(data);
    feedback.innerHTML = '<p><em>'+data+'가 메세지 작성중입니다.</em></p>';
});
