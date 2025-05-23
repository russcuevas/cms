$('#add_customer_validation').validate({
    rules: {
        'checkbox': {
            required: true
        },
        'gender': {
            required: true
        },
        'vip': {
            required: function () {
                return $('#vip_select').val() === '1';
            },
            remote: {
                url: 'http://localhost/tpy_clinic/admin/validation/check_vip.php',
                type: 'post',
                data: {
                    vip: function () {
                        return $('input[name="vip"]').val();
                    }
                }
            }
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
    messages: {
        vip: {
            remote: "VIP number already exists"
        }
    }
});