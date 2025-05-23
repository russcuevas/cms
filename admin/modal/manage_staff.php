                            <!-- ADD MODAL -->
                            <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="defaultModalLabel">Add Staff</h4>
                                        </div>
                                        <div class="modal-body" style="max-height: 100vh; overflow-y: auto;">
                                            <form id="add_staff_validation" method="POST" style="margin-top:10px;">
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


                            <!-- EDIT MODAL -->
                            <div class="modal fade" id="edit_<?php echo $staff['id']; ?>" tabindex="-1" role="dialog" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="defaultModalLabel">Edit
                                                <?php echo $staff['fullname'] ?>
                                            </h4>
                                        </div>
                                        <div class="modal-body" style="max-height: 100vh; overflow-y: auto;">
                                            <form id="edit_staff_validation_<?php echo $staff['id']; ?>" class="edit_staff_validation" method="POST"
                                                style="margin-top: 10px;">
                                                <input type="hidden" name="id" value="<?php echo $staff['id']; ?>">
                                                <!-- Fullname -->
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="fullname"
                                                            value="<?php echo $staff['fullname'] ?>" required>
                                                        <label class="form-label">Fullname</label>
                                                    </div>
                                                </div>

                                                <!-- Mobile -->
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="number" class="form-control" name="mobile"
                                                            value="<?php echo $staff['mobile'] ?>" required>
                                                        <label class="form-label">Mobile</label>
                                                    </div>
                                                </div>

                                                <!-- Birthday -->
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="date" class="form-control" name="birthday"
                                                            value="<?php echo $staff['birthday'] ?>" required>
                                                        <label class="form-label">Birthday</label>
                                                    </div>
                                                </div>

                                                <!-- Email -->
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" name="email" value="<?php echo $staff['email'] ?>"
                                                            required>
                                                        <label class="form-label">Email</label>
                                                    </div>
                                                </div>

                                                <!-- Footer Buttons -->
                                                <div class="modal-footer">
                                                    <button class="btn bg-teal waves-effect" name="edit_staff_btn" type="submit">SAVE</button>
                                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END EDIT MODAL -->

                            <!-- DELETE MODAL -->
                            <div class="modal fade" id="delete_<?php echo $staff['id']; ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form class="delete_staff_form" method="POST">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $staff['id']; ?>">
                                                <p>Are you sure you want to delete <strong>
                                                        <?php echo htmlspecialchars($staff['fullname']); ?>
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