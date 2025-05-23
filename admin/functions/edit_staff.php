<?php
include '../../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing staff ID.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tbl_staff 
                                SET fullname = :fullname, 
                                    mobile = :mobile, 
                                    birthday = :birthday, 
                                    email = :email, 
                                    updated_at = NOW()
                                WHERE id = :id");

    $stmt->execute([
        ':fullname' => $fullname,
        ':mobile' => $mobile,
        ':birthday' => $birthday,
        ':email' => $email,
        ':id' => $id
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Staff updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
