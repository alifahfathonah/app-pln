<script>
    var dataTable = '';
    var baseUrl = '<?= base_url('permohonan_peminjaman_ruangan') ?>';

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
        $('.jq-signature').jqSignature({
            lineWidth: 3,
            width: 650,
            height: 250
        });

        let lengthSignature = $('.jq-signature').length;
        let element = $('[name="signature[]"]');

        for (let i = 0; i < lengthSignature; i++) {
            $('.jq-signature').eq(i).on('jq.signature.changed', function() {
                var dataUrl = $('.jq-signature').eq(i).jqSignature('getDataURL');
                $(element).val(dataUrl);
            });
        }

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
                        'nama_kegiatan': $('#filter-kegiatan').val(),
                        'no_dokumen': $('#filter-no-dokumen').val(),
                        'status_dokumen': $('#filter-status-dokumen').val(),
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
                    'data': 'atasan'
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
            table_data();
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

        // select2 diajukan oleh
        $('#users').select2({
            ajax: {
                url: "<?= base_url('auto/get_auto_atasan') ?>",
                dataType: 'json',
                quietMillis: 100,
                data: function(term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page // page number
                    };
                },
                results: function(data, page) {
                    var more = (page * 20) < data.total; // whether or not there are more results available

                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return {
                        results: data.data,
                        more: more
                    };
                }
            },
            formatResult: function(data) {
                var markup = '<b>' + data.divisi + '</b>' + ' - '+ data.nama;
                return markup;
            },
            formatSelection: function(data) {
                return data.divisi + ' - ' + data.nama;
            }
        });

        // select2 makan siang
        // $('#makan-siang').select2({
        //     ajax: {
        //         url: "<?= base_url('auto/get_auto_makan_siang') ?>",
        //         dataType: 'json',
        //         quietMillis: 100,
        //         data: function(term, page) { // page is the one-based page number tracked by Select2
        //             return {
        //                 q: term, //search term
        //                 page: page // page number
        //             };
        //         },
        //         results: function(data, page) {
        //             var more = (page * 20) < data.total; // whether or not there are more results available

        //             // notice we return the value of more so Select2 knows if more results can be loaded
        //             return {
        //                 results: data.data,
        //                 more: more
        //             };
        //         }
        //     },
        //     formatResult: function(data) {
        //         var markup = data.nama;
        //         return markup;
        //     },
        //     formatSelection: function(data) {
        //         return data.nama;
        //     }
        // });

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
        $('#filter-status-dokumen').val('Menunggu');
    }

    function detail_data(id) {
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
                $('#no-dokumen').val(peminjam.no_dokumen);
                $('#ruangan').val(peminjam.id_ruangan);
                $('#nama-kegiatan').val(peminjam.nama_kegiatan);
                $('#jumlah-orang').val(peminjam.jumlah_orang);
                // $('#makan-siang').val(peminjam.id_makan_siang);
                // $('#s2id_makan-siang a .select2-chosen').html(peminjam.makan_siang);
                // $('#snack').val(peminjam.id_snack);
                // $('#s2id_snack a .select2-chosen').html(peminjam.snack);
                $('#makan-siang').val(peminjam.makan_siang).change();
                
                if ($('#makan-siang').val() === 'Ada') {
                    $('#jumlah-orang-makan-siang').val(peminjam.jumlah_orang_makan_siang);
                }

                $('#snack').val(peminjam.snack).change();
                
                if ($('#snack').val() === 'Ada') {
                    $('#jumlah-orang-snack').val(peminjam.jumlah_orang_snack);
                }

                $('#tgl-start').val(datetimefmysql(peminjam.tgl_start));
                $('#tgl-end').val(datetimefmysql(peminjam.tgl_end));
                $('#keterangan').val(peminjam.keterangan);
                $('#users').val(peminjam.id_users);
                $('#s2id_users a .select2-chosen').html(peminjam.diajukan_oleh);

                if (peminjam.status_dokumen_persetujuan !== 'Menunggu') {
                    $('[name="status_persetujuan[]"]').val(peminjam.status_dokumen_persetujuan);
                    $('[name="status_persetujuan[]"]').attr('disabled', true);
                } else {
                    $('[name="status_persetujuan[]"]').attr('disabled', false);
                }
                
                if (peminjam.keterangan_persetujuan !== null) {
                    $('[name="keterangan_persetujuan[]"]').val(peminjam.keterangan_persetujuan);
                    $('[name="keterangan_persetujuan[]"]').attr('disabled', true);
                } else {
                    $('[name="keterangan_persetujuan[]"]').val('');
                    $('[name="keterangan_persetujuan[]"]').attr('disabled', false);
                }

                if (peminjam.signature !== null) {
                    $('.jq-signature').hide();
                    $('#btn-hapus-signature').hide();
                    $('#signature-img').show();
                    $('#signature-img').attr('src', peminjam.signature);
                    $('#btn-simpan').hide();
                } else {
                    $('.jq-signature').show();
                    $('#btn-hapus-signature').show();
                    $('#btn-simpan').show();
                    $('#signature-img').hide();
                    $('#signature-img').attr('src', '');
                }
              
                $('#modal').modal('show');
                $('#modal-label').html('Form Detail Permohonan Peminjaman Kendaraan');
            },
            error: function(e) {
                swalAlert('error', e.status);
            }

        });
    }

    function hapusSignature(id) {
        $('#signature-' + id).jqSignature('clearCanvas');
        $('#signature-input-' + id).val('');
    }

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
                    // validation('[name="signature"]', 'signature', data);
                } else {
                    if (data.status) {
                        table_data();
                        $('#modal').modal('hide');
                        swalAlert('success', 'Simpan Data', data.message);
                        if (data.telp_pembuat) {
                            window.open('https://api.whatsapp.com/send?phone=62'+ data.telp_pembuat +'&text=Status dokumen peminjaman ruangan anda ' + data.status_dokumen + '',
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

    function send_notif_to_bos(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/get_no_telp_atasan',
            data : {
                id: id
            },   
            dataType: 'JSON',
            success: function(data) {
                if (data.telp_atasan) {
                    window.open('https://api.whatsapp.com/send?phone=62'+ data.telp_atasan +'&text='+ data.nama +' Telah meminjam ruangan',
                                        'newwindow'); 
                } else {
                    swalAlert('error', '404', 'No. Telpon Atasan tidak ditemukan.');
                }
            },
            error: function(e) {
                swalAlert('error', e.status, 'Data tidak ditemukan.');
            }
        });
    }
</script>