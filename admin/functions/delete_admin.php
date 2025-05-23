<?php
include '../../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing admin ID.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM tbl_admin WHERE id = :id");
    $stmt->execute([':id' => $id]);

    echo json_encode(['status' => 'success', 'message' => 'Admin deleted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
