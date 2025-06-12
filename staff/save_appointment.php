<?php
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $remarks = $_POST['remarks'];
    $appointment_datetime = $_POST['appointment_datetime'];

    $stmt = $conn->prepare("INSERT INTO tbl_appointment (fullname, remarks, appointment_datetime) VALUES (?, ?, ?)");
    if ($stmt->execute([$fullname, $remarks, $appointment_datetime])) {
        echo 'success';
    } else {
        echo 'error';
    }
}
