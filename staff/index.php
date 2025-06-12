<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['staff_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: ../login.php');
    exit();
}

// GET THE NON VIP
$get_total_guest = "SELECT COUNT(*) AS total_guest FROM `tbl_clients` WHERE is_vip = 3";
$stmt_total_guest = $conn->prepare($get_total_guest);
$stmt_total_guest->execute();
$result_total_guest = $stmt_total_guest->fetch(PDO::FETCH_ASSOC);
$total_guest = $result_total_guest['total_guest'];
// END GET TOTAL NON VIP

// GET THE VIP
$get_total_package = "SELECT COUNT(*) AS total_package FROM `tbl_clients` WHERE is_vip = 2";
$stmt_total_package = $conn->prepare($get_total_package);
$stmt_total_package->execute();
$result_total_package = $stmt_total_package->fetch(PDO::FETCH_ASSOC);
$total_package = $result_total_package['total_package'];
// END GET TOTAL VIP

// GET THE VIP
$get_total_vip = "SELECT COUNT(*) AS total_vip FROM `tbl_clients` WHERE is_vip = 1";
$stmt_total_vip = $conn->prepare($get_total_vip);
$stmt_total_vip->execute();
$result_total_vip = $stmt_total_vip->fetch(PDO::FETCH_ASSOC);
$total_vip = $result_total_vip['total_vip'];
// END GET TOTAL VIP

date_default_timezone_set('Asia/Manila');
$today = date('Y-m-d');  // current date in Asia/Manila timezone


// FETCH APPOINTMENT TODAY
$stmt = $conn->prepare("SELECT * FROM tbl_appointment WHERE DATE(appointment_datetime) = ?");
$stmt->execute([$today]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
// END FETCH APPOINTMENT TODAY

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>TPY - System</title>
    <!-- Favicon-->
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    <!-- Sweetalert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

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
    <!-- #Top Bar -->
    <section>
        <?php include('left_sidebar.php') ?>
        <?php include('right_sidebar.php') ?>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='vip_clients.php';">
                    <div class="info-box bg-teal hover-expand-effect" style="cursor: pointer;">
                        <div class="icon">
                            <i class="material-icons">verified</i>
                        </div>
                        <div class="content">

                            <div class="text">TOTAL VIP CLIENTS</div>
                            <div class="number"><?php echo $total_vip ?></div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='package_clients.php';">
                    <div class="info-box bg-teal hover-expand-effect" style="cursor: pointer;">
                        <div class="icon">
                            <i class="material-icons">unpublished</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL PACKAGE CLIENTS</div>
                            <div class="number"><?php echo $total_package ?></div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='guest_clients.php';">
                    <div class="info-box bg-teal hover-expand-effect" style="cursor: pointer;">
                        <div class="icon">
                            <i class="material-icons">unpublished</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL GUEST CLIENTS</div>
                            <div class="number"><?php echo $total_guest ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->

            <div class="row clearfix">
                <!-- LEFT COLUMN - Appointments -->
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                APPOINTMENT FOR TODAY
                                <br>
                                <span style="color: red;" id="runningDateTime"></span>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Fullname</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($appointments as $appointment): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($appointment['fullname']) ?></td>
                                                <td><?php echo htmlspecialchars($appointment['remarks']) ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- RIGHT COLUMN - Calendar -->
                <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ADD APPOINTMENT</h2>
                        </div>
                        <div class="body">
                            <div id='calendar'></div>
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
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>
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
    <script>
        $(function() {
            $('.js-basic-example').DataTable({
                responsive: true,
                search: false
            });

            $('.js-exportable').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 500,
                events: {
                    url: 'get_all_appointments.php',
                    method: 'GET',
                    failure: function() {
                        alert('Error fetching appointments!');
                    }
                },
                dateClick: function(info) {
                    swal({
                        title: "Add Appointment",
                        content: createCustomForm(info.dateStr),
                        buttons: {
                            cancel: true,
                            confirm: {
                                text: "Save",
                                value: "save",
                                closeModal: false
                            }
                        }
                    }).then((value) => {
                        if (value === "save") {
                            const fullname = document.getElementById('swal-fullname').value;
                            const remarks = document.getElementById('swal-remarks').value;

                            if (!fullname || !remarks) {
                                swal("Error", "Please fill all fields.", "error");
                                return;
                            }

                            const data = {
                                fullname: fullname,
                                remarks: remarks,
                                appointment_datetime: info.dateStr + ' ' + new Date().toTimeString().split(' ')[0]
                            };

                            // Save to PHP
                            $.ajax({
                                url: 'save_appointment.php',
                                method: 'POST',
                                data: data,
                                success: function(response) {
                                    if (response === 'success') {
                                        swal("Saved!", "Appointment has been added.", "success")
                                            .then(() => location.reload());
                                    } else {
                                        swal("Error!", "Something went wrong.", "error");
                                    }
                                }
                            });

                        }
                    });
                },
                eventClick: function(info) {
                    const clickedDate = info.event.startStr;
                    loadAppointments(clickedDate);
                }
            });

            calendar.render();

            function loadAppointments(dateStr) {
                $.ajax({
                    url: 'get_appointments_by_date.php',
                    method: 'POST',
                    data: {
                        date: dateStr
                    },
                    success: function(response) {
                        const appointments = JSON.parse(response);

                        if (appointments.length === 0) {
                            swal("No Appointments", `No appointments found on ${dateStr}.`, "info");
                            return;
                        }

                        let table = `<table style="width:100%; border-collapse: collapse;" border="1">
                <thead>
                    <tr>
                        <th style="padding: 5px;">Fullname</th>
                        <th style="padding: 5px;">Remarks</th>
                        <th style="padding: 5px;">Actions</th>
                    </tr>
                </thead>
                <tbody>`;

                        appointments.forEach(appt => {
                            table += `<tr data-id="${appt.id}">
                    <td style="padding: 5px;">${appt.fullname}</td>
                    <td style="padding: 5px;">${appt.remarks}</td>
                    <td style="padding: 5px;">
                        <button style="background-color: orange; color: white; border: none;" onclick="editAppointment(${appt.id}, '${appt.fullname}', '${appt.remarks}', '${appt.appointment_datetime}')">UPDATE</button>
                        <button style="background-color: red; color: white; border: none;" onclick="deleteAppointment(${appt.id})" style="color: red;">DELETE</button>
                    </td>
                </tr>`;
                        });

                        table += `</tbody></table>`;

                        swal({
                            title: `Appointments on ${dateStr}`,
                            content: $(table)[0],
                            buttons: {
                                confirm: {
                                    text: "Close",
                                    closeModal: true
                                }
                            }
                        });
                    }
                });
            }

            function formatDate(dateStr) {
                const months = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                const dateObj = new Date(dateStr);
                const monthName = months[dateObj.getMonth()];
                const day = dateObj.getDate();
                const year = dateObj.getFullYear();
                return `${monthName} ${day}, ${year}`;
            }

            window.editAppointment = function(id, fullname, remarks, datetime) {
                const wrapper = document.createElement('div');

                const nameInput = document.createElement('input');
                nameInput.setAttribute('id', 'editFullname');
                nameInput.setAttribute('class', 'swal-content__input');
                nameInput.setAttribute('placeholder', 'Fullname');
                nameInput.value = fullname;

                const remarksInput = document.createElement('input');
                remarksInput.setAttribute('id', 'editRemarks');
                remarksInput.setAttribute('class', 'swal-content__input');
                remarksInput.setAttribute('placeholder', 'Remarks');
                remarksInput.value = remarks;

                wrapper.appendChild(nameInput);
                wrapper.appendChild(document.createElement('br'));
                wrapper.appendChild(remarksInput);

                swal({
                    title: "Edit Appointment",
                    content: wrapper,
                    buttons: {
                        cancel: true,
                        confirm: {
                            text: "Update",
                            closeModal: false
                        }
                    }
                }).then((confirm) => {
                    if (confirm) {
                        const updatedName = document.getElementById('editFullname').value.trim();
                        const updatedRemarks = document.getElementById('editRemarks').value.trim();

                        if (!updatedName || !updatedRemarks) {
                            swal("Error", "Please fill in all fields.", "error");
                            return;
                        }

                        console.log("Sending:", {
                            id: id,
                            fullname: updatedName,
                            remarks: updatedRemarks
                        });

                        $.post('update_appointment.php', {
                            id: id,
                            fullname: updatedName,
                            remarks: updatedRemarks
                        }, function(response) {
                            const res = typeof response === 'string' ? JSON.parse(response) : response;

                            if (res.status === 'success') {
                                swal("Updated!", "Appointment successfully updated.", "success")
                                    .then(() => location.reload());
                            } else {
                                swal("Error", res.message || "Failed to update appointment.", "error");
                            }
                        });
                    }
                });
            };


            window.deleteAppointment = function(id) {
                swal({
                    title: "Are you sure?",
                    text: "This appointment will be permanently deleted.",
                    icon: "warning",
                    buttons: ["Cancel", "Delete"],
                    dangerMode: true
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post('delete_appointment.php', {
                            id
                        }, function(response) {
                            if (response === 'success') {
                                swal("Deleted!", "Appointment has been deleted.", "success")
                                    .then(() => location.reload());
                            } else {
                                swal("Error!", "Could not delete appointment.", "error");
                            }
                        }).fail(() => {
                            swal("Error!", "Request failed. Try again.", "error");
                        });
                    }
                });
            };

            function createEditForm(fullname, remarks) {
                const wrapper = document.createElement("div");

                function createRow(labelText, inputElement) {
                    const row = document.createElement("div");
                    row.style.display = "flex";
                    row.style.alignItems = "center";
                    row.style.marginBottom = "15px";

                    const label = document.createElement("label");
                    label.textContent = labelText;
                    label.style.width = "80px";
                    label.style.marginRight = "10px";
                    label.style.textAlign = "right";
                    label.style.fontWeight = "bold";

                    row.appendChild(label);
                    row.appendChild(inputElement);
                    return row;
                }

                const nameInput = document.createElement("input");
                nameInput.setAttribute("id", "edit-fullname");
                nameInput.setAttribute("class", "swal-content__input");
                nameInput.style.flex = "1";
                nameInput.value = fullname;

                const remarksInput = document.createElement("input");
                remarksInput.setAttribute("id", "edit-remarks");
                remarksInput.setAttribute("class", "swal-content__input");
                remarksInput.style.flex = "1";
                remarksInput.value = remarks;

                wrapper.appendChild(createRow("Fullname:", nameInput));
                wrapper.appendChild(createRow("Remarks:", remarksInput));

                return wrapper;
            }


            function createCustomForm(dateStr) {
                const wrapper = document.createElement("div");
                const formattedDate = formatDate(dateStr);

                const dateDisplay = document.createElement("div");
                dateDisplay.textContent = "APPOINTMENT DATE FOR : " + formattedDate;
                dateDisplay.style.fontWeight = "bold";
                dateDisplay.style.marginBottom = "15px";
                wrapper.appendChild(dateDisplay);

                function createRow(labelText, inputElement) {
                    const row = document.createElement("div");
                    row.style.display = "flex";
                    row.style.alignItems = "center";
                    row.style.marginBottom = "15px";

                    const label = document.createElement("label");
                    label.textContent = labelText;
                    label.style.width = "80px";
                    label.style.marginRight = "10px";
                    label.style.textAlign = "right";
                    label.style.fontWeight = "bold";

                    row.appendChild(label);
                    row.appendChild(inputElement);

                    return row;
                }

                const nameInput = document.createElement("input");
                nameInput.setAttribute("id", "swal-fullname");
                nameInput.setAttribute("class", "swal-content__input");
                nameInput.style.flex = "1";

                const remarksInput = document.createElement("input");
                remarksInput.setAttribute("id", "swal-remarks");
                remarksInput.setAttribute("class", "swal-content__input");
                remarksInput.style.flex = "1";

                wrapper.appendChild(createRow("Fullname:", nameInput));
                wrapper.appendChild(createRow("Remarks:", remarksInput));

                return wrapper;
            }
        });
    </script>



    <script>
        function updateDateTime() {
            const options = {
                timeZone: 'Asia/Manila',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };

            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-US', options);
            const formattedDateTime = formatter.format(now);

            document.getElementById('runningDateTime').textContent = formattedDateTime;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
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