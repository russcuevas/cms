<aside id="rightsidebar" class="right-sidebar">
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#account" data-toggle="tab">ACCOUNT</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active in active" id="account">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 548px;">
                <ul class="account-settings" style="overflow: hidden; width: auto; height: 548px;">
                    <li style="display: flex; align-items: center;" data-toggle="modal" data-target="#changePassModal">
                        <div>
                            <label class="mb-0 hov-pointer">
                                <i class="material-icons mr-2" style="font-size: 18px; vertical-align: middle;">lock</i> Change Password
                            </label>
                        </div>
                    </li>

                    <li onclick="window.location.href=('logout.php');" style="display: flex; align-items: center;">
                        <div>
                            <label class=" mb-0 hov-pointer">
                                <i class="material-icons mr-2" style="font-size:18px; vertical-align: middle;">exit_to_app</i>
                                Log Out
                            </label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
<!-- CHANGE PASSWORD EXECUTE -->
<?php
if (isset($_POST['change_password_btn'])) { // Check if the 'change_password_btn' is set
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if the passwords match
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = sha1($new_password);

            // Get the admin's ID from the session
            $admin_id = $_SESSION['admin_id'];

            // Prepare the SQL query to update the password
            $query = "UPDATE tbl_admin SET password = :password WHERE id = :admin_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $_SESSION['success'] = "Password successfully updated!";
            } else {
                // Error during update
                $_SESSION['errors'] = "There was an error updating the password.";
            }
        } else {
            // Passwords don't match
            $_SESSION['errors'] = "The passwords do not match!";
        }
    } else {
        // One or both password fields are empty
        $_SESSION['errors'] = "Please fill in both the new password and confirm password fields.";
    }
}
?>


<div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Change Password</h4>
            </div>
            <div class="modal-body">
                <form id="form_advanced_validation" method="POST" style="margin-top:10px;">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" class="form-control" name="new_password" maxlength="10" minlength="3" required>
                            <label class="form-label">New Password</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" class="form-control" name="confirm_password" maxlength="10" minlength="3" required>
                            <label class="form-label">Confirm Password</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn bg-teal waves-effect" name="change_password_btn" type="submit">SAVE</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>