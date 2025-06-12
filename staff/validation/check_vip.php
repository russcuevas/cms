<?php
include '../../database/connection.php';

if (isset($_POST['vip'])) {
    $vip = htmlspecialchars($_POST['vip']);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_clients WHERE vip = :vip");
    $stmt->execute(['vip' => $vip]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "false";
    } else {
        echo "true";
    }
}
