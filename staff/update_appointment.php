<?php
session_start();
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $remarks = $_POST['remarks'] ?? '';

    if (trim($id) === '' || trim($fullname) === '' || trim($remarks) === '') {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tbl_appointment SET fullname = ?, remarks = ? WHERE id = ?");
    $updated = $stmt->execute([$fullname, $remarks, $id]);

    if ($updated) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update: ' . $stmt->errorInfo()[2]]);
    }
}
