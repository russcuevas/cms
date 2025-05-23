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
                <form id="sign_in" method="POST">
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
</body>

</html>