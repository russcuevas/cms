<?php
include '../../database/connection.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $adminId = $_POST['id'] ?? null; // Optional for edit context

    if ($adminId) {
        // Exclude current admin's ID when checking for duplicates
        $stmt = $conn->prepare("SELECT id FROM tbl_admin WHERE email = ? AND id != ?");
        $stmt->execute([$email, $adminId]);
    } else {
        // Used during 'Add Admin'
        $stmt = $conn->prepare("SELECT id FROM tbl_admin WHERE email = ?");
        $stmt->execute([$email]);
    }

    echo $stmt->rowCount() > 0 ? 'false' : 'true';
}
