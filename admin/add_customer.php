<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sanitizeOrNull($conn, $value)
    {
        return empty($value) ? 'NULL' : $conn->quote(htmlspecialchars($value));
    }

    $first_name = sanitizeOrNull($conn, $_POST['name']);
    $last_name = sanitizeOrNull($conn, $_POST['surname']);
    $mobile = sanitizeOrNull($conn, $_POST['mobile']);
    $birthday = sanitizeOrNull($conn, $_POST['birthday'] ?? null);
    $is_vip = isset($_POST['is_vip']) ? (int)$_POST['is_vip'] : 0;
    $vip_value = sanitizeOrNull($conn, $_POST['vip'] ?? null);
    $valid_until_value = sanitizeOrNull($conn, $_POST['valid_until'] ?? null);

    $upload_dir = '../uploads/form_client/';

    function uploadOrNull($file_key, $upload_dir)
    {
        if (!empty($_FILES[$file_key]['name'])) {
            $filename = basename($_FILES[$file_key]['name']);
            $target_path = $upload_dir . $filename;
            if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $target_path)) {
                return $filename;
            }
        }
        return null;
    }

    $medical_history = uploadOrNull('medical_history', $upload_dir);
    $consent_waiver = uploadOrNull('consent_waiver', $upload_dir);
    $vip_t_c = uploadOrNull('vip_t_c', $upload_dir);
    $treatment_form = uploadOrNull('treatment_form', $upload_dir);

    $mh = $medical_history !== null ? $conn->quote($medical_history) : 'NULL';
    $cw = $consent_waiver !== null ? $conn->quote($consent_waiver) : 'NULL';
    $vtc = $vip_t_c !== null ? $conn->quote($vip_t_c) : 'NULL';
    $tf = $treatment_form !== null ? $conn->quote($treatment_form) : 'NULL';

    $sql = "INSERT INTO tbl_clients (
        first_name, last_name, mobile, birthday, is_vip, vip, valid_until,
        medical_history, consent_waiver, vip_t_c, treatment_form
    ) VALUES (
        $first_name, $last_name, $mobile, $birthday, $is_vip, $vip_value, $valid_until_value,
        $mh, $cw, $vtc, $tf
    )";

    if ($conn->exec($sql)) {
        $_SESSION['success'] = 'Client added successfully';
    } else {
        $_SESSION['error'] = 'Error adding client';
    }

    header('location: add_customer.php');
    exit();
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>TPY - System</title>
    <!-- Favicon-->
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!-- Sweetalert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        body {
            font-family: 'Poppins', sans-serif !important;
        }

        .select-form {
            display: block !important;
            width: 100% !important;
            height: 34px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            color: #555 !important;
            background-color: #fff !important;
            background-image: none !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s !important;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
        }
    </style>
</head>

<body class="theme-teal">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-teal">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a id="app-title" style="display:flex;align-items:center;" class="navbar-brand" href="index.php">
                    <img id="bcas-logo" style="width:45px;display:inline;margin-right:10px;" src="img/logo.png" />
                    <div>
                        <div style="font-size: 15px; color: goldenrod;">THE PRETTY YOU AESTHETIC CLINIC</div>
                    </div>
                </a>

            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i
                                class="material-icons">account_circle</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <?php include('left_sidebar.php') ?>
        <?php include('right_sidebar.php') ?>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol style="font-size: 15px;" class="breadcrumb breadcrumb-col-red">
                    <li><a href="index.php"><i style="font-size: 20px;" class="material-icons">home</i>
                            Dashboard</a></li>
                    <li><a href="all_clients.php"><i style="font-size: 20px;" class="material-icons">description</i>
                            Clients</a></li>
                    <li class="active"><i style="font-size: 20px;" class="material-icons">description</i> Add Clients
                    </li>
                </ol>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ADD CLIENTS</h2>
                        </div>
                        <div class="body">
                            <form id="add_customer_validation" method="POST" style="margin-top: 20px;" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name" required>
                                                <label class="form-label">First Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="surname" required>
                                                <label class="form-label">Last Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px !important;">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="number" class="form-control" name="mobile" required>
                                                <label class="form-label">Mobile <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="date" class="form-control" name="birthday">
                                                <label class="form-label">Date of birth <span style="color: red;"></span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <label class="form-label">Client Type <span style="color: red;">*</span></label>
                                            <select class="form-control select-form" name="is_vip" id="vip_select" required>
                                                <option value="" disabled selected>Choose Client TYPE</option>
                                                <option value="1">VIP</option>
                                                <option value="2">Package</option>
                                                <option value="3">Guest</option>
                                            </select>
                                        </div>

                                        <div id="vip_number_group" style="display: none;">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="number" class="form-control" name="vip">
                                                    <label class="form-label">VIP #</label>
                                                </div>
                                            </div>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" name="valid_until">
                                                    <label class="form-label">VIP VALID UNTIL</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="medical_history">
                                                <label class="form-label">UPLOAD MEDICAL HISTORY FORM</label>
                                            </div>
                                        </div>

                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="consent_waiver">
                                                <label class="form-label">UPLOAD CONSENT WAIVER</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="vip_t_c">
                                                <label class="form-label">UPLOAD VIP TERMS AND CONDITION</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="treatment_form">
                                                <label class="form-label">UPLOAD TREATMENT PACKAGE FORM</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button class="btn bg-teal waves-effect" type="submit">SAVE</button>
                                    <button type="button" class="btn btn-link waves-effect" onclick="window.location.href = 'all_clients.php'">BACK</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Jquery Validation Plugin Css -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>
    <script src="js/pages/forms/form-validation.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/tables/jquery-datatable.js"></script>
    <!-- SweetAlert Plugin Js -->
    <script src="plugins/sweetalert/sweetalert.min.js"></script>
    <!-- Demo Js -->
    <script src="js/demo.js"></script>
    <script src="ajax/add_customer.js"></script>

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

    <!-- SHOW VIP -->
    <script>
        document.getElementById('vip_select').addEventListener('change', function() {
            const vip_number_group = document.getElementById('vip_number_group');
            if (this.value === '1') {
                vip_number_group.style.display = 'block';
            } else {
                vip_number_group.style.display = 'none';
            }
        });
    </script>
    <!-- END SHOW VIP -->

</body>

</html>