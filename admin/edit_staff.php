<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    $query = "SELECT * FROM tbl_staff WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(1, $staff_id, PDO::PARAM_INT);
    $stmt->execute();

    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff) {
        header('Location: staff_list.php');
        exit();
    }
} else {
    header('Location: staff_list.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $email = $_POST['email'] ?? '';
    $sss = $_POST['sss'] ?? '';
    $pagibig = $_POST['pagibig'] ?? '';
    $philhealth = $_POST['philhealth'] ?? '';
    $mode_of_salary = $_POST['mode_of_salary'] ?? '';
    $gcash_number = $_POST['gcash_number'] ?? '';
    $bpi_number = $_POST['bpi_number'] ?? '';
    $bdo_number = $_POST['bdo_number'] ?? '';

    if (!$id) {
        $_SESSION['error'] = 'Missing staff ID.';
        header('Location: edit_staff.php?id=' . $id);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tbl_staff 
                            SET fullname = :fullname, 
                                mobile = :mobile, 
                                birthday = :birthday, 
                                email = :email, 
                                sss = :sss, 
                                pagibig = :pagibig, 
                                philhealth = :philhealth, 
                                mode_of_salary = :mode_of_salary, 
                                gcash_number = :gcash_number, 
                                bpi_number = :bpi_number, 
                                bdo_number = :bdo_number, 
                                updated_at = NOW()
                            WHERE id = :id");

    $stmt->execute([
        ':fullname' => $fullname,
        ':mobile' => $mobile,
        ':birthday' => $birthday,
        ':email' => $email,
        ':sss' => $sss,
        ':pagibig' => $pagibig,
        ':philhealth' => $philhealth,
        ':mode_of_salary' => $mode_of_salary,
        ':gcash_number' => $gcash_number,
        ':bpi_number' => $bpi_number,
        ':bdo_number' => $bdo_number,
        ':id' => $id
    ]);

    $_SESSION['success'] = 'Staff updated successfully.';
    header('Location: edit_staff.php?id=' . $id);
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>TPY - System</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link href="css/themes/all-themes.css" rel="stylesheet" />
</head>

<body>
    <div class="container" style="border: 2px solid black; padding: 20px; margin-top: 5px;">
        <h1>Edit Staff - <?php echo $staff['fullname']; ?></h1>

        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $staff['id']; ?>">

            <div class="row">
                <div class="col-md-6">
                    <h5>Personal Information</h5><br>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="fullname" value="<?php echo $staff['fullname']; ?>" required>
                            <label class="form-label">Fullname</label>
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" class="form-control" name="mobile" value="<?php echo $staff['mobile']; ?>" required>
                            <label class="form-label">Mobile</label>
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="date" class="form-control" name="birthday" value="<?php echo $staff['birthday']; ?>" required>
                            <label class="form-label">Birthday</label>
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" value="<?php echo $staff['email']; ?>" required>
                            <label class="form-label">Email</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5>Other Details</h5><br>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="sss" value="<?php echo $staff['sss']; ?>">
                            <label class="form-label">SSS#</label>
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="pagibig" value="<?php echo $staff['pagibig']; ?>">
                            <label class="form-label">Pag-IBIG#</label>
                        </div>
                    </div>

                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="philhealth" value="<?php echo $staff['philhealth']; ?>">
                            <label class="form-label">PhilHealth#</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Select Mode of Salary</label><br>
                        <input type="radio" name="mode_of_salary" value="BPI" onclick="showEditFieldForStaff('bpi')" id="bpi_<?php echo $staff['id']; ?>" <?php echo $staff['mode_of_salary'] == 'BPI' ? 'checked' : ''; ?>>
                        <label for="bpi_<?php echo $staff['id']; ?>">BPI</label>

                        <input type="radio" name="mode_of_salary" value="BDO" onclick="showEditFieldForStaff('bdo')" id="bdo_<?php echo $staff['id']; ?>" <?php echo $staff['mode_of_salary'] == 'BDO' ? 'checked' : ''; ?>>
                        <label for="bdo_<?php echo $staff['id']; ?>">BDO</label>

                        <input type="radio" name="mode_of_salary" value="GCASH" onclick="showEditFieldForStaff('gcash')" id="gcash_<?php echo $staff['id']; ?>" <?php echo $staff['mode_of_salary'] == 'GCASH' ? 'checked' : ''; ?>>
                        <label for="gcash_<?php echo $staff['id']; ?>">GCASH</label>
                    </div>

                    <!-- Bank Fields (BPI, BDO, GCASH) -->
                    <div id="bpi_field_edit" class="form-group" style="display:<?php echo $staff['mode_of_salary'] == 'BPI' ? 'block' : 'none'; ?>;">
                        <label>BPI #</label>
                        <input type="text" class="form-control" name="bpi_number" value="<?php echo $staff['bpi_number']; ?>">
                    </div>

                    <div id="bdo_field_edit" class="form-group" style="display:<?php echo $staff['mode_of_salary'] == 'BDO' ? 'block' : 'none'; ?>;">
                        <label>BDO #</label>
                        <input type="text" class="form-control" name="bdo_number" value="<?php echo $staff['bdo_number']; ?>">
                    </div>

                    <div id="gcash_field_edit" class="form-group" style="display:<?php echo $staff['mode_of_salary'] == 'GCASH' ? 'block' : 'none'; ?>;">
                        <label>GCASH #</label>
                        <input type="text" class="form-control" name="gcash_number" value="<?php echo $staff['gcash_number']; ?>">
                    </div>
                </div>
            </div>

            <a href="manage_staff.php" class="btn bg-orange waves-effect">Go back</a>
            <button class="btn bg-teal waves-effect" type="submit" name="edit_staff_btn">SAVE</button>
        </form>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-validation/jquery.validate.js"></script>
    <script src="js/pages/forms/form-validation.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.js"></script>
    <script src="plugins/node-waves/waves.js"></script>
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        <?php if (isset($_SESSION['success'])): ?>
            swal({
                type: 'success',
                title: 'Success!',
                text: '<?php echo $_SESSION['success']; ?>',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['success']); ?>
        <?php elseif (isset($_SESSION['error'])): ?>
            swal({
                type: 'error',
                title: 'Oops...',
                text: '<?php echo $_SESSION['error']; ?>',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>
    <script src="ajax/manage_staff.js"></script>
    <script>
        function showEditFieldForStaff(option) {
            document.getElementById('bpi_field_edit').style.display = 'none';
            document.getElementById('bdo_field_edit').style.display = 'none';
            document.getElementById('gcash_field_edit').style.display = 'none';

            if (option === 'bpi') {
                document.getElementById('bpi_field_edit').style.display = 'block';
            } else if (option === 'bdo') {
                document.getElementById('bdo_field_edit').style.display = 'block';
            } else if (option === 'gcash') {
                document.getElementById('gcash_field_edit').style.display = 'block';
            }
        }
    </script>
</body>

</html>