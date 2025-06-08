<?php
session_start();
include '../database/connection.php';

$stmt = $conn->prepare("SELECT * FROM tbl_appointment");
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$groupedEvents = [];

// Only create 1 event per date, just to trigger "View Appointments" in UI
foreach ($appointments as $appt) {
    $dateOnly = date('Y-m-d', strtotime($appt['appointment_datetime']));

    // Prevent duplicate events for the same day
    if (!isset($groupedEvents[$dateOnly])) {
        $groupedEvents[$dateOnly] = [
            'title' => 'View Schedule',
            'start' => $dateOnly
        ];
    }
}

echo json_encode(array_values($groupedEvents));
