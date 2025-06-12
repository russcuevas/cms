<?php
include '../../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $sss = $_POST['sss'] ?? '';
    $pagibig = $_POST['pagibig'] ?? '';
    $philhealth = $_POST['philhealth'] ?? '';
    $mode_of_salary = $_POST['mode_of_salary'] ?? '';
    $gcash_number = $_POST['gcash_number'] ?? '';
    $bpi_number = $_POST['bpi_number'] ?? '';
    $bdo_number = $_POST['bdo_number'] ?? '';

    $stmt = $conn->prepare("INSERT INTO tbl_staff (fullname, mobile, birthday, email, password, sss, pagibig, philhealth, mode_of_salary, gcash_number, bpi_number, bdo_number, created_at, updated_at) 
                                VALUES (:fullname, :mobile, :birthday, :email, :password, :sss, :pagibig, :philhealth, :mode_of_salary, :gcash_number, :bpi_number, :bdo_number, NOW(), NOW())");

    $stmt->execute([
        ':fullname' => $fullname,
        ':mobile' => $mobile,
        ':birthday' => $birthday,
        ':email' => $email,
        ':password' => $password,
        ':sss' => $sss,
        ':pagibig' => $pagibig,
        ':philhealth' => $philhealth,
        ':mode_of_salary' => $mode_of_salary,
        ':gcash_number' => $gcash_number,
        ':bpi_number' => $bpi_number,
        ':bdo_number' => $bdo_number
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Staff added successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
