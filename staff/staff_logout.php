<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['staff_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: ../login.php');
    exit();
}

session_unset();
session_destroy();
header('Location: ../login.php');
exit();
