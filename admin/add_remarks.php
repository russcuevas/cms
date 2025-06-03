<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// GET THE CLIENT ID
$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM tbl_clients WHERE id = ?");
$query->execute([$id]);
$client = $query->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_POST['client_id'] ?? null;
    $remarks = $_POST['description'] ?? '';
    $staffName = $_POST['fullname'] ?? '';

    $photoName = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/file_client/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $photoName = time() . '_' . basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $photoName;

        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            die("Failed to upload file.");
        }
    }

    $stmt = $conn->prepare("INSERT INTO tbl_remarks (client_id, remarks, added_by, photo, created_at) 
                           VALUES (:client_id, :remarks, :added_by, :photo, NOW())");
    $stmt->execute([
        ':client_id' => $clientId,
        ':remarks' => $remarks,
        ':added_by' => $staffName,
        ':photo' => $photoName
    ]);
    $_SESSION['success'] = "Remarks saved successfully!";
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
                    <li class="active"><i style="font-size: 20px;" class="material-icons">description</i> Add Remarks
                    </li>
                </ol>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ADD REMARKS</h2>
                        </div>
                        <div class="body">
                            <form id="add_remarks_validation" method="POST" style="margin-top: 20px;" enctype="multipart/form-data">
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
                                                        echo 'VIP';
                                                        break;
                                                    case 2:
                                                        echo 'Package';
                                                        break;
                                                    case 3:
                                                        echo 'Guest';
                                                        break;
                                                    default:
                                                        echo 'Non-VIP';
                                                        break;
                                                }
                                                ?>
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="text-right">
                                    <a href="edit_client_information.php?client_id=<?php echo urlencode($client['id']); ?>" class="btn bg-teal waves-effect">EDIT CLIENT INFORMATION</a>
                                    <a href="view_remarks.php?id=<?= urlencode($client['id']) ?>" class="btn bg-teal waves-effect">VIEW REMARKS</a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>REMARKS</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="client_id" value="<?php echo $client['id'] ?>">
                                <div class="form-group form-float" style="margin-top: 20px; margin-bottom: 50apx !important;">
                                    <div class="form-line">
                                        <textarea style="border: 1px solid black; padding: 5px;" name="description" cols="30" rows="5" class="form-control" required></textarea>
                                        <label class="form-label">Type a remarks</label>
                                    </div>
                                </div>
                                <div class="row align-items-end" style="margin-top: 20px !important;">
                                    <div class="col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="fullname" required>
                                                <label class="form-label">Staff name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4"></div>

                                    <div class="col-md-4 ms-auto">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="photo">
                                                <label class="form-label">UPLOAD PHOTO</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 text-end">
                                        <button class="btn bg-teal waves-effect" type="submit">SAVE</button>
                                    </div>
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

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
    <script src="plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function() {
            $('#add_remarks_validation').validate({
                rules: {
                    'checkbox': {
                        required: true
                    },
                    'gender': {
                        required: true
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
        });
    </script>
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