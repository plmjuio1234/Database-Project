<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ComputerPartsShop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $user_username = $_POST['username'];
    $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_name = $_POST['name'];
    $user_phone = $_POST['phone'];
    $user_address = $_POST['address'];

    // Check if username already exists
    $sql = "SELECT * FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $message = "Username already exists. Please choose a different username.";
    } else {
        // Insert the new user if username is not taken
        $sql = "INSERT INTO Users (Username, Password, Name, Phone, Address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $user_username, $user_password, $user_name, $user_phone, $user_address);
        if ($stmt->execute()) {
            $message = "Signup successful. <a class='forget' href='login.php'>Login now</a>";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        html {
            background: url(media/star-sky.jpg) no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="static/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/assets/css/Login-Form.css">
    <link rel="stylesheet" href="static/assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/earlyaccess/jejugothic.css" rel="stylesheet">
</head>
<body class="">
    <div class="backgrounds"></div>
    <div class="login-dark">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h2><left style="text-align: left;">Sign Up</left></h2>
        <div class="form-group"><input class="form-control" type="text" name="username" placeholder="ID" required><br></div>
        <div class="form-group"><input class="form-control" type="password" name="password" placeholder="PW" required minlength="8"><br></div>
        <div class="form-group"><input class="form-control" type="text" name="name" placeholder="이름"required><br></div>
        <div class="form-group"><input class="form-control" type="text" name="phone" placeholder="전화번호" required><br></div>
        <div class="form-group"><input class="form-control" type="text" name="address" placeholder="주소" required><br></div>
        <div class="form-group"><input class="btn btn-primary btn-block" type="submit" value="Sign Up" name="signup"></div>
    </form>
    </div>
    <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>
</body>
</html>
