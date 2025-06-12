<?php
session_start();
include '../database/connection.php';

if (isset($_POST['date'])) {
    $date = $_POST['date'];

    $stmt = $conn->prepare("SELECT * FROM tbl_appointment WHERE DATE(appointment_datetime) = :date");
    $stmt->execute(['date' => $date]);

    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($appointments);
}
