<script>
    var dataTable = '';
    var baseUrl = '<?= base_url("frontend/buku_tamu") ?>';

    $(function() {
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
                        'nama': $('#filter-nama').val(),
                        'unit': $('#filter-unit').val(),
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
            columns: [
                {
                    'class': 'details-control',
                    'orderable': false,
                    'data': null,
                    'defaultContent': ''
                },
                { 'data': 'no', 'orderable': false },
                { 'data': 'nama' },
                { 'data': 'unit' },
                { 'data': 'aksi', 'orderable': false },
            ],
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
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
       
        $("#filter-nama").keyup(function() {
            table_data();
        });

        $("#filter-unit").keyup(function() {
            table_data();
        });

        // end datatable 

        $('#btn-tambah').click(function() {
            reset_data();
            $('#modal-form').modal('show');
            $('#modal-form-label').html('Form Tambah Buku Tamu');
        });

        $('#btn-reload').click(function() {
            table_data();
            reset_data();
            location.reload();
        });

        // remove validation
        $('.validasi-input').keyup(function() {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

        $('.validasi-input').change(function() {
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
    });

    // row detail datatable
    function format(data) {
        return `<table class="table table-detail">
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="1%">:</td>
                        <td>${data.nama}</td>
                    </tr>
                    <tr>
                        <td>Unit</td>
                        <td>:</td>
                        <td>${data.unit}</td>
                    </tr>
                    <tr>
                        <td>No. Identitas</td>
                        <td>:</td>
                        <td>${data.no_identitas}</td>
                    </tr>
                    <tr>
                        <td>No. Polisi</td>
                        <td>:</td>
                        <td>${data.no_polisi}</td>
                    </tr>
                    <tr>
                        <td>Bertemu Dengan</td>
                        <td>:</td>
                        <td>${data.bertemu_dengan}</td>
                    </tr>
                    <tr>
                        <td>Keperluan</td>
                        <td>:</td>
                        <td>${data.keperluan}</td>
                    </tr>
                    <tr>
                        <td>Petugas Masuk</td>
                        <td>:</td>
                        <td>${data.petugas_masuk}</td>
                    </tr>
                    <tr>
                        <td>Petugas Keluar</td>
                        <td>:</td>
                        <td>${data.petugas_keluar}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kunjungan</td>
                        <td>:</td>
                        <td>${data.tanggal_kunjungan}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Keluar</td>
                        <td>:</td>
                        <td>${data.tanggal_keluar}</td>
                    </tr>
                </table>`;
    }

    function table_data() {
        dataTable.ajax.reload(null, true);
    }

    function reset_data() {
        $('.validasi-input, #id').val();
    }

    async function konfirmasi_simpan() {
        let stop = false;

        if ($('#nama').val() === '') {
            validation_live('#nama', 'Kolom nama harus diisi.');
            stop = true;
        }

        if ($('#atasan').val() === '') {
            validation_select_live('#atasan', 'Kolom atasan harus dipilih.');
            stop = true;
        }

        if ($('#keperluan').val() === '') {
            validation_live('#keperluan', 'Kolom keperluan harus diisi.');
            stop = true;
        }
        
        if ($('#petugas').val() === '') {
            validation_select_live('#petugas', 'Kolom petugas harus dipilih.');
            stop = true;
        }

        if (stop) {
            return false;
        }

        if ($('#id').val() === '') {
            let term = `
                <ol style="text-align:justify; margin:5px;">
                    <li>Mentaati Peraturan Daily Service UID Banten yang berlaku dan telah ditetapkan</li>
                    <li>Mengikuti seluruh instruksi dan arahan petugas</li>
                    <li>Mengisi buku tamu, menyimpan tanda pengenal dan mengenakan kartu visitor</li>
                    <li>Mengenali jalur evakuasi, titik kumpul, rambu daily service UID banten, penempatan APAR dan pintu keluar yang ada disekitar anda. Apabila terdengar tanda bahaya harap mengikuti arahan petugas dengan tenang sesuai prosedur tanggap darurat yang telah ditetapkan.</li>
                </ol>
            `;
            const { value: accept } = await Swal.fire({
                title: 'Syarat dan Ketentuan - DSUIDB',
                html: term,
                input: 'checkbox',
                inputValue: 1,
                inputPlaceholder: 'Saya dengan ini menyetujui syarat dan ketentuan',
                showCancelButton: true,
                cancelButtonText: '<i class="fas fa-times-circle mr-2"></i>Batal',
                confirmButtonText: 'Continue<i class="fas fa-arrow-right ml-2"></i>',
                inputValidator: (result) => {
                    return !result && 'Anda belum menyetujui syarat dan ketentuan'
                }
            })
    
            if (accept) {
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
        } else {
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
            data: $('#form-buku-tamu').serialize(),
            dataType: 'JSON',
            success: function(data) {
                if (data.validasi === false) {
                    validation('#nama', 'nama', data);
                    validation('#keperluan', 'keperluan', data);
                    validation_select('#atasan', 'atasan', data);
                    validation_select('#petugas', 'petugas', data);
                    
                } else {
                    if (data.status) {
                        table_data();
                        $('#modal-form').modal('hide');
                        swalAlert('success', 'Simpan Data', data.message);

                        if (data.telp_atasan) {
                            window.open('https://api.whatsapp.com/send?phone=62'+ data.telp_atasan +'&text=' + data.pesan_wa + '', 'newwindow'); 
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
    
    function edit_data(id) {
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
                $('#unit').val(data.unit);
                $('#no-identitas').val(data.no_identitas);
                $('#no-polisi').val(data.no_polisi);
                $('#atasan').val(data.id_atasan).change();
                $('#keperluan').val(data.keperluan);
                $('#petugas').val(data.id_petugas_masuk).change();

                $('#modal-form').modal('show');
                $('#modal-form-label').html('Form Edit Buku Tamu');
            },
            error: function(e) {
                swalAlert('error', e.status);
            }

        });
    }

    function status_keluar(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/ajax_data_id',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(data) {
                $('#id-detail').val(data.id);
                $('#nama-detail').val(data.nama);
                $('#unit-detail').val(data.unit);
                
                $('#modal-status-keluar').modal('show');
                $('#modal-status-keluar-label').html('Form Update Status Keluar Buku Tamu');
            },
            error: function(e) {
                swalAlert('error', e.status);
            }

        });
    }

    function simpan_status_keluar() {
        if ($('#petugas-detail').val() === '') {
            validation_select_live('#petugas-detail', 'Kolom petugas keluar harus dipilih.');
            return false;
        } 

        var url = '/update_status_keluar';

        if ($('#id-detail').val() !== '') {
            url = '/update_status_keluar';
        }
        $.ajax({
            type: 'POST',
            url: baseUrl + url,
            cache: false,
            data: $('#form-status-keluar').serialize(),
            dataType: 'JSON',
            success: function(data) {
                if (data.status) {
                    table_data();
                    $('#modal-status-keluar').modal('hide');
                    swalAlert('success', 'Simpan Data', data.message);
                } else {
                    swalAlert('error', 'Simpan Data', data.message);
                }
            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal mengubah data.');
            }
        });
    }
</script>