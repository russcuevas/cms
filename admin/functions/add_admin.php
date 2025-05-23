<?php
include '../../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("INSERT INTO tbl_admin (fullname, mobile, birthday, email, password, created_at, updated_at) 
                                VALUES (:fullname, :mobile, :birthday, :email, :password, NOW(), NOW())");

    $stmt->execute([
        ':fullname' => $fullname,
        ':mobile' => $mobile,
        ':birthday' => $birthday,
        ':email' => $email,
        ':password' => $password
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Admin added successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
