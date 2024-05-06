<?php
session_start();
include 'db_config.php'; // 데이터베이스 연결 설정 포함

if (!isset($_SESSION['userid'])) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not logged in.');
}

$amount = $_POST['amount'];
$userid = $_SESSION['userid'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 사용자의 잔액 업데이트
$sql = "UPDATE Users SET WalletBalance = WalletBalance + ? WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $amount, $userid);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $sql = "SELECT WalletBalance FROM Users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $newBalance = floor($row['WalletBalance']); // 소수점 제거
    $_SESSION['balance'] = $newBalance; // 세션 업데이트
    echo json_encode(['newBalance' => $newBalance]);
} else {
    echo json_encode(['error' => "Error updating record: " . $conn->error]);
}


$stmt->close();
$conn->close();
?>
