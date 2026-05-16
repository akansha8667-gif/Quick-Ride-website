<?php
require_once '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ride_id = $_POST['ride_id'];
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $method = $_POST['payment_method'] ?? 'cash';

    $stmt = $conn->prepare("INSERT INTO payments (ride_id, user_id, amount, payment_method, payment_status) VALUES (?, ?, ?, ?, 'completed')");
    $stmt->bind_param("iids", $ride_id, $user_id, $amount, $method);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Payment successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Payment failed']);
    }
}
?>
