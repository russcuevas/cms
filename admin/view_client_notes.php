<?php
include '../database/connection.php';

// Get the remark ID
$remark_id = $_GET['id'] ?? null;

// Fetch remark data
if ($remark_id) {
    $stmt = $conn->prepare("SELECT tr.*, tc.first_name, tc.last_name FROM tbl_remarks tr
                            LEFT JOIN tbl_clients tc ON tr.client_id = tc.id
                            WHERE tr.id = ?");
    $stmt->execute([$remark_id]);
    $remark = $stmt->fetch();
}

if (!$remark) {
    die("Remark not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Client Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Client Note Information</h4>
            </div>
            <div class="card-body">
                <p><strong>Client Name:</strong> <?= htmlspecialchars($remark['first_name'] . ' ' . $remark['last_name']) ?></p>
                <p><strong>Date & Time:</strong> <?= date("Y/m/d h:i A", strtotime($remark['created_at'])) ?></p>
                <p><strong>Noted By:</strong> <?= htmlspecialchars($remark['added_by']) ?></p>
                <p><strong>Remarks:</strong><br><?= nl2br(htmlspecialchars($remark['remarks'])) ?></p>

                <?php if (!empty($remark['photo'])): ?>
                    <div class="mt-3">
                        <p><strong>Attached Photo:</strong></p>
                        <img src="../uploads/file_client/<?= htmlspecialchars($remark['photo']) ?>" class="img-fluid rounded" alt="Remark Photo" style="max-width: 300px;">
                    </div>
                <?php endif; ?>

                <a href="view_remarks.php?id=<?= $remark['client_id'] ?>" class="btn btn-secondary mt-4">Back to Notes</a>
            </div>
        </div>
    </div>
</body>

</html>