$(document).ready(function () {
    // ADD ADMIN
    $('#add_admin_validation').validate({
        rules: {
            'fullname': { required: true },
            'mobile': { required: true, digits: true },
            'birthday': { required: true, date: true },
            'email': {
                required: true,
                email: true,
                remote: {
                    url: 'http://localhost/tpy_clinic/admin/validation/admin_email.php',
                    type: 'post',
                    data: {
                        email: function () {
                            return $('input[name="email"]').val();
                        }
                    }
                }
            },
            'password': { required: true }
        },
        messages: {
            email: {
                remote: "Email already exists"
            }
        },
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        },
        submitHandler: function (form) {
            $.ajax({
                url: 'http://localhost/tpy_clinic/admin/functions/add_admin.php',
                type: 'POST',
                data: $(form).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }, function () {
                            $('#addAdminModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        swal("Oops...", "Error: " + response.message, "error");
                    }
                },
                error: function () {
                    swal("AJAX Failed", "AJAX request failed. Please try again.", "error");
                }
            });
        }
    });

    // EDIT ADMIN
    $('.edit_admin_validation').each(function () {
        const form = $(this);
        form.validate({
            rules: {
                fullname: { required: true },
                mobile: { required: true, digits: true },
                birthday: { required: true, date: true },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: 'http://localhost/tpy_clinic/admin/validation/admin_email.php',
                        type: 'post',
                        data: {
                            email: function () {
                                return form.find('input[name="email"]').val();
                            },
                            id: function () {
                                return form.find('input[name="id"]').val();
                            }
                        }
                    }
                }
            },
            messages: {
                email: {
                    remote: "Email already exists"
                }
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            },
            submitHandler: function (formEl) {
                $.ajax({
                    url: 'http://localhost/tpy_clinic/admin/functions/edit_admin.php',
                    type: 'POST',
                    data: $(formEl).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }, function () {
                                $('.modal').modal('hide');
                                location.reload();
                            });
                        } else {
                            swal("Error!", response.message, "error");
                        }
                    },
                    error: function () {
                        swal("AJAX Error", "Something went wrong. Please try again.", "error");
                    }
                });
            }
        });
    });

    // DELETE ADMIN
    $('.delete_admin_form').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var modal = form.closest('.modal');

        $.ajax({
            url: 'http://localhost/tpy_clinic/admin/functions/delete_admin.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    modal.modal('hide');
                    swal({
                        title: "Deleted!",
                        text: response.message,
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }, function () {
                        location.reload();
                    });
                } else {
                    swal("Error!", response.message, "error");
                }
            },
            error: function () {
                swal("AJAX Error", "Something went wrong.", "error");
            }
        });
    });
});
