<script>
    var dataTable = '';
    var baseUrl = '<?= base_url('frontend/ruangan') ?>';

    function format(data) {
        return `<table class="table table-detail">
                    <tr>
                        <td width="15%">No Dokumen</td>
                        <td width="1%">:</td>
                        <td>${data.no_dokumen}</td>
                    </tr>
                    <tr>
                        <td>Ruangan</td>
                        <td>:</td>
                        <td>${data.ruangan}</td>
                    </tr>
                    <tr>
                        <td>Nama Kegiatan</td>
                        <td>:</td>
                        <td>${data.nama_kegiatan}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>${data.keterangan}</td>
                    </tr>
                    <tr>
                        <td>Diajukan Oleh</td>
                        <td>:</td>
                        <td>${data.diajukan_oleh}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Peminjaman</td>
                        <td>:</td>
                        <td>${data.tgl_start} - ${data.tgl_end}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Dibuat</td>
                        <td>:</td>
                        <td>${data.created_date}</td>
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
            lengthChange: false,
            ajax: {
                url: baseUrl + '/ajax_list',
                type: 'POST',
                data: function(data) {
                    data.filter = {
                        'nama_kegiatan': $('#filter-kegiatan').val(),
                        'no_dokumen': $('#filter-no-dokumen').val(),
                        'status_dokumen': $('#filter-status-dokumen').val(),
                    };
                },
            },
            language: {
                sProcessing: '<img src="<?= base_url() ?>assets/loader/rolling.gif" width="30px"> Mohon menunggu...',
                sLengthMenu: 'Tampilkan _MENU_ entri',
                sZeroRecords: 'Data tidak ditemukan',
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
                    'data': 'no_dokumen'
                },
                {
                    'data': 'ruangan'
                },
                {
                    'data': 'nama_kegiatan'
                },
                {
                    'data': 'status'
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
            $('#modal-label').html('Form Tambah Peminjaman Ruangan');
        });

        // btn reload
        $('#btn-reload').on('click', function() {
            reset_data();
            location.reload();
        });

        // validation remove
        $('.reset-form').keyup(function() {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

        $('.reset-form').change(function() {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

        $('.select2').change(function() {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

        $('.select2').select2({
            theme: 'bootstrap4',
            width: 'style',
            placeholder: $(this).attr('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        // datetimepicker
        $("#tgl-start, #tgl-end").datetimepicker({
            format: "dd/mm/yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "top-left",
            minDate: 0, 
            startDate: new Date(),
            minuteStep: 10
        });

        // makan siang change
        $('.makan-siang_').hide();
        $('#makan-siang').change(function() {
            if ($(this).val() === 'Ada') {
                $('.makan-siang_').show();
            } else {
                $('.makan-siang_').hide();
                $('#jumlah-orang-makan-siang').val('');
            }
        });

        // makan-siang change
        $('.makan-siang_').hide();
        $('#makan-siang').change(function() {
            if ($(this).val() === 'Ada') {
                $('.makan-siang_').show();
            } else {
                $('.makan-siang_').hide();
                $('#jumlah-orang-makan-siang').val('');
            }
        });

        // snack change
        $('.snack_').hide();
        $('#snack').change(function() {
            if ($(this).val() === 'Ada') {
                $('.snack_').show();
            } else {
                $('.snack_').hide();
                $('#jumlah-orang-snack').val('');
            }
        });

        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 300,
            height: 300,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        $('#btn-generate-qrcode').click(function() {
            let id = $('#id_').val();
            qrcode.makeCode('<?= base_url("absen_hadir/ruangan/") ?>' + id);
        }); 

        $('#btn-ubah-status').click(function() {
            let id = $('#id_').val();
            let status = $('#status-dokumen_').val();
            ubah_status(id, status);
        }); 

        $('#btn-download').click(function() {
            let id = $('#id_').val();
            window.open(
                '<?= base_url("frontend/ruangan/download_data_absensi/") ?>' + id,
                '_blank' // <- This is what makes it open in a new window.
            );
        });
    });


    function table_data() {
        dataTable.ajax.reload(null, true);
    }

    $("#filter-kegiatan").keyup(function() {
        table_data();
    });

    $("#filter-no-dokumen").keyup(function() {
        table_data();
    });

    $("#filter-status-dokumen").change(function() {
        table_data();
    });

    // reset data
    function reset_data() {
        $('#id, .reset-form').val('');
        validation_remove('.reset-form');
        $('#tgl-start, #tgl-end').val('<?= date('d/m/Y H:i'); ?>');
        $('#makan-siang').val('');
        $('#s2id_makan-siang a .select2-chosen').html('');
        $('#snack').val('');
        $('#s2id_snack a .select2-chosen').html('');
        $('#users').val('');
        $('#s2id_users a .select2-chosen').html('');
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
        if ($('#tgl-start').val() === $('#tgl-end').val() || $('#tgl-start').val() >= $('#tgl-end').val()) {
            validation_live('#tgl-start', 'Periode Tgl. Peminjaman tidak valid');
            validation_live('#tgl-end', 'Periode Tgl. Peminjaman tidak valid');
            return false;
        }

        var url = '/ajax_post';

        if ($('#id').val() !== '') {
            url = '/ajax_put';
        }
        $.ajax({
            type: 'POST',
            url: baseUrl + url,
            cache: false,
            data: $('#form-peminjaman-ruangan').serialize(),
            dataType: 'JSON',
            success: function(data) {
                if (data.validasi === false) {
                    validation('#ruangan', 'ruangan', data);
                    validation('#nama-kegiatan', 'nama_kegiatan', data);
                    // validation_select('#makan-siang', 'makan_siang', data);
                    // validation_select('#snack', 'snack', data);
                    validation_select('#users', 'users', data);
                } else {
                    if (data.status) {
                        table_data();
                        $('#modal').modal('hide');
                        swalAlert('success', 'Simpan Data', data.message);

                        if (data.telp_spv) {
                            window.open('https://api.whatsapp.com/send?phone=62'+ data.telp_spv +'&text=' + data.pesan_wa + '',
                                        'newwindow'); 
                        }
                    } else {
                        swalAlert('error', 'Simpan Data', data.message);
                    }
                }

            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal menyimpan data.');
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

    function ubah_data(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/ajax_data_id',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(data) {
                var peminjam = data.peminjam;
                $('#id').val(peminjam.id);
                $('#ruangan').val(peminjam.id_ruangan);
                $('#nama-kegiatan').val(peminjam.nama_kegiatan);
                $('#jumlah-orang').val(peminjam.jumlah_orang);
                $('#makan-siang').val(peminjam.makan_siang).change();
                $('#snack').val(peminjam.snack).change();
                
                if ($('#makan-siang').val() === 'Ada') {
                    $('#jumlah-orang-makan-siang').val(peminjam.jumlah_orang_makan_siang);
                }

                if ($('#snack').val() === 'Ada') {
                    $('#jumlah-orang-snack').val(peminjam.jumlah_orang_snack);
                }

                $('#tgl-start').val(datetimefmysql(peminjam.tgl_start));
                $('#tgl-end').val(datetimefmysql(peminjam.tgl_end));
                $('#keterangan').val(peminjam.keterangan);
                $('#users').val(peminjam.id_users).change();
              
                $('#modal').modal('show');
                $('#modal-label').html('Form Ubah Peminjaman Kendaraan');
            },
            error: function(e) {
                swalAlert('error', e.status);
            }

        });
    }

    function daftar_hadir(id)
    {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/ajax_data_id',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(data) {
                var peminjam = data.peminjam;
                $('#id_').val(peminjam.id);
                $('#pic').text(peminjam.diajukan_oleh);
                $('#nama-ruangan').text(peminjam.ruangan);
                $('#kegiatan').text(peminjam.nama_kegiatan);
                $('#no-dokumen').text(peminjam.no_dokumen);
                $('#tgl-pemakaian').text(datetimefmysql(peminjam.tgl_start) + ' s/d ' + datetimefmysql(peminjam.tgl_end));
                
                if (peminjam.status_dokumen === 'Disetujui') {
                    $('#status-kegiatan').text('Berlangsung');
                    $('#status-dokumen_').val(peminjam.status_dokumen);
                    $('.btn-qrcode').show();
                    $('.btn-checkout').show();
                } else if (peminjam.status_dokumen === 'Selesai') {
                    $('#status-kegiatan').text('Selesai');
                    $('.btn-qrcode').hide();
                    $('.btn-checkout').hide();
                }


                $('#modal-attendances').modal('show');
                $('#modal-attendances-label').html('Daftar Hadir Ruangan');
            },
            error: function(e) {
                swalAlert('error', e.status);
            }

        });
    }

    function ubah_status(id, status) {
        Swal.fire({
            title: 'Konfirmasi Checkout',
            text: 'Apakah anda ingin menutup acara di ruangan ini ?',
            icon: 'question',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: '<i class="fas fa-times-circle mr-2"></i>Batal',
            confirmButtonText: '<i class="fas fa-check-circle mr-2"></i>Proses',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: baseUrl + '/ubah_status',
                    data: {
                        id: id,
                        status: status
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status) {
                            table_data();
                            $('#modal-attendances').modal('hide');
                            swalAlert('success', 'Update Status', data.message);
                        } else {
                            swalAlert('error', 'Update Status', data.message);
                        }
                    },
                    error: function(e) {
                        swalAlert('error', e.status);
                    }

                });
            }
        });
    }
    
</script>