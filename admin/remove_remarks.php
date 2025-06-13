<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $client_id = $_POST['client_id'];

    $delete = $conn->prepare("DELETE FROM tbl_remarks WHERE id = ?");
    $delete->execute([$id]);

    $_SESSION['success'] = "Remarks deleted successfully!";
    header("Location: view_remarks.php?id=$client_id");
}
