<?php
include '../../database/connection.php';

if (isset($_POST['vip'])) {
    $vip = htmlspecialchars($_POST['vip']);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_clients WHERE vip = :vip");
    $stmt->execute(['vip' => $vip]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // VIP already exists, return error message (any string)
        echo "false";
    } else {
        // VIP not found, return true (string "true")
        echo "true";
    }
}
