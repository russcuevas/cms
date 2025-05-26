<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['client_id'])) {
    $_SESSION['error'] = "No client specified.";
    header('Location: all_clients.php');
    exit();
}

$client_id = (int) $_GET['client_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['name']);
    $last_name = htmlspecialchars($_POST['surname']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $birthday = htmlspecialchars($_POST['birthday']);
    $is_vip = (int) $_POST['is_vip'];

    // If non-VIP now, clear the vip field regardless of POST data
    if ($is_vip === 0) {
        $vip = null;
    } else {
        // VIP is set only if is_vip == 1, otherwise null
        $vip = isset($_POST['vip']) && $_POST['vip'] !== '' ? htmlspecialchars($_POST['vip']) : null;
    }

    $stmt = $conn->prepare("UPDATE tbl_clients SET first_name = ?, last_name = ?, mobile = ?, birthday = ?, is_vip = ?, vip = ? WHERE id = ?");
    if ($stmt->execute([$first_name, $last_name, $mobile, $birthday, $is_vip, $vip, $client_id])) {
        $_SESSION['success'] = 'Client updated successfully';
    } else {
        $_SESSION['error'] = 'Error updating client';
    }

    header('Location: edit_client_information.php?client_id=' . $client_id);
    exit();
}


$stmt = $conn->prepare("SELECT * FROM tbl_clients WHERE id = ?");
$stmt->execute([$client_id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    $_SESSION['error'] = "Client not found.";
    header('Location: all_clients.php');
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
                <ol class="breadcrumb breadcrumb-col-red" style="font-size: 15px;">
                    <li><a href="index.php"><i class="material-icons" style="font-size: 20px;">home</i> Dashboard</a></li>
                    <li><a href="all_clients.php"><i class="material-icons" style="font-size: 20px;">description</i> Clients</a></li>
                    <li class="active"><i class="material-icons" style="font-size: 20px;">edit</i> Edit Client</li>
                </ol>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Edit Client Information</h2>
                        </div>
                        <div class="body">
                            <form id="edit_customer_validation" method="POST" style="margin-top: 20px;">
                                <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name" required value="<?php echo htmlspecialchars($client['first_name']); ?>" required>
                                                <label class="form-label">First Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="surname" required value="<?php echo htmlspecialchars($client['last_name']); ?>" required>
                                                <label class="form-label">Last Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px !important;">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="number" class="form-control" name="mobile" required value="<?php echo htmlspecialchars($client['mobile']); ?>" required>
                                                <label class="form-label">Mobile <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="date" class="form-control" name="birthday" required value="<?php echo htmlspecialchars($client['birthday']); ?>" required>
                                                <label class="form-label">Date of birth <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <label class="form-label">VIP Type <span style="color: red;">*</span></label>
                                            <select class="form-control select-form" name="is_vip" id="vip_select" required>
                                                <option value="" disabled>Choose VIP TYPE</option>
                                                <option value="1" <?php echo ($client['is_vip'] == 1) ? 'selected' : ''; ?>>VIP</option>
                                                <option value="0" <?php echo ($client['is_vip'] == 0) ? 'selected' : ''; ?>>Non-VIP</option>
                                            </select>
                                        </div>

                                        <div id="vip_number_group" class="form-group form-float" style="display: <?php echo ($client['is_vip'] == 1) ? 'block' : 'none'; ?>;">
                                            <div class="form-line">
                                                <input type="number" class="form-control" name="vip" value="<?php echo htmlspecialchars($client['vip']); ?>">
                                                <label class="form-label">VIP #</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button class="btn bg-teal waves-effect" type="submit">UPDATE</button>
                                    <button type="button" class="btn btn-link waves-effect" onclick="window.location.href = 'all_clients.php'">BACK</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
    <script>
        $('#edit_customer_validation').validate({
            rules: {
                'vip': {
                    required: function() {
                        return $('#vip_select').val() === '1';
                    },
                    remote: {
                        url: 'http://localhost/tpy_clinic/admin/validation/edit_vip.php',
                        type: 'post',
                        data: {
                            vip: function() {
                                return $('input[name="vip"]').val();
                            },
                            client_id: function() {
                                return $('input[name="client_id"]').val();
                            }
                        }
                    }
                }
            },
            messages: {
                vip: {
                    remote: "VIP number already exists"
                }
            },
            highlight: function(input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function(input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function(error, element) {
                $(element).parents('.form-group').append(error);
            }
        });

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

        document.getElementById('vip_select').addEventListener('change', function() {
            const vip_number_group = document.getElementById('vip_number_group');
            if (this.value === '1') {
                vip_number_group.style.display = 'block';
            } else {
                vip_number_group.style.display = 'none';
            }
        });
    </script>

</body>

</html>