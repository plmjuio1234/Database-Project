var usname="admin";
var jepum="After effect Code";
var money=0;
var price=10000;
var jego1=100;
var date = today.getFullYear()+"년 "+eval(today.getMonth()+1)+"월 "+today.getDate()+"일";

var d = new Date();

function buy(product){
    if (!product){
        Swal.fire({
            showConfirmButton: false,
            title : "구매 완료",
            text : '구매가 성공적으로 처리되었습니다.',
            icon : "success",
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEscapeKey : false,
            allowEnterKey : false,
            });

            cost=cost-price;
            setTimeout(function() {
                window.location.href = "buylog.html";
            }, 3000);
        }
    }
        

function moneyadd(mon) {
    if (!mon) {
        Swal.fire({
            title:'충전완료!',
            icon : `success`, 
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEscapeKey : false,
            allowEnterKey : false,
        });
        var money = parseInt(money) + parseInt(money);
        setTimeout(function() {
            window.location.href = "shop.html";
        }, 3000);
    }
}

function time(){
    var time= new Date(); //시간받기위해서 new date
        document.getElementById("now").innerHTML=time.getHours()+"시"+time.getMinutes()+"분"+time.getSeconds()+"초";
       setInterval("time()",1000);     //1초 지난후 time()실행
    }

<script>
    $(document).ready(function(){
 
        $('.menu_btn>a').on('click', function(){
            $('.menu_bg').show(); 
            $('.sidebar_menu').show().animate({
                right:0
            });  
        });
        $('.close_btn>a').on('click', function(){
            $('.menu_bg').hide(); 
            $('.sidebar_menu').animate({
                right: '-' + 50 + '%'
                       },function(){
$('.sidebar_menu').hide(); 
}); 
        });
 
    });
</script>