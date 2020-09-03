<script>
    $(function() {
        $('.form-control').keyup(function() {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

        $('#password, #captcha').keypress(function() {
            if (event.keyCode === 13) {
                login();
            } 
        });
    });

    function login() {
        if ($('#account').val() === '') {
            validation_live('#account', 'Kolom username atau email harus diisi.');
            return false;
        }

        if ($('#password').val() === '') {
            validation_live('#password', 'Kolom password harus diisi.');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?= base_url('auth/login') ?>',
            data: $('#form-login').serialize(),
            cache: false,
            dataType: 'JSON',
            success: function(data) {
                if (data.status) {
                    swalAlert('success', 'Login Berhasil', data.message);

                    if(data.url_absen) {
                        setTimeout("location.reload(), location.replace('" + data.url_absen + "')", 1500);
                    } else {
                        setTimeout("location.reload(), location.replace('<?= base_url('/') ?>')", 1500);
                    }
                } else {
                    swalCustom('error', 'Information Alert', data.message);
                    $('#password').val('');
                    $('#captcha').val('');
                }
            },
            error: function(e) {
                swalAlert('error', e.status, e.statusText);
            }
        });
    }
</script>