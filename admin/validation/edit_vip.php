<?php
include '../../database/connection.php';

if (isset($_POST['vip'])) {
    $vip = htmlspecialchars($_POST['vip']);
    $client_id = isset($_POST['client_id']) ? (int) $_POST['client_id'] : 0;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_clients WHERE vip = :vip AND id != :client_id");
    $stmt->execute(['vip' => $vip, 'client_id' => $client_id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "false";
    } else {
        echo "true";
    }
}
