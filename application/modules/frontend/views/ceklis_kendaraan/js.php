<script>
    var dataTable = '';
    var baseUrl = '<?= base_url("frontend/ceklis_kendaraan") ?>';

    $(function () {
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
                        'no_plat': $('#filter-no-plat').val(),
                        'kondisi': $('#filter-kondisi').val(),
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
                { 'data': 'no_plat' },
                { 'data': 'kondisi' },
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
       
        $("#filter-no-plat").keyup(function() {
            table_data();
        });

        $("#filter-kondisi").change(function() {
            table_data();
        });
       
        // end datatable 

        $('#btn-tambah').click(function() {
            reset_data();
            $('#modal-form').modal('show');
            $('#modal-form-label').html('Form Tambah Ceklis Kendaraan');
        });

        $('#btn-reload').click(function() {
            table_data();
            reset_data();
        });

        $("#tanggal").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            startDate: new Date(),
            daysOfWeekHighlighted: "6,0",
            todayHighlight: true,
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
                        <td width="15%">No Plat</td>
                        <td width="1%">:</td>
                        <td>${data.no_plat}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>${data.tanggal}</td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>:</td>
                        <td>${data.catatan}</td>
                    </tr>
                </table>`;
    }

    function table_data() {
        dataTable.ajax.reload(null, true);
    }

    function reset_data() {
        $('.validasi-input, #id').val();
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

    // simpan data
    function simpan_data() {
        $.ajax({
            type: 'POST',
            url: baseUrl + '/ajax_post',
            data: $('#form-ceklis-kendaraan').serialize(),
            cache: false,
            dataType: 'JSON',
            success: function(data) {
                if (data.validasi === false) {
                    validation('#no-plat', 'no_plat', data);
                    validation('#tanggal', 'tanggal', data);
                } else {
                    if (data.status) {
                        table_data();
                        $('#modal-form').modal('hide');
                        swalAlert('success', 'Simpan Data', data.message);
                    } else {
                        swalAlert('error', 'Simpan Data', data.message);
                    }
                }
            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal menyimpan data.');
            }
        })
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

    function detail_data(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/ajax_data_id',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(data) {
                var ceklis = data.ceklis;

                $('#no-plat-detail').val(ceklis.no_plat);
                $('#tanggal-detail').val(datefmysql(ceklis.tanggal));
                $('#catatan-detail').val(ceklis.catatan);
                
                if (ceklis.kondisi === '1') {
                    $('#kondisi-terima-detail').val(ceklis.kondisi);
                    $('#kondisi-terima-detail').attr('checked', true);
                } else if (ceklis.kondisi === '2') {
                    $('#kondisi-pengembalian-detail').val(ceklis.kondisi);
                    $('#kondisi-pengembalian-detail').attr('checked', true);
                }

                $.each(data.komponen, function(i, v) {
                    $('#cek-baik-' + i).html('');
                    $('#cek-rusak-' + i).html('');
                    $('#cek-tidak-tersedia-' + i).html('');

                    if (v.cek == '1') {
                        $('#cek-baik-' + i).html('&checkmark;');
                    } else if (v.cek == '2') {
                        $('#cek-rusak-' + i).html('&checkmark;');
                    } else if (v.cek == '3') {
                        $('#cek-tidak-tersedia-' + i).html('&checkmark;');
                    }
                });
              
                $('#modal-detail').modal('show');
                $('#modal-detail-label').html('Detail Ceklis Kendaraan');
            },
            error: function(e) {
                swalAlert('error', e.status);
            }

        });
    }
</script>