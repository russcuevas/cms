<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['staff_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: ../login.php');
    exit();
}

$stmt = $conn->query("SELECT * FROM tbl_clients WHERE is_vip = 1 ORDER BY id DESC");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    <li class="active"><i style="font-size: 20px;" class="material-icons">description</i> VIP Clients
                    </li>
                </ol>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LIST OF VIP CLIENTS
                            </h2>
                        </div>
                        <div class="body">
                            <div>
                                <p>Filter by:</p>
                                <button class="btn bg-red waves-effect" style="margin-bottom: 15px;" onclick="window.location.href ='add_customer.php'">+ ADD CLIENTS</button>
                                <button class="btn bg-red waves-effect" style="margin-bottom: 15px;" onclick="window.location.href ='all_clients.php'">ALL CLIENTS</button>
                                <button class="btn bg-red waves-effect" style="margin-bottom: 15px;" onclick="window.location.href ='vip_clients.php'">VIP CLIENTS</button>
                                <button class="btn bg-red waves-effect" style="margin-bottom: 15px;" onclick="window.location.href ='package_clients.php'">PACKAGE CLIENTS</button>
                                <button class="btn bg-red waves-effect" style="margin-bottom: 15px;" onclick="window.location.href ='guest_clients.php'">GUEST CLIENTS</button>
                            </div>
                            <!-- END ADD MODAL -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fullname</th>
                                            <th>Mobile</th>
                                            <th>Date of birth</th>
                                            <th>VIP Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clients as $index => $client): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) ?></td>
                                                <td><?= htmlspecialchars($client['mobile']) ?></td>
                                                <td><?= htmlspecialchars($client['birthday']) ?></td>
                                                <td>
                                                    <?php
                                                    $today = new DateTime();
                                                    $validUntil = new DateTime($client['valid_until'] ?? 'now');
                                                    $createdAt = isset($client['created_at']) ? (new DateTime($client['created_at']))->format('Y-m-d') : 'N/A';

                                                    if ($client['is_vip'] == 1) {
                                                        echo "<strong style='color: red;'>VIP</strong> #" . htmlspecialchars($client['vip']) . "<br> at: {$createdAt}<br>";
                                                        if ($validUntil >= $today) {
                                                            $interval = $today->diff($validUntil)->days;
                                                            echo "UNTIL: ({$interval} days remaining)";
                                                        } else {
                                                            echo "VIP - <span style='color: red;'>EXPIRED</span><br>";
                                                            echo "<a href='edit_client_information.php?client_id=" . urlencode($client['id']) . "'>EDIT STATUS</a>";
                                                        }
                                                    } elseif ($client['is_vip'] == 3) {
                                                        echo "Guest";
                                                    } else {
                                                        echo "Non-VIP";
                                                    }
                                                    ?>
                                                </td>

                                                <td><?= htmlspecialchars($client['created_at']) ?></td>
                                                <td><?= htmlspecialchars($client['updated_at']) ?></td>
                                                <td>
                                                    <a style="margin-bottom: 5px;" href="edit_client_information.php?client_id=<?php echo urlencode($client['id']); ?>" class="btn bg-teal waves-effect">EDIT CLIENT INFORMATION</a> <br>
                                                    <a style="margin-bottom: 5px;" href="view_remarks.php?id=<?= urlencode($client['id']) ?>" class="btn bg-teal waves-effect">VIEW REMARKS</a>
                                                    <a style="margin-bottom: 5px;" href="" class="btn bg-teal waves-effect" data-toggle="modal" data-target="#delete_<?php echo $client['id']; ?>">REMOVE</a>

                                                    <div class="modal fade" id="delete_<?= $client['id']; ?>" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <form action="functions/delete_client.php" method="POST">
                                                                <input type="hidden" name="id" value="<?= $client['id']; ?>">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Confirm Delete</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete <strong><?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?></strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" name="delete" class="btn bg-teal waves-effect">YES, DELETE</button>
                                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CANCEL</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
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
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

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
</body>

</html>