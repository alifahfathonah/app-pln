<script>
    var dataTable = '';
    var baseUrl = '<?= base_url('frontend/atk/') ?>';

    $(function() {
        $("#tanggal").datetimepicker({
            format: "dd/mm/yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "top-left",
            minDate: 0, 
            startDate: new Date(),
            minuteStep: 10
        });

        $('#btn-tambah').click(function() {
            reset_data();
            get_barang();
            $('#table-atk tbody').empty();
            $('#modal-form').modal('show');
            $('#modal-form-label').html('Form Tambah ATK');
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

        // Data Table

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
                url: baseUrl + 'ajax_list',
                type: 'POST',
                data: function(data) {
                    data.filter = {
                        'no_notadinas': $('#filter-no-notadinas').val(),
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
                { 'data': 'tanggal' },
                { 'data': 'no_notadinas' },
                { 'data': 'users' },
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
       
        $("#filter-no-notadinas").keyup(function() {
            table_data();
        });

        // end datatable 
    });

    // row detail datatable
    function format(data) {
        return ``;
    }

    function table_data() {
        dataTable.ajax.reload(null, true);
    }

    function reset_data() {
        $('.validasi-input, #id').val('');
    }

    function get_barang(id = null) {
        $.ajax({
            url: '<?= base_url('auto/get_barang') ?>',
            type: 'GET',
            cache: false,
            dataType: 'JSON',
            success: function(data) {
                let html = '';
                html += '<option value="">- Pilih Barang -</option>';
                $.each(data, function(i, v) {
                    html += '<option value="' + v.id + '">' + v.nama + '</option>';
                });

                $('#barang').html(html);
                
                if (id) {
                    $('#barang').val(id);
                    fill_satuan(id);
                }
            },
            error: function(e) {
                accessFailed(e.status);
            }
        });
    }
    
    function fill_satuan(id) {
        $.ajax({
            url: '<?= base_url('auto/get_barang_by_id') ?>',
            type: 'GET',
            data: {
                id: id,
            },
            cache: false,
            dataType: 'JSON',
            success: function(data) {
                $('#satuan-request, #satuan-approval').val(data.satuan);
            },
            error: function(e) {
                accessFailed(e.status);
            }
        });
    }

    function add_barang() 
    {
        if ($('#barang').val() === '') {
            swalAlert('error', 'Validation', 'Kolom barang harus dipilih');
            return false;
        }

        if ($('#qty-request').val() === '') {
            validation_live('#qty-request', 'Kolom qty request harus diisi.');
            return false;
        }

        if ($('#qty-approval').val() === '') {
            validation_live('#qty-approval', 'Kolom qty approval harus diisi.');
            return false;
        }

        let html = '';
        let number = $('.number-atk').length;
        let noNotaDinas = $('#no-notadinas').val();
        let tanggal = $('#tanggal').val();
        let idUsers = $('#id-users').val();
        let idBarang = $('#barang').val();
        let barang = $('#select2-barang-container').text();
        let qtyRequest = $('#qty-request').val();
        let qtyApproval = $('#qty-approval').val();
        let satuanRequest = $('#satuan-request').val();
        let satuanApproval = $('#satuan-approval').val();
        
        html = /* html */ `
            <tr>
                <td class="number-atk" class="center"></td>
                <td><input type="hidden" name="id_barang[]" value="${idBarang}">${barang}</td>
                <td class="center"><input type="hidden" name="qty_req[]" value="${qtyRequest}">${qtyRequest}</td>
                <td class="center"><input type="hidden" name="satuan-req[]">${satuanRequest}</td>
                <td class="center"><input type="hidden" name="qty_appv[]" value="${qtyApproval}">${qtyApproval}</td>
                <td class="center"><input type="hidden" name="satuan-appv[]">${satuanApproval}</td>
                <td class="right">
                    <button type="button" class="btn btn-shadow btn-light btn-xs" onclick="removeList(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;

        $('#table-atk tbody').append(html);
        
        $('#barang').val('');
        $('#select2-barang-container').html('- Pilih Barang -');
        $('#qty-request').val('');
        $('#qty-approval').val('');
        $('#satuan-request').val('');
        $('#satuan-approval').val('');
    }

    function removeList(el) {
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
    }

    function konfirmasi_simpan() {
        if ($('#no-notadinas').val() === '') {
            validation_live('#no-notadinas', 'Kolom nomor nota dinas harus diisi.');
            return false;
        }

        Swal.fire({
            title: 'Simpan Data',
            text: 'Apakah anda yakin ingin menyimpan data ini ?',
            icon: 'question',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: '<i class="fas fa-times-circle mr-2"></i>Batal',
            confirmButtonText: '<i class="fas fa-check-circle mr-2"></i> Simpan',
        }).then((result) => {
            if (result.value) {
                simpan_data();
            }
        })

    }

    function simpan_data() {
        $.ajax({
            type: 'POST',
            url: baseUrl + 'ajax_post',
            data: $('#form-atk').serialize(),
            cache: false,
            dataType: 'JSON',
            success: function(data) {
                if (data.status) {
                    table_data();
                    reset_data();
                    $('#modal-form').modal('hide');
                    swalAlert('success', 'Simpan Data', data.message);
                } else {
                    swalAlert('error', 'Simpan Data', data.message);
                }
            },
            error: function(e) {
                swalAlert('error', e.status, 'Gagal menyimpan data.');
            }
        })
    }

    function detail_data(id) {
        $.ajax({
            type: 'GET',
            url: baseUrl + 'ajax_data_id',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(data) {
                var atk = data.atk;

                $('#no-notadinas-detail').val(atk.no_notadinas);
                $('#tanggal-detail').val(atk.tanggal);
                $('#users-detail').val(atk.users);

                $('#table-atk-detail tbody').empty();
                $.each(data.komponen, function(i, v) {
                    let html = /* html */ `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${v.barang}</td>
                            <td>${v.qty_request}</td>
                            <td>${v.satuan}</td>
                            <td>${v.qty_approval}</td>
                            <td>${v.satuan}</td>
                            <td></td>
                        </tr>
                    `;

                    $('#table-atk-detail tbody').append(html);
                });

                $('#modal-detail').modal('show');
                $('#modal-detail-label').html('Detail ATK');
            },
            error: function(e) {
                swalAlert('error', e.status);
            }

        });
    }
</script>