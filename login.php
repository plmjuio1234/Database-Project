<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        html {
            background: url(media/star-sky.jpg) no-repeat center center fixed; 
            -webkit-background-size: cover;
              -moz-background-size: cover;
                -o-background-size: cover;
                  background-size: cover;
        }
        #lo {
          text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="static/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/assets/css/Login-Form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/earlyaccess/jejugothic.css" rel="stylesheet">
</head>
<body>
    <div class="backgrounds"></div>
    <div class="login-dark">
        <form action="login.php" method="post">
        <h2><left>Login</left></h2>
        <div class="form-group"><input class="form-control" type="text" name="username" placeholder="아이디" required><br></div>
        <div class="form-group"><input class="form-control" type="password" name="password" placeholder="암호" required><br>
        <div class="form-group"><input class="btn btn-primary btn-block" type="submit" value="Login" name="login">
        <a class="forgot" href="signup.php">아이디가 없으신가요? 회원가입</a>
        </form>
        
    </div>

    <?php
session_start(); // 세션 시작

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ComputerPartsShop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $user_username = $_POST['username'];
    $user_password = $_POST['password'];

    $sql = "SELECT UserID, Password, Name, WalletBalance FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($user_password, $row['Password'])) {
            // 로그인 성공
            $_SESSION['userid'] = $row['UserID'];
            $_SESSION['username'] = $row['Name'];
            $_SESSION['balance'] = $row['WalletBalance'];
            header("Location: main.php"); // 메인 페이지로 리디렉션
            exit;
        } else {
            echo "<p>Invalid password!</p>";
        }
    } else {
        echo "<p>Username does not exist!</p>";
    }
    $stmt->close();
}
$conn->close();
?>

</body>
</html>
