<script type="text/javascript">
    var baseUrl = '<?= base_url() ?>';

    $(function() {
        set_awal();

        $('#old_password').keyup(function() {
            var lama = $(this).val();
            var user = $('#id').val();

            $.ajax({
                type: 'POST',
                url: baseUrl + '/users/check_password',
                data: 'username=' + user + '&password=' + lama,
                cache: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        $('#new_password').removeAttr('disabled');
                        $('#message').html(' Enter your new password');
                        $('#new_password').focus();
                    } else {
                        set_awal();
                    }
                }
            });
        });

        $('#new_password').keyup(function() {
            if ($(this).val() !== '') {
                $('#password_konf').removeAttr('disabled');
            } else {
                $('#password_konf').attr('disabled', 'disabled');
            }
        });

        $('#new_password').blur(function() {
            if ($(this).val() !== '') {
                $('#password_konf').removeAttr('disabled');
                $('#message').html(' Re-type your new password');
            } else {
                $('#password_konf').attr('disabled', 'disabled');
                $('#message').html(' Enter your new password first!');
            }

        });

        $('#password_konf').keyup(function() {
            var konf = $(this).val();
            var baru = $('#new_password').val();

            if (konf === baru) {
                $('#btnChange').removeAttr('disabled');
                $('#message').html(' Please save your new password');
            } else {
                $('#btnChange').attr('disabled', 'disabled');
                $('#message').html(' Confirmation of the new password is not appropriate');
            }
        });

        $('#btnChange').click(function() {
            Swal.fire({
                title: 'Confirm Change Password',
                text: "Are you sure you want to change this password ?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                cancelButtonText: '<i class="fas fa-times-circle mr-2"></i>Batal',
                confirmButtonText: '<i class="fas fa-check-circle mr-2"></i>Yakin'
            }).then((result) => {
                if (result.value) {
                    changePassword();
                }
            })
        });

    });

    function changePassword() {
        $.ajax({
            type: 'POST',
            url: baseUrl + '/users/simpan_password',
            data: $('#form-change-password').serialize(),
            cache: false,
            dataType: 'JSON',
            success: function(data) {
                if (data.status == true) {
                    swalAlert('success', 'Information Alert', 'Ganti password berhasil', );
                    reset();

                    setTimeout("window.location.href = '" + baseUrl + "/auth/logout';", 1500);
                } else {
                    swalAlert('success', 'Information Alert', 'Ganti password gagal', );
                }
            }
        });
    }

    function set_awal() {
        $('#message').html(' Enter your old password');
        $('#password_konf, #new_password, #btnChange').attr('disabled', 'disabled');
    }

    function reset() {
        $('#password_konf, #new_password, #old_password, #id').val('');
        set_awal();
        $('#old_password').focus();
    }
</script>