<?php
require_once '../config/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $pass = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);
    $role = $_POST['role'] ?? 'user';

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $pass, $role);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration Successful!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email already registered or error']);
    }
}
?>
