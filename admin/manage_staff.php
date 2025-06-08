<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// FETCH STAFF
$stmt = $conn->prepare("SELECT * FROM tbl_staff");
$stmt->execute();
$staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);
// END FETCH STAFF
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
                    <li class="active"><i style="font-size: 20px;" class="material-icons">description</i> Manage Staff
                    </li>
                </ol>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LIST OF STAFF
                            </h2>
                        </div>
                        <div class="body">
                            <div>
                                <button class="btn bg-red waves-effect" style="margin-bottom: 15px;" data-toggle="modal" data-target="#addStaffModal">+ ADD STAFF</button>
                            </div>

                            <!-- ADD MODAL -->
                            <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" style="display: none;">
                                <div class="modal-dialog modal-lg" role="document"> <!-- Make modal large -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="defaultModalLabel">Add Staff</h4>
                                        </div>
                                        <div class="modal-body" style="max-height: 100vh; overflow-y: auto;">
                                            <form id="add_staff_validation" method="POST">
                                                <div class="row">
                                                    <!-- LEFT COLUMN: Personal Information -->
                                                    <div class="col-md-6">
                                                        <h5>Personal Information</h5><br>
                                                        <!-- Fullname -->
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="fullname" required>
                                                                <label class="form-label">Fullname</label>
                                                            </div>
                                                        </div>

                                                        <!-- Mobile -->
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="number" class="form-control" name="mobile" required>
                                                                <label class="form-label">Mobile</label>
                                                            </div>
                                                        </div>

                                                        <!-- Birthday -->
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="date" class="form-control" name="birthday" required>
                                                                <label class="form-label">Birthday</label>
                                                            </div>
                                                        </div>

                                                        <!-- Email -->
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="email" class="form-control" name="email" required>
                                                                <label class="form-label">Email</label>
                                                            </div>
                                                        </div>

                                                        <!-- Password -->
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="password" class="form-control" name="password" maxlength="12" minlength="6" required>
                                                                <label class="form-label">Password</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RIGHT COLUMN: Bank Details -->
                                                    <div class="col-md-6">
                                                        <h5>Bank Details</h5><br>

                                                        <!-- SSS -->
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="sss">
                                                                <label class="form-label">SSS#</label>
                                                            </div>
                                                        </div>

                                                        <!-- Pag-IBIG -->
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="pagibig">
                                                                <label class="form-label">Pag-IBIG#</label>
                                                            </div>
                                                        </div>

                                                        <!-- PhilHealth -->
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="philhealth">
                                                                <label class="form-label">PhilHealth#</label>
                                                            </div>
                                                        </div>

                                                        <!-- Mode of Salary -->
                                                        <div class="form-group">
                                                            <label for="mode_of_salary">Mode of Salary</label>
                                                            <select class="form-control select-form" name="mode_of_salary" required>
                                                                <option value="">-- Please select --</option>
                                                                <option value="GCASH">GCASH</option>
                                                                <option value="BANK">BANK</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="gcash_number">
                                                                <label class="form-label">GCASH #</label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="philhealth">
                                                                <label class="form-label">BANK #</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Footer Buttons -->
                                                <div class="modal-footer">
                                                    <button class="btn bg-teal waves-effect" name="add_staff_btn" type="submit">SAVE</button>
                                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- END ADD MODAL -->

                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Fullname</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Birthday</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($staffs as $staff): ?>
                                            <tr>
                                                <td><?php echo $staff['fullname'] ?></td>
                                                <td><?php echo $staff['email'] ?></td>
                                                <td><?php echo $staff['mobile'] ?></td>
                                                <td><?php echo $staff['birthday'] ?></td>
                                                <td><?php echo $staff['created_at'] ?></td>
                                                <td><?php echo $staff['updated_at'] ?></td>
                                                <td>
                                                    <a href="" class="btn bg-teal waves-effect" data-toggle="modal" data-target="#edit_<?php echo $staff['id']; ?>">Edit</a>
                                                    <a href="" class="btn bg-teal waves-effect" data-toggle="modal" data-target="#delete_<?php echo $staff['id']; ?>">Remove</a>
                                                    <!-- MODAL -->
                                                    <?php include 'modal/manage_staff.php' ?>
                                                    <!-- END MODAL -->
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
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
    <script src="ajax/manage_staff.js"></script>
</body>

</html>