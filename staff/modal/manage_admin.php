<!-- EDIT MODAL -->
<div class="modal fade" id="edit_<?php echo $admin['id']; ?>" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Edit
                    <?php echo $admin['fullname'] ?>
                </h4>
            </div>
            <div class="modal-body" style="max-height: 100vh; overflow-y: auto;">
                <form id="edit_admin_validation_<?php echo $admin['id']; ?>" class="edit_admin_validation" method="POST"
                    style="margin-top: 10px;">
                    <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
                    <!-- Fullname -->
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="fullname"
                                value="<?php echo $admin['fullname'] ?>" required>
                            <label class="form-label">Fullname</label>
                        </div>
                    </div>

                    <!-- Mobile -->
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" class="form-control" name="mobile"
                                value="<?php echo $admin['mobile'] ?>" required>
                            <label class="form-label">Mobile</label>
                        </div>
                    </div>

                    <!-- Birthday -->
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="date" class="form-control" name="birthday"
                                value="<?php echo $admin['birthday'] ?>" required>
                            <label class="form-label">Birthday</label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" value="<?php echo $admin['email'] ?>"
                                required>
                            <label class="form-label">Email</label>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="modal-footer">
                        <button class="btn bg-teal waves-effect" name="edit_admin_btn" type="submit">SAVE</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END EDIT MODAL -->

<!-- DELETE MODAL -->
<div class="modal fade" id="delete_<?php echo $admin['id']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="delete_admin_form" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
                    <p>Are you sure you want to delete <strong>
                            <?php echo htmlspecialchars($admin['fullname']); ?>
                        </strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-red">Yes, Delete</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END DELETE MODAL -->