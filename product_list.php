<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ComputerPartsShop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ProductID, Name, ImageURL, Price, DiscountRate, Stock, Description FROM Products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script src="https://kit.fontawesome.com/1aaa3662c7.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="static/js/cost.js"></script>
    <style>
        body { font-family: Arial, sans-serif; }
        .sidebar { width: 250px; position: fixed; top: 0; bottom: 0; left: 0; overflow: auto; background: #f0f0f0; padding: 20px; }
        .content { margin-left: 275px; padding: 20px; }
        .accordion { cursor: pointer; padding: 10px; width: 100%; text-align: left; border: none; outline: none; transition: 0.4s; }
        .panel { padding: 0 18px; background-color: white; display: none; overflow: hidden; }
    </style>
    <style>
        @font-face {
            font-family: 'GmarketSansMedium';
            src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2001@1.1/GmarketSansMedium.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'GmarketSansMedium', sans-serif;
        }

        pre {
            font-family: 'GmarketSansMedium', sans-serif;
            white-space: pre-wrap;
        }

        p {
            font-family: 'GmarketSansMedium', sans-serif;
            font-size: 1.1em;
            font-weight: 300;
            line-height: 1.7em;
            color: black;
        }
        .icon{
            width: 24px;
            fill: rgb(249, 247, 247);
            color: rgb(249, 247, 247);
            float: left;
            margin-right: 5px;

        }
        a,
        a:hover,
        a:focus {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s;
        }

        .navbar {
            padding: 15px 10px;
            background: #4e4e50;
            border: none;
            border-radius: 0;
            margin-bottom: 40px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-btn {
            box-shadow: none;
            outline: none !important;
            border: none;
        }

        .line {
            width: 100%;
            height: 1px;
            border-bottom: 1px solid #ddd;
            /* margin: 40px 0; */
        }

        .wrapper {
            /* display: flex; */
            width: 100%;
        }

        #sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            
            height: 100vh;
            z-index: 999;
            background: #177EFC;
            color: #fff;
            transition: all 0.3s;
        }
        #sidebarCollapse:hover {
            background: #302f2f;
        }
        #sidebarCollapse{
            color: white;
            background-color: #1a1a1d;
            font-size: 25px;
        }
        .producttitle { 
            /* text-align: center; */
            font-size: 20px;
            
        }
        .productbox { 
            background-color: #fff;
            color: #000000;
            border-radius: 4px;
            padding: 10px;
            border-top: solid #177EFC;
            margin-right: 15px;
            margin-left: 15px;
            margin-top: 15px;
            float: left;
        }
        .productbtn{
            width: 100%;
            height: 40px;
            /* position: absolute; */
            background-color: #007bff;
            color: #fff;
            padding-top: 10px;
            border-radius: 2px;
            margin-top: 10px;
            text-align: center;

        }
        .productcontent { 
            /* display: inline; */
            background-color: #BFCAFF;
            color: #000000;
            border-radius: 4px;
            padding: 10px;

            max-width:none;
            /* max-height: 93%; */
            /* min-width: 93%; */
            /* min-height: 93%; */
            width: 93%;
            height: auto;
            position: absolute;
            /* left: 50%; */
            /* top: 110%; */
            margin-top: 10px;
            
            /* -webkit-transform: translate(-50%,-50%); */
            /* transform: translateX(-50%) translateY(-50%); */


        }
        .content { 
            
            border-left: solid2;
            background-color: #1a1a1d;
            border-radius: 4px;
            padding: 10px;
            border-top: solid;
            max-width:none;
            max-height: 93%;
            min-width: 93%;
            min-height: 93%;
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%,-50%);
            transform: translateX(-50%) translateY(-50%);


        }
        .html{
            margin-left: 20px;
            margin-right: 40px;
        }
        .title{
            vertical-align: middle;
            font-family: 'GmarketSansMedium', sans-serif;
            font-size: 20px;
        }



        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            /* padding: 20px; */
            padding-top: 20px;
            text-align: center;
            color: #fff;
            background-color: #177EFC;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul p {
            color: #fff;
            background-color: #fff;
            padding: 10px;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
        }

        body{

            background-color: #ffffff ;
        }

        #sidebar ul li a:hover {
            color: fff;
            background: #000000;
        }

        #sidebar ul li.active>a,
        a[aria-expanded="true"] {
            color: #fff;
          

        }

        a[data-toggle="collapse"] {
            position: relative;
            background-color: #177EFC; 
        }

        .dropdown-toggle::after {
            display: block;
            position: absolute;
            top: 50%;
           
            right: 20px;
            transform: translateY(-50%);
            background-color: #177EFC;
        }

        ul ul a {
            font-size: 0.9em !important;
            padding-left: 30px !important;
            background: #1a1a1d;
        }

        ul.CTAs {
            padding: 20px;
        }

        ul.CTAs a {
            text-align: center;
            font-size: 0.9em !important;
            display: block;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        #content {
            width: calc(100% - 250px);
            padding: 40px;
            min-height: 100vh;
            transition: all 0.3s;
            position: absolute;
            /* top: 0; */
            right: 0;
        }

        #content.active {
            width: 100%;
        }
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
            }
            #content.active {
                width: calc(100% - 250px);
            }
            #sidebarCollapse span {
                display: none;
            }
        }
        .userb {
            border-radius: 3px;
            border: 1px solid;
            border-color: white;
            padding-top: 10px;
            padding-left: 5px;
            padding-right: 10px;
            padding-bottom: 10px;

        }
        .collapse list-unstyled {
            background-color: #177EFC; 

        }

        .textLauncherIcon {
            z-index: 1000 !important;
        }
    </style>
</head>
<script>
    var isPlayed = true;
    var currentmoney = "{{user_info[3]}}";

    window.onload = function(){
        $(".music-playbutton").hide(); 
        document.addEventListener('click', function(event){
            if (isPlayed){
                $("iframe")[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
            }
        });
        $(".loading").fadeOut();
        (function() {
      var w = window;
      if (w.ChannelIO) {
        return (window.console.error || window.console.log || function(){})('ChannelIO script included twice.');
      }
      var ch = function() {
        ch.c(arguments);
      };
      ch.q = [];
      ch.c = function(args) {
        ch.q.push(args);
      };
      w.ChannelIO = ch;
      function l() {
        if (w.ChannelIOInitialized) {
          return;
        }
        w.ChannelIOInitialized = true;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://cdn.channel.io/plugin/ch-plugin-web.js';
        s.charset = 'UTF-8';
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
      }
      if (document.readyState === 'complete') {
        l();
      } else if (window.attachEvent) {
        window.attachEvent('onload', l);
      } else {
        window.addEventListener('DOMContentLoaded', l, false);
        window.addEventListener('load', l, false);
      }
    })();
    ChannelIO('boot', {
      "pluginKey": "{{channelio}}"
    });
    }

    function info(product, names){
                if (!product) {
                    Swal.fire({
                        'icon' : "success",
                        'title' : `${names}`,
                        'html' : "제품 소개가 없습니다.",
                    });
                } else {
                    Swal.fire({
                        'icon' : "success",
                        'title' : `${names}`,
                        'html' : `<pre>${product}</pre>`,
                    });
                }
            }

    function information(informations){
                    Swal.fire({
                        'icon' : "success",
                        'title' : `${informations}`,
                    });    
            }


            function changepw(){
                Swal.fire({
                title: '비밀번호 변경하기',
                html:
                    '<input id="nowpw" class="swal2-input" placeholder="현재 비밀번호" type="password">'+
                    '<input id="pw" class="swal2-input" placeholder="새 비밀번호" type="password">'+
                    '<input id="pwcheck" class="swal2-input" placeholder="새 비밀번호 확인" type="password">',
                showCancelButton : true,
                cancelButtonText : "취소",
                confirmButtonText : "변경하기",
                preConfirm: () => {
                    var obj = new Object();
                    obj.nowpw = $("#nowpw").val();
                    obj.pw = $("#pw").val();
                    obj.pwcheck = $("#pwcheck").val();
                    var jsonData = JSON.stringify(obj);

                    $.ajax({
                        url : "changepw",
                        data : jsonData,
                        contentType:"application/json",
                        type : 'POST',
                    }).done(function(data) {
                            if (data == "ok"){
                                Swal.fire(
                                '변경 성공',
                                "비밀번호가 변경되었습니다.",
                                'success'
                                );
                            }else{
                                Swal.fire(
                                '변경 실패',
                                data,
                                'error'
                                );
                            }
                    })
                }
                })
            }
</script>
<body>
<div class="wrapper">
    <nav id="sidebar">
            <div class="sidebar-header">
                <h3>은성몰</h3>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="#UserInfo" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-user"></i> 유저정보
                    </a>
                    <ul class="collapse list-unstyled" id="UserInfo">
                        <li>
                            <a><i class="fas fa-users"></i> <?php echo $_SESSION['username']; ?> 님</a>
                            <a><i class="fas fa-won-sign"></i> 잔액 : <?php echo $_SESSION['balance']; ?>원</a>
                            <a href="javascript:changepw();"><i class="fas fa-exchange-alt"></i> 정보변경</a>
                        </li>                        
                    </ul>
                </li>
                <li>
                    <a href='javascript:$(".loading").fadeIn(); window.location.href = "main.php";'>
                        <i class="fa fa-bullhorn"></i> 공지사항
                    </a>
                </li>
                <li>
                    <a href='javascript:$(".loading").fadeIn(); window.location.href = "add_funds.php";'>
                        <i class="fa fa-credit-card"></i> 충전하기
                    </a>
                </li>
                <li>
                </li>
                <li>
                    <a href='javascript:$(".loading").fadeIn(); window.location.href = "product_list.php";'>
                        <i class="fa fa-shopping-cart"></i> 상품목록
                    </a>
                </li>
                <li>
                    <a href='javascript:$(".loading").fadeIn(); window.location.href = "purchase_history.php";'>
                        <i class="fa fa-shopping-bag"></i> 구매기록
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fa fa-unlock"></i> 로그아웃
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div id="content">
    <div class="productcontent">
        <h2>상품목록</h2>
        <div class="t">
            <!-- <button type="button" id="sidebarCollapse" class="btn" style="background-color: #2c2c2e;"> -->
            <!-- <i class="fa fa-list"></i> -->
            <!-- </button>  -->
        </div>
        <div class="html">
            <div class="productbox">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<h3>" . $row["Name"] . "</h3>";
                    echo "<img src='" . $row["ImageURL"] . "' alt='" . $row["Name"] . "' style='width:100px;'><br>";
                    echo "Price: $" . $row["Price"] . "<br>";
                    echo "Discount: " . $row["DiscountRate"] . "%<br>";
                    echo "Stock: " . $row["Stock"] . "<br>";
                    echo "<p>" . $row["Description"] . "</p>";
                    echo "<button onclick='addToCart(" . $row["ProductID"] . ")'>Add to Cart</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
            <div class="productbtn" onclick="buy();">구매하기</script></div>
            <div class="productbtn" onclick="info('라이센스 코드입니다', '상세 설명');">제품 상세 설명 보기</div>
            </div>
        </div>
        
        </div>
    </div>
    </div>

    <script>
    function addToCart(productId) {
        console.log("Add to cart:", productId);
        // AJAX 요청으로 장바구니 추가 로직 구현 가능
    }
    </script>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
	<script>
</script>
</body>
</html>
