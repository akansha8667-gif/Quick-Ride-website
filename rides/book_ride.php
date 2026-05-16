<?php
require_once '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Please login first']);
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $pickup = $_POST['pickup_location'] ?? '';
    $dropoff = $_POST['dropoff_location'] ?? '';
    $fare = rand(100, 500); // Demo fare calculation

    $stmt = $conn->prepare("INSERT INTO rides (user_id, pickup_location, dropoff_location, fare, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isss", $user_id, $pickup, $dropoff, $fare);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Ride booked!', 'fare' => $fare]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Booking failed']);
    }
}
?>
