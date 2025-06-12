<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'] ?? null;

// Fetch staff data
$query = $conn->prepare("SELECT * FROM tbl_staff WHERE id = ?");
$query->execute([$id]);
$staff = $query->fetch();

if (!$staff) {
    $_SESSION['error'] = "Staff not found.";
    header("Location: manage_staff.php");
    exit();
}

// Handle form submission
if (isset($_POST['add_payslip_btn'])) {
    $remarks = $_POST['remarks'] ?? '';
    $added_by = trim($_POST['added_by'] ?? '');

    if (empty($added_by)) {
        $_SESSION['error'] = "The 'Added by' field is required.";
    } elseif (isset($_FILES['payslip_file']) && $_FILES['payslip_file']['error'] === 0) {
        $fileTmpPath = $_FILES['payslip_file']['tmp_name'];
        $fileName = $_FILES['payslip_file']['name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExts = ['pdf', 'doc', 'docx', 'jpg', 'png'];

        if (in_array(strtolower($fileExt), $allowedExts)) {
            $newFileName = uniqid('payslip_', true) . '.' . $fileExt;
            $uploadDir = '../uploads/payslips/';

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $stmt = $conn->prepare("INSERT INTO tbl_payslip (staff_id, remarks, payslip_file, added_by, created_at, updated_at)
                                        VALUES (?, ?, ?, ?, NOW(), NOW())");
                $stmt->execute([$id, $remarks, $newFileName, $added_by]);
                $_SESSION['success'] = "Payslip uploaded successfully.";
                header("Location: view_payslip.php?id=$id");
                exit();
            } else {
                $_SESSION['error'] = "Failed to move uploaded file.";
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Allowed types: pdf, doc, docx, jpg, png.";
        }
    } else {
        $_SESSION['error'] = "File upload error.";
    }
}

// Fetch payslip history
$payslips = $conn->prepare("SELECT * FROM tbl_payslip WHERE staff_id = ? ORDER BY created_at DESC");
$payslips->execute([$id]);
$payslipRecords = $payslips->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TPY - System</title>
    <!-- Favicon-->
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-header.bg-primary {
            background-color: black !important;
            color: white;
        }

        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .btn-back {
            background: black;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-success {
            background: black;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
        }

        .form-label {
            font-weight: 600;
        }

        .footer-note {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 1rem;
        }

        .alert {
            max-width: 600px;
            margin: 1rem auto;
        }

        /* Make the container full width with some padding */
        .container {
            max-width: 1200px;
        }

        /* Scrollable table on smaller screens */
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Flash Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width: 600px; margin: 1rem auto;">
                <i class="bi bi-check-circle-fill me-2"></i><?php echo $_SESSION['success'];
                                                            unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 600px; margin: 1rem auto;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $_SESSION['error'];
                                                                    unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary">
                        <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Staff Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($staff['fullname']); ?></p>
                        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($staff['mobile']); ?></p>
                        <p><strong>Birthday:</strong> <?php echo htmlspecialchars($staff['birthday']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($staff['email']); ?></p>
                        <p><strong>Role:</strong> <?php echo htmlspecialchars(ucfirst($staff['role'])); ?></p>
                        <hr>
                        <p><strong>SSS:</strong> <?php echo htmlspecialchars($staff['sss'] ?? 'N/A'); ?></p>
                        <p><strong>Pag-IBIG:</strong> <?php echo htmlspecialchars($staff['pagibig'] ?? 'N/A'); ?></p>
                        <p><strong>PhilHealth:</strong> <?php echo htmlspecialchars($staff['philhealth'] ?? 'N/A'); ?></p>
                        <p><strong>Preferred Mode:</strong> <?php echo htmlspecialchars($staff['mode_of_salary'] ?? 'N/A'); ?></p>
                        <p><strong>GCash Number:</strong> <?php echo htmlspecialchars($staff['gcash_number'] ?? 'N/A'); ?></p>
                        <p><strong>BPI Number:</strong> <?php echo htmlspecialchars($staff['bpi_number'] ?? 'N/A'); ?></p>
                        <p><strong>BDO Number:</strong> <?php echo htmlspecialchars($staff['bdo_number'] ?? 'N/A'); ?></p>
                        <div class="col-12">
                            <a href="edit_staff.php?id=<?php echo $staff['id']; ?>" class="btn btn-back mb-4 w-100"><i class="bi bi-pencil-square me-1"></i> Edit information</a>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted">Account Created: <?php echo htmlspecialchars($staff['created_at']); ?></small>
                            <small class="text-muted">Last Updated: <?php echo htmlspecialchars($staff['updated_at']); ?></small>
                        </div>
                        <!-- Add Payslip Button -->
                    </div>
                </div>
            </div>

            <!-- Manage Payslip and History Column -->
            <div class="col-lg-7">
                <h4 class="mb-3"><i class="bi bi-clock-history me-2"></i>Payslip History for <span class="text-primary"><?php echo htmlspecialchars($staff['fullname']); ?></span></h4>
                <div class="mt-3 text-center">
                    <div class="row">
                        <div class="col-6">
                            <a href="manage_staff.php" class="btn btn-back mb-4 w-100"><i class="bi bi-arrow-left-circle me-1"></i> Back to Staff</a>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#addPayslipModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Payslip
                            </button>
                        </div>

                    </div>
                </div>
                <div class="table-responsive shadow-sm rounded bg-white p-3">
                    <table id="payslipTable" class="table table-bordered align-middle mb-5">
                        <thead>
                            <tr>
                                <th>Remarks</th>
                                <th>File</th>
                                <th>Added By</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payslipRecords as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['remarks']); ?></td>
                                    <td>
                                        <a href="../uploads/payslips/<?php echo htmlspecialchars($row['payslip_file']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark-text"></i> View File
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['added_by']); ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>

    <!-- Add Payslip Modal -->
    <div class="modal fade" id="addPayslipModal" tabindex="-1" aria-labelledby="addPayslipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPayslipModalLabel"><i class="bi bi-upload me-2"></i>Add Payslip for <?php echo htmlspecialchars($staff['fullname']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="added_by_modal" class="form-label">Added by <span class="text-danger">*</span></label>
                            <input type="text" name="added_by" class="form-control" id="added_by_modal" required placeholder="Enter your name" />
                        </div>

                        <div class="mb-3">
                            <label for="remarks_modal" class="form-label">Remarks</label>
                            <textarea name="remarks" id="remarks_modal" class="form-control" rows="3" placeholder="Optional remarks..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="payslip_file_modal" class="form-label">Upload Payslip File <span class="text-danger">*</span></label>
                            <input type="file" name="payslip_file" id="payslip_file_modal" class="form-control" required />
                            <div class="form-text">Allowed file types: pdf, doc, docx, jpg, png.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_payslip_btn" class="btn btn-success"><i class="bi bi-upload me-1"></i> Upload Payslip</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#payslipTable').DataTable({
                // Optional: Customize options here
                "order": [
                    [3, "desc"]
                ], // Default sort by Created At descending
                "pageLength": 10, // Default number of rows per page
                "lengthMenu": [5, 10, 25, 50],
                "language": {
                    "emptyTable": "No payslips uploaded."
                }
            });
        });
    </script>

</body>

</html>