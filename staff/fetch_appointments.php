<?php
session_start();
include '../database/connection.php';

$stmt = $conn->prepare("SELECT fullname, appointment_datetime, remarks FROM tbl_appointment");
$stmt->execute();

$events = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $events[] = [
        'title' => $row['fullname'],
        'start' => $row['appointment_datetime'],
        'extendedProps' => [
            'remarks' => $row['remarks']
        ]
    ];
}

echo json_encode($events);
