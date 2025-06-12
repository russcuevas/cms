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