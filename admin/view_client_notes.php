<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$remark_id = $_GET['id'] ?? null;
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
                        <div style="font-size: 10px; color: goldenrod;">GENERAL TRIAS</div>
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
                    <li class="active"><i style="font-size: 20px;" class="material-icons">description</i> Client Notes
                    </li>
                </ol>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>CLIENT NOTES</h2>
                        </div>
                        <div class="body">
                            <p><strong>Client Name:</strong> <?= htmlspecialchars($remark['first_name'] . ' ' . $remark['last_name']) ?></p>
                            <p><strong>Date & Time:</strong> <?= date("Y/m/d - h:i A", strtotime($remark['created_at'])) ?></p>
                            <p><strong>Added By:</strong> <?= htmlspecialchars($remark['added_by']) ?></p>
                            <p><strong>Remarks:</strong><br><?= nl2br(htmlspecialchars($remark['remarks'])) ?></p>

                            <?php if (!empty($remark['photo'])): ?>
                                <?php
                                $file = $remark['photo'];
                                $filePath = "../uploads/file_client/" . htmlspecialchars($file);
                                $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                $documentExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
                                ?>
                                <div class="mt-3">
                                    <p><strong>Attached File:</strong></p>

                                    <?php if (in_array($fileExtension, $imageExtensions)): ?>
                                        <img src="<?= $filePath ?>" class="img-fluid rounded" alt="Remark Image" style="max-width: 300px;">

                                    <?php elseif ($fileExtension === 'pdf'): ?>
                                        <a style="margin-bottom: 10px;" href="<?= $filePath ?>" download class="btn bg-red">
                                            CLICK HERE TO DOWNLOAD
                                        </a>
                                        <iframe src="<?= $filePath ?>" width="100%" height="1250px"></iframe>

                                    <?php elseif (in_array($fileExtension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])): ?>
                                        <a href="<?= $filePath ?>" target="_blank" class="btn btn-primary">
                                            View/Download <?= strtoupper($fileExtension) ?> File
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= $filePath ?>" download class="btn bg-red">
                                            Download File
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>


                            <div class="text-right">
                                <a href="view_remarks.php?id=<?= $remark['client_id'] ?>" class="btn bg-red mt-4">Back to Notes</a>
                            </div>
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

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
    <!-- SweetAlert Plugin Js -->
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
    <!-- SHOW VIP -->
    <script>
        document.getElementById('vip_select').addEventListener('change', function() {
            const vip_number_group = document.getElementById('vip_number_group');
            if (this.value === 'VIP') {
                vip_number_group.style.display = 'block';
            } else {
                vip_number_group.style.display = 'none';
            }
        });
    </script>
    <!-- END SHOW VIP -->

</body>

</html>