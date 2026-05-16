<?php
require_once '../config/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT id, pickup_location, dropoff_location, fare, status FROM rides WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$rides = [];
while($row = $result->fetch_assoc()) {
    $rides[] = $row;
}

echo json_encode(['success' => true, 'rides' => $rides]);
?>
