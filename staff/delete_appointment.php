<?php
session_start();
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM tbl_appointment WHERE id = ?");
        $deleted = $stmt->execute([$id]);

        echo $deleted ? 'success' : 'error';
    } else {
        echo 'missing_id';
    }
} else {
    echo 'invalid_request';
}
