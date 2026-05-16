<?php
require_once '../config/config.php';

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];

        echo json_encode([
            'success' => true,
            'message' => 'Login Successful'
        ]);

    } else {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid Email or Password'
        ]);
    }

} else {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>
