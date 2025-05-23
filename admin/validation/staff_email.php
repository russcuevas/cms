<?php
include '../../database/connection.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $staff_id = $_POST['id'] ?? null;

    if ($staff_id) {
        $stmt = $conn->prepare("SELECT id FROM tbl_staff WHERE email = ? AND id != ?");
        $stmt->execute([$email, $staff_id]);
    } else {
        $stmt = $conn->prepare("SELECT id FROM tbl_staff WHERE email = ?");
        $stmt->execute([$email]);
    }

    echo $stmt->rowCount() > 0 ? 'false' : 'true';
}
