<script>
    var dataTable = '';
    var baseUrl = '<?= base_url('cabang') ?>';

    function format(data) {
        var status = '';
        if (data.status == 1) {
            status = '<span class="badge badge-success">Aktif</span>';
        } else {
            status = '<span class="badge badge-danger">Tidak Aktif</span>';
        }

        return `<table class="table table-detail">
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="1%">:</td>
                        <td>${data.nama}</td>
                    </tr>
                    <tr>
                        <td>No. Telp</td>
                        <td>:</td>
                        <td>${data.telp}</td>
                    </tr>
                    <tr>
                        <td>Fax</td>
                        <td>:</td>
                        <td>${data.fax}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>${data.email}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>${data.alamat}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>${data.keterangan}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td>` + status + `</td>
                    </tr>
                </table>`;
    }

    $(document).ready(function() {
        dataTable = $('#table-data').DataTable({
            paginationType: 'full_numbers',
            processing: true,
            serverSide: true,
            filter: false,
            autoWidth: false,
            responsive: true,
            // aLengthMenu: [
            //     [10, 10, 25, 50, 100, -1],
            //     [10, 10, 25, 50, 100, "All"]
            // ],
            ajax: {
                url: baseUrl + '/ajax_list',
                type: 'POST',
                data: function(data) {
                    data.filter = {
                        'nama': $('#filter_nama').val(),
                    };
                },
            },
            language: {
                sProcessing: '<img src="<?= base_url() ?>assets/loader/rolling.gif" width="30px"> Mohon menunggu...',
                sLengthMenu: 'Tampilkan _MENU_ entri',
                sZeroRecords: 'Tidak ditemukan data yang sesuai',
                sInfo: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                sInfoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                sInfoFiltered: '(disaring dari _MAX_ entri keseluruhan)',
                sInfoPostFix: '',
                sSearch: 'Cari:',
                sUrl: '',
                oPaginate: {
                    sFirst: '&laquo;',
                    sPrevious: '<',
                    sNext: '>',
                    sLast: '&raquo;'
                }
            },
            order: [2, 'asc'],
            columns: [{
                    'class': 'details-control',
                    'orderable': false,
                    'data': null,
                    'defaultContent': ''
                },
                {
                    'data': 'no',
                    'orderable': false
                },
                {
                    'data': 'nama'
                },
                {
                    'data': 'created_date'
                },
                {
                    'data': 'aksi',
                    'orderable': false
                },
            ],
            "scrollX": true,
            "scrollCollapse": true,
            "fixedColumns": {
                "leftColumns": 0,
                "rightColumns": 1
            },
        });

        // Array to track the ids of the details displayed rows
        var detailRows = [];

        $('#table-data tbody').on('click', 'tr td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = dataTable.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows);

            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice(idx, 1);
            } else {
                tr.addClass('details');
                row.child(format(row.data())).show();

                // Add to the 'open' array
                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }
            }
        });

        // On each draw, loop over 'detailRows' array and show any child rows
        dataTable.on('draw', function() {
            $.each(detailRows, function(i, id) {
                $('#' + id + ' td.details-control').trigger('click');
            });
        });

        // btn tambah
        $('#btn-tambah').on('click', function() {
            reset_data();
            $('#modal').modal('show');
            $('#modal-label').html('Form Tambah Cabang');
        });

        // btn reload
        $('#btn-reload').on('click', function() {
            reset_data();
            table_data();
        });

        // validation remove
        $('.reset-form').keyup(function() {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });
    });


    function table_data() {
        dataTable.ajax.reload(null, true);
    }

    $("#filter_nama").keyup(function() {
        table_data();
    });

    // reset data
    function reset_data() {
        $('#id, .reset-form').val('');
        validation_remove('.reset-form');
    }

    // konfirmasi data
    function konfirmasi_simpan() {
        var title = 'Konfirmasi Simpan';
        var text = 'Apakah anda yakin ingin menyimpan data ini ?';
        var confirmButttonText = 'Simpan';

        if ($('#id').val() !== '') {
            title = 'Konfirmasi Update';
            text = 'Apakah anda yakin ingin mengubah data ini ?';
            confirmButttonText = 'Update';
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: '<i class="fas fa-times-circle mr-2"></i>Batal',
            confirmButtonText: '<i class="fas fa-check-circle mr-2"></i>' + confirmButttonText,
        }).then((result) => {
            if (result.value) {
                simpan_data();
            }
        })
    }

    function simpan_data() {
        var url = '/ajax_post';

        if ($('#id').val() !== '') {
            url = '/ajax_put';
        }

        $.ajax({
            type: 'POST',
            url: baseUrl + url,
            cache: false,
            data: $('#form-cabang').serialize(),
            dataType: 'JSON',
            beforeSend: function() {

            },
            success: function(data) {
                if (data.validasi === false) {
                    validation('#nama', 'nama', data);
                    validation('#telp', 'telp', data);
                    validation('#fax', 'fax', data);
                    validation('#email', 'email', data);
                } else {
                    if (data.status) {
                        table_data();
                        $('#modal').modal('hide');
                        swalAlert('success', 'Simpan Data', data.message);
                    } else {
                        swalAlert('error', 'Simpan Data', data.message);
                    }
                }

            },
            complete: function() {

            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal menyimpan data.');
            }
        });
    }

    function ubah_data(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/ajax_data_id',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(data) {
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#telp').val(data.telp);
                $('#fax').val(data.fax);
                $('#email').val(data.email);
                $('#alamat').val(data.alamat);
                $('#keterangan').val(data.keterangan);

                if (data.is_head_office == 1) {
                    $('#head-office').val(data.is_head_office);
                    $('#head-office').attr('checked', true);
                } else {
                    $('#head-office').removeAttr('checked');
                }

                if (data.status == 1) {
                    $('#status').val(data.status);
                    $('#status').attr('checked', true);
                } else {
                    $('#status').removeAttr('checked');
                }

                if (data.logo != '') {
                    $('#prev-logo').attr('src', '<?= base_url() ?>assets/upload/' + data.logo);
                    $('#nama-logo').val(data.logo);
                } else {
                    $('#prev-logo').attr('src', '<?= base_url() ?>assets/images/image-upload.png');
                    $('#nama-logo').val('');
                }

                $('#modal').modal('show');
                $('#modal-label').html('Form Ubah Cabang');
            },
            error: function(e) {
                swalAlert('error', e.status);
            }

        });
    }

    function hapus_data(id) {
        Swal.fire({
            title: 'Hapus Data',
            text: "Apakah anda yakin ingin menghapus data ini ?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: '<i class="fas fa-times-circle mr-2"></i>Batal',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Hapus'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'GET',
                    url: baseUrl + '/ajax_delete',
                    data: {
                        id: id
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status) {
                            table_data();
                            swalAlert('success', 'Hapus Data', 'Berhasil menghapus data.');
                        } else {
                            swalAlert('error', 'Hapus Data', 'Gagal menghapus data.');
                        }
                    },
                    error: function(e) {
                        swalAlert('error', e.status, 'Gagal menghapus data.');
                    }

                });
            }
        })
    }

    function upload_logo() {
        let fileImage = $('#logo').prop('files')[0];
        // Validasi ukuran file
        if (fileImage.size > 1000000) {
            Swal.fire({
                icon: 'warning',
                title: 'Information',
                text: 'File yang diunggah terlalu besar ! | Maximal gambar 1 MB',
                showConfirmButton: true,
                // timer: 1500
            });

            $('#logo').val('');
        } else {
            // Proses upload file
            let data = new FormData();
            data.append('logo', fileImage);
            // console.log(fileImage); return false
            $.ajax({
                type: 'POST',
                url: baseUrl + '/ajax_upload',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status === false) {
                        swalAlert('error', 'Information', data.error);
                        $('#logo').val();
                        $('#nama-logo').val();
                    } else {
                        delete_image_old('#nama-logo');

                        let url_image = '<?= base_url() ?>/assets/upload/' + data.file_name;
                        $('#prev-logo').attr('src', url_image);
                        $('#nama-logo').val(data.file_name);
                        // swalAlert('success', 'Information', data.success);
                    }
                },
                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal mengunggah logo',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }
    }

    function delete_image_old(param) {
        let file_tmp = $(param).val();
        $.ajax({
            type: 'POST',
            url: baseUrl + '/ajax_delete_image_old',
            data: {
                file_tmp: file_tmp
            },
            dataType: 'JSON',
            success: function(data) {
                // swalAlert('success', 'Information', 'Image lama telah terhapus!');
            },
            error: function(e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menghapus logo',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        })
    }
</script>