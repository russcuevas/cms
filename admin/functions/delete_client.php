<?php
session_start();
include '../../database/connection.php';

if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM tbl_clients WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $_SESSION['success'] = "Client has been deleted successfully.";
    } catch (PDOException $e) {
        $_SESSION['errors'] = "Failed to delete client: " . $e->getMessage();
    }
} else {
    $_SESSION['errors'] = "Invalid request.";
}

header('Location: ../all_clients.php');
exit();
