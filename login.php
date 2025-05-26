<?php
session_start();
include('database/connection.php');

if (isset($_SESSION['admin_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/index.php');
    } elseif ($_SESSION['role'] === 'staff') {
        header('Location: staff/index.php');
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // 1. Check in tbl_admin
        $query_admin = "SELECT * FROM tbl_admin WHERE email = :email";
        $stmt_admin = $conn->prepare($query_admin);
        $stmt_admin->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_admin->execute();

        if ($stmt_admin->rowCount() == 1) {
            $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);
            if ($password === $admin['password']) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['email'] = $admin['email'];
                $_SESSION['fullname'] = $admin['fullname'];
                $_SESSION['role'] = $admin['role'];

                if ($admin['role'] === 'admin') {
                    header('Location: admin/index.php');
                    exit();
                }
            }
        }

        // 2. Check in tbl_staff if not found in tbl_admin
        $query_staff = "SELECT * FROM tbl_staff WHERE email = :email";
        $stmt_staff = $conn->prepare($query_staff);
        $stmt_staff->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_staff->execute();

        if ($stmt_staff->rowCount() == 1) {
            $staff = $stmt_staff->fetch(PDO::FETCH_ASSOC);
            if ($password === $staff['password']) {
                $_SESSION['admin_id'] = $staff['id'];
                $_SESSION['email'] = $staff['email'];
                $_SESSION['fullname'] = $staff['fullname'];
                $_SESSION['role'] = $staff['role'];

                if ($staff['role'] === 'staff') {
                    header('Location: staff/index.php');
                    exit();
                }
            }
        }

        $_SESSION['error'] = 'Invalid email or password';
        header('location: login.php');
        exit();
    } else {
        $_SESSION['error'] = 'Email and password are required.';
        header('location: login.php');
        exit();
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>TPY - System</title>
    <link rel="icon" href="admin/img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="admin/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="admin/css/style.css" rel="stylesheet">
    <!-- Sweetalert Css -->
    <link href="admin/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
            background: linear-gradient(to right, rgb(9, 8, 8), rgb(212, 168, 12));
        }

        .input-group label.error {
            font-size: 12px;
            display: block;
            margin-top: 5px;
            font-weight: normal;
            color: red !important;
            margin-bottom: 0px;
        }

        .input-group .form-line.error:after {
            border-bottom: 2px solid red !important;
        }
    </style>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="login.php">
                <img style="width: 170px;" src="admin/img/logo.png" alt="TPY-Logo" class="logo-img">
            </a>
        </div>

        <div class="card">
            <div class="body">
                <form action="" id="sign_in" method="POST">
                    <div class="msg"><span style="font-size: 30px;">Login</span></div>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
                        </div>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>

                    <button class="btn btn-block btn-lg bg-red waves-effect" type="submit">LOGIN</button>
                </form>
            </div>
        </div>
    </div>

    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <script src="admin/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="admin/plugins/node-waves/waves.js"></script>
    <script src="admin/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="admin/js/admin.js"></script>
    <script src="admin/js/pages/examples/sign-in.js"></script>
    <!-- SweetAlert Plugin Js -->
    <script src="admin/plugins/sweetalert/sweetalert.min.js"></script>
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
</body>

</html>