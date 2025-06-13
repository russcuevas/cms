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
    $remarks = htmlspecialchars($_POST['remarks']);
    $fullname = htmlspecialchars($_POST['fullname']);

    if (!empty($_FILES['photo']['name'])) {
        $targetDir = "../uploads/file_client/";
        $filename = basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $filename;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath);

        $update = $conn->prepare("UPDATE tbl_remarks SET remarks = ?, added_by = ?, photo = ?, updated_at = NOW() WHERE id = ?");
        $update->execute([$remarks, $fullname, $filename, $id]);
    } else {
        $update = $conn->prepare("UPDATE tbl_remarks SET remarks = ?, added_by = ?, updated_at = NOW() WHERE id = ?");
        $update->execute([$remarks, $fullname, $id]);
    }
    $_SESSION['success'] = "Remarks updated successfully!";
    header("Location: view_remarks.php?id=$client_id");

    exit();
}
