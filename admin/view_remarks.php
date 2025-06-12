<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'] ?? null;
$client = null;
if ($id) {
    $query = $conn->prepare("SELECT * FROM tbl_clients WHERE id = ?");
    $query->execute([$id]);
    $client = $query->fetch();
}

$remarks = [];
if ($id) {
    $remarksQuery = $conn->prepare("SELECT * FROM tbl_remarks WHERE client_id = ? ORDER BY created_at DESC");
    $remarksQuery->execute([$id]);
    $remarks = $remarksQuery->fetchAll(PDO::FETCH_ASSOC);
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
                    <li class="active"><i style="font-size: 20px;" class="material-icons">description</i> View Remarks
                    </li>
                </ol>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>VIEW REMARKS</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" style="margin-top: 20px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <label style="font-size: 20px !important;" class="form-label">First Name: <span><?php echo $client['first_name'] ?></span></label><br>
                                                <label style="font-size: 20px !important;" class="form-label">Last Name: <span><?php echo $client['last_name'] ?></span></label><br>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <label style="font-size: 20px !important;" class="form-label">Mobile: <span><?php echo $client['mobile'] ?></span></label><br>
                                                <label style="font-size: 20px !important;" class="form-label">Date of Birth: <span><?php echo $client['birthday'] ?></span></label><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <label style="font-size: 20px !important;" class="form-label">Type:</label>
                                            <label style="font-size: 20px !important;" class="form-label">
                                                <?php
                                                switch ($client['is_vip']) {
                                                    case 1:
                                                        echo "VIP #<span style='color: #555;'>" . htmlspecialchars($client['vip']) . "</span> - VALID UNTIL: <span style='color: #555;'>" . date('F j, Y', strtotime($client['valid_until'])) . "</span>";
                                                        break;
                                                    case 2:
                                                        echo "<strong style='color: blue;'>Package</strong>";
                                                        break;
                                                    case 3:
                                                        echo "<strong style='color: gray;'>Guest</strong>";
                                                        break;
                                                    default:
                                                        echo "<strong style='color: red;'>No-TYPE</strong>";
                                                        break;
                                                }
                                                ?>
                                            </label>

                                        </div>
                                    </div>

                                </div>

                                <?php
                                $basePath = '../uploads/form_client/';
                                ?>

                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <!-- MEDICAL HISTORY -->
                                        <div class="form-group form-float">
                                            <label class="form-label">CLIENT MEDICAL HISTORY FORM : </label>
                                            <?php if (!empty($client['medical_history'])): ?>
                                                <small>
                                                    <a href="<?= $basePath . $client['medical_history'] ?>" target="_blank">VIEW UPLOADED FILE</a>
                                                </small>
                                            <?php else: ?>
                                                <small style="color: red;">NO UPLOADED FILE</small>
                                            <?php endif; ?>
                                            <br>

                                            <label class="form-label">CLIENT VIP TERMS AND CONDITION FORM : </label>
                                            <?php if (!empty($client['vip_t_c'])): ?>
                                                <small>
                                                    <a href="<?= $basePath . $client['vip_t_c'] ?>" target="_blank">View Current File</a>
                                                </small>
                                            <?php else: ?>
                                                <small style="color: red;">NO UPLOADED FILE</small>
                                            <?php endif; ?>
                                            <br>

                                            <label class="form-label">CLIENT FILE CONSENT WAIVER FORM : </label>
                                            <?php if (!empty($client['consent_waiver'])): ?>
                                                <small>
                                                    <a href="<?= $basePath . $client['consent_waiver'] ?>" target="_blank">VIEW UPLOADED FILE</a>
                                                </small>
                                            <?php else: ?>
                                                <small style="color: red;">NO UPLOADED FILE</small>
                                            <?php endif; ?>
                                            <br>

                                            <label class="form-label">CLIENT FILE TREATMENT PACKAGE FORM : </label>
                                            <?php if (!empty($client['treatment_form'])): ?>
                                                <small>
                                                    <a href="<?= $basePath . $client['treatment_form'] ?>" target="_blank">VIEW UPLOADED FILE</a>
                                                </small>
                                            <?php else: ?>
                                                <small style="color: red;">NO UPLOADED FILE</small>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <a href="edit_client_information.php?client_id=<?php echo urlencode($client['id']); ?>" class="btn bg-teal waves-effect">EDIT CLIENT INFORMATION</a>
                                    <a href="add_remarks.php?id=<?php echo urlencode($client['id']); ?>" class="btn bg-teal waves-effect">ADD REMARKS</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->

            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CLIENT NOTES HISTORY
                            </h2>
                        </div>
                        <div class="body">
                            <!-- END ADD MODAL -->
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Added by Staff/Admin</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($remarks as $remark): ?>
                                            <tr>
                                                <td><?= date("Y/m/d - h:i:s A", strtotime($remark['created_at'])) ?></td>
                                                <td><?= htmlspecialchars($remark['added_by']) ?></td>
                                                <td>
                                                    <?= nl2br(htmlspecialchars(strlen($remark['remarks']) > 50 ? substr($remark['remarks'], 0, 50) . '...' : $remark['remarks'])) ?>
                                                </td>
                                                <td>
                                                    <a href="view_client_notes.php?id=<?= $remark['id'] ?>" class="btn bg-teal waves-effect">VIEW INFORMATION</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
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
    <!-- Demo Js -->
    <script src="js/demo.js"></script>

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