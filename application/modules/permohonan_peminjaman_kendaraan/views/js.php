<script>
    var dataTable = '';
    var baseUrl = '<?= base_url('permohonan_peminjaman_kendaraan') ?>';
    var informationKendaraan = '';
    var informationDriver = '';
    var pesanWA = 'Selamat Permohonan Peminjaman Kendaraan Anda telah disetujui.';

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
                        'nama': $('#filter-nama').val(),
                        'status_dokumen': $('#status-dokumen').val(),
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
            order: [1, 'asc'],
            columns: [{
                    'data': 'no',
                    'orderable': false
                },
                {
                    'data': 'no_dokumen'
                },
                {
                    'data': 'kendaraan'
                },
                {
                    'data': 'tujuan'
                },
                {
                    'data': 'diajukan_oleh'
                },
                {
                    'data': 'created_date'
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
                "rightColumns": 2
            },
        });

        // btn tambah
        $('#btn-tambah').on('click', function() {
            reset_data();
            tambah_input_personil();
            $('#modal').modal('show');
            $('#modal-label').html('Form Tambah Peminjaman Kendaraan');
        });

        // btn reload
        $('#btn-reload').on('click', function() {
            reset_data();
            table_data();
        });

        // validation remove
        $('.reset-form, .form-control').keyup(function() {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

        // validation remove
        $('.select2-input, .form-control').change(function() {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

        // select2 kendaraan
        $('#kendaraan').select2({
            ajax: {
                url: "<?= base_url('auto/get_auto_kendaraan') ?>",
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
                var markup = '<b>' + data.nopol + '</b> - ' + data.nama;
                return markup;
            },
            formatSelection: function(data) {
                informationKendaraan = `
                    <img src="<?= base_url() ?>assets/upload/${data.foto}" alt="thumbnail" class="img-thumbnail rounded mx-auto d-block">
                    <div class="form-group mt-2">
                        <label>NOPOL</label><br>
                        <b>${data.nopol}</b>
                    </div>
                    <div class="form-group">
                        <label>NAMA / MERK</label><br>
                        <b>${data.nama}</b>
                    </div>
                    <div class="form-group">
                        <label>JENIS KENDARAAN</label><br>
                        <b>${data.jenis_kendaraan}</b>
                    </div>
                    <div class="form-group">
                        <label>KAPASITAS (ORANG)</label><br>
                        <b>${data.kapasitas}</b>
                    </div>
                    <div class="form-group">
                        <label>TGL. DIBUAT</label><br>
                        <b>${data.created_date}</b>
                    </div>
                    <div class="form-group">
                        <label>DIBUAT OLEH</label><br>
                        <b>${data.created_by}</b>
                    </div>
                `;

                $('#detail-kendaraan').html(informationKendaraan);
                return data.nopol + ' - ' + data.nama;
            }
        });

        // select2 kendaraan
        $('#driver').select2({
            ajax: {
                url: "<?= base_url('auto/get_auto_driver') ?>",
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
                var markup = data.nama + ' | <b>' + data.divisi + '</b>';
                return markup;
            },
            formatSelection: function(data) {
                var foto = '';

                if (data.foto) {
                    foto = '<img src="<?= base_url() ?>assets/upload/'+data.foto+'" alt="thumbnail" class="img-thumbnail rounded mx-auto d-block">';
                } else {
                    foto = '<img src="<?= base_url() ?>assets/upload/driver.png" alt="thumbnail" class="img-thumbnail rounded mx-auto d-block">'
                }

                informationDriver = `
                    ${foto}
                    <div class="form-group mt-2">
                        <label>NAMA LENGKAP</label><br>
                        <b>${data.nama}</b>
                    </div>
                    <div class="form-group">
                        <label>DIVISI</label><br>
                        <b>${data.divisi}</b>
                    </div>
                    <div class="form-group">
                        <label>KONTAK</label><br>
                        <b>${data.telp_wa}</b>
                    </div>
                    <div class="form-group">
                        <label>TGL. TERDAFTAR</label><br>
                        <b>${data.created_date}</b>
                    </div>
                `;

                $('#detail-driver').html(informationDriver);
                return data.nama + ' | ' + data.divisi;
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

        // use driver change
        $('.driver').show();
        $('#is-use-driver').attr('checked', true);
        $('#is-use-driver').change(function() {
            $('#is-use-driver').each(function() {
                let val = this.type == "checkbox" ? + this.checked : this.value;
                $('#is-use-driver').val(val);
            });

            if ($('#is-use-driver').val() > 0) {
                $('.driver').show();
            } else {
                $('.driver').hide();
                $('#driver').val('');
            }
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
    });

    function table_data() {
        dataTable.ajax.reload(null, true);
    }

    $("#filter-nama").keyup(function() {
        table_data();
    });

    $("#status-dokumen").change(function() {
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
            data: $('#form-peminjaman-kendaraan').serialize(),
            dataType: 'JSON',
            success: function(data) {
                if (data.validasi === false) {
                    validation_select2('#kendaraan', 'kendaraan', data);
                    validation_select2('#driver', 'driver', data);
                    
                    for (let n = 0; n < $('.baris-1').length; n++) {
                        if ($('#nama-personil' + n).val() === '') {
                            validation('#nama-personil' + n, 'nama_personil[]', data);
                            validation('#nama-divisi-personil' + n, 'nama_divisi_personil[]', data);
                            validation('#nama-jabatan-personil' + n, 'nama_jabatan_personil[]', data);
                            validation('#no-telp-personil' + n, 'no_telp_personil[]', data);
                        }
                    }
                } else {
                    if (data.status) {
                        table_data();
                        $('#modal').modal('hide');
                        swalAlert('success', 'Simpan Data', data.message);
                        
                        if (data.traveladmin.telp_wa !== '0') {
                            window.open('https://api.whatsapp.com/send?phone=62'+ data.traveladmin.telp_wa +'&text=Ada permohonan peminjaman kendaraan baru', 'newwindow'); 
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
                $('#tujuan, #keterangan, #tgl-start, #tgl-end').attr('disabled', true);
                
                if (peminjam.id_kendaraan !== null) {
                    $('#kendaraan').val(peminjam.id_kendaraan);
                    $('#s2id_kendaraan').html('<input class="form-control" disabled="disabled" value="'+ peminjam.kendaraan +'">');
                }

                if (peminjam.voucher !== null) {
                    $('#voucher').val(peminjam.voucher);
                    $('#voucher').attr('readonly', true);
                }

                if (peminjam.id_driver !== null) {
                    $('#driver').val(peminjam.id_driver);
                    $('#s2id_driver').html('<input class="form-control" disabled="disabled" value="'+ peminjam.driver +'">');
                }

                $('#tujuan').val(peminjam.tujuan);
                $('#keterangan').val(peminjam.keterangan);
                $('#tgl-start').val(datetimefmysql(peminjam.tgl_start_peminjaman));
                $('#tgl-end').val(datetimefmysql(peminjam.tgl_end_peminjaman));
                $('#s2id_users').html('<input class="form-control" disabled="disabled" value="'+ peminjam.diajukan_oleh +'">');

                if (peminjam.status_dokumen_persetujuan !== 'Menunggu') {
                    $('[name="status_persetujuan[]"]').val(peminjam.status_dokumen_persetujuan);
                    $('[name="status_persetujuan[]"]').attr('disabled', true);
                }
                
                if (peminjam.keterangan_persetujuan !== null) {
                    $('[name="keterangan_persetujuan[]"]').val(peminjam.keterangan_persetujuan);
                    $('[name="keterangan_persetujuan[]"]').attr('disabled', true);
                }

                if (peminjam.signature !== null) {
                    $('.jq-signature').hide();
                    $('#btn-hapus-signature').hide();
                    $('#signature-img').attr('src', peminjam.signature);
                    $('#btn-simpan').hide();
                }

                $('.persetujuan').show();

                // Kendaraan
                informationKendaraan = `
                    <img src="<?= base_url() ?>assets/upload/${(peminjam.foto_kendaraan !== null) ? peminjam.foto_kendaraan : 'mobil.png'}" alt="thumbnail" class="img-thumbnail rounded mx-auto d-block">
                    <div class="form-group mt-2">
                        <label>NOPOL</label><br>
                        <b>${(peminjam.nopol !== null) ? peminjam.nopol : 'N/A'}</b>
                    </div>
                    <div class="form-group">
                        <label>NAMA / MERK</label><br>
                        <b>${(peminjam.kendaraan !== null) ? peminjam.kendaraan : 'N/A'}</b>
                    </div>
                    <div class="form-group">
                        <label>JENIS KENDARAAN</label><br>
                        <b>${(peminjam.jenis_kendaraan !== null) ? peminjam.jenis_kendaraan : 'N/A'}</b>
                    </div>
                    <div class="form-group">
                        <label>KAPASITAS (ORANG)</label><br>
                        <b>${(peminjam.kapasitas !== null) ? peminjam.kapasitas : 'N/A'}</b>
                    </div>
                    <div class="form-group">
                        <label>TGL. DIBUAT</label><br>
                        <b>${(peminjam.tgl_dibuat_kendaraan !== null) ? peminjam.tgl_dibuat_kendaraan : 'N/A'}</b>
                    </div>
                    <div class="form-group">
                        <label>DIBUAT OLEH</label><br>
                        <b>${(peminjam.dibuat_oleh_kendaraan !== null) ? peminjam.dibuat_oleh_kendaraan : 'N/A'}</b>
                    </div>
                `;

                $('#detail-kendaraan').html(informationKendaraan);

                // Driver
                var foto = '';

                if (peminjam.foto) {
                    foto = '<img src="<?= base_url() ?>assets/upload/'+peminjam.foto+'" alt="thumbnail" class="img-thumbnail rounded mx-auto d-block">';
                } else {
                    foto = '<img src="<?= base_url() ?>assets/upload/driver.png" alt="thumbnail" class="img-thumbnail rounded mx-auto d-block">'
                }

                informationDriver = `
                    ${foto}
                    <div class="form-group mt-2">
                        <label>NAMA LENGKAP</label><br>
                        <b>${(peminjam.nama !== null) ? peminjam.nama : 'N/A'}</b>
                    </div>
                    <div class="form-group">
                        <label>DIVISI</label><br>
                        <b>${(peminjam.divisi !== null) ? peminjam.divisi : 'N/A'}</b>
                    </div>
                    <div class="form-group">
                        <label>KONTAK</label><br>
                        <b>${(peminjam.telp !== null) ? peminjam.telp : 'N/A'}</b>
                    </div>
                    <div class="form-group">
                        <label>TGL. TERDAFTAR</label><br>
                        <b>${(peminjam.created_date !== null) ? peminjam.created_date : 'N/A'}</b>
                    </div>
                `;

                $('#detail-driver').html(informationDriver);

                $('#load-content-personil').empty();
                $.each(data.personil, function(i, v) {
                    tambah_input_personil();
                    $(`#nama-personil${i}, #nama-divisi-personil${i}, #nama-jabatan-personil${i}, #no-telp-personil${i}`).attr('readonly', true);
                    $('#nama-personil' + i).val(v.nama);
                    $('#nama-divisi-personil' + i).val(v.divisi);
                    $('#nama-jabatan-personil' + i).val(v.jabatan);
                    $('#no-telp-personil' + i).val(v.telp);
                    $('#btn-hapus-personil').hide();
                });

                $('#modal').modal('show');
                $('#modal-label').html('Form Ubah Peminjaman Kendaraan');
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

    // function tambah personil
    function tambah_input_personil() {
        var i = $('.baris-1').length;
        var html = `
                <div class="baris-1 row mt-2 mb-3">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Nama Lengkap</label><br>
                            <input type="text" class="form-control reset-form" name="nama_personil[]" onkeyup="return validation_remove(this)" id="nama-personil${i}">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>PT / Divisi / Bagian</label><br>
                            <input type="text" class="form-control reset-form" name="nama_divisi_personil[]" onkeyup="return validation_remove(this)" id="nama-divisi-personil${i}">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Jabatan</label><br>
                            <input type="text" class="form-control reset-form" name="nama_jabatan_personil[]" onkeyup="return validation_remove(this)" id="nama-jabatan-personil${i}">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>No. Telp</label><br>
                            <input type="text" class="form-control reset-form" name="no_telp_personil[]" onkeyup="return validation_remove(this)" onkeypress="return hanyaAngka(this)" id="no-telp-personil${i}">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="col-lg-1">`
                        if (i !== 0) {
                            html += `<button id="btn-hapus-personil" onclick="hapus_row_personil(this)" class="btn btn-danger"><i class="fas fa-trash"></i></button>`
                        }
                    `</div>
                </div>`;
        $('#load-content-personil').append(html);
    }

    function hapus_row_personil(el) {
        var element = el.parentNode.parentNode;
        element.parentNode.removeChild(element);
        
        var i = 0;
        for (var n = 0; n < $('.baris-1').length; n++) {
            $('.baris-1:eq(' + i +')').children('div:eq(0)').children('div').children('input').attr('id','nama-personil' + n);
            $('.baris-1:eq(' + i +')').children('div:eq(1)').children('div').children('input').attr('id','divisi-personil' + n);
            $('.baris-1:eq(' + i +')').children('div:eq(2)').children('div').children('input').attr('id','jabatan-personil' + n);
            $('.baris-1:eq(' + i +')').children('div:eq(3)').children('div').children('input').attr('id','no-telp-personil' + n);
            $('.baris-1:eq(' + i +')').children('div:eq(4)').children('div').children('select').attr('id','filter-divisi-personil' + n);
            i++
        }
    }
    
    function hapusSignature(id) {
        $('#signature-' + id).jqSignature('clearCanvas');
        $('#signature-input-' + id).val('');
    }

    function send_notif_to_pemohon(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/get_data_pemohon',
            data: 'id=' + id,
            dataType: 'JSON',
            success: function(data) {
                var pesan = `Selamat Permohonan Peminjaman Kendaraan Anda telah disetujui. *Driver :* ${data.nama_driver} | *No. Telp :* ${data.telp_wa} | *Kendaraan :* ${data.kendaraan}`;
                window.open('https://api.whatsapp.com/send?phone=62'+ data.telp_pemohon +'&text=' + pesan + '', 'newwindow'); 
            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal mengirim notifikasi.');
            }
        })
    }

    function send_notif_to_traveladmin(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/get_data_traveladmin',
            data: 'id=' + id,
            dataType: 'JSON',
            success: function(data) {
                if (data.telp_wa == '0') {
                    swalAlert('error', '404', 'Nomor Telpon Travel Admin Tidak Ditemukan.');
                } else {
                    var pesan = ``;
                    window.open('https://api.whatsapp.com/send?phone=62'+ data.telp_wa +'&text=' + pesan + 'Ada permohonan peminjaman kendaraan baru', 'newwindow'); 
                }
            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal mengirim notifikasi.');
            }
        })
    }

    function send_notif_to_bos(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/get_data_pemohon',
            data: 'id=' + id,
            dataType: 'JSON',
            success: function(data) {
                var pesan = `Selamat Permohonan Peminjaman Kendaraan Anda telah disetujui. *Driver :* ${data.nama_driver} | *No. Telp :* ${data.telp_wa} | *Kendaraan :* ${data.kendaraan}`;
                window.open('https://api.whatsapp.com/send?phone=62'+ data.telp_atasan +'&text=' + pesan + '', 'newwindow'); 
            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal mengirim notifikasi.');
            }
        })
    }

    function send_notif_to_driver(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/get_data_driver',
            data: 'id=' + id,
            dataType: 'JSON',
            success: function(data) {
                var pesan =  `<?= base_url('booking/kendaraan') ?>`;
                window.open('https://api.whatsapp.com/send?phone=62'+ data.telp_wa +'&text=' + pesan + '', 'newwindow'); 
            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal mengirim notifikasi.');
            }
        })
    }
</script>