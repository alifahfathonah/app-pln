<script>
    var baseUrl = '<?= base_url('persetujuan') ?>';
    $(function() {
        $.ajax({
            type: 'GET',
            url: baseUrl + '/get_list_data_persetujuan_kendaraan',
            cache: false,
            dataType: 'JSON',
            success: function (data) {
                
                $.each(data, function(i, v) {
                    tambah_input_peminjaman_kendaraan();
                    if (v.tipe_dokumen == 'kendaraan') {
                        $('#label-kendaraan' + i).val(v.label);
                        $('#filter-divisi-kendaraan' + i).val(v.filter_divisi);

                        var id_divisi = v.id_divisi;
                        var id_users = v.id_users;
                        if (v.filter_divisi == 1) {
                            get_divisi(i, '#divisi-kendaraan', '#label-name-divisi-kendaraan', id_divisi);
                            get_users(i, '#users-kendaraan', id_users);
                        } else {
                            get_kategori_divisi(i, '#divisi-kendaraan', '#label-name-divisi-kendaraan', id_divisi);
                            get_users(i, '#users-kendaraan', id_users);
                        }
       
                        $('#kondisi-persetujuan-kendaraan' + i).val(v.tipe_approval);
                    }
                });
            },
            error: function (e) {
                swalAlert('error', e.status, e.statusText);
            }
        });

        $.ajax({
            type: 'GET',
            url: baseUrl + '/get_list_data_persetujuan_ruangan',
            cache: false,
            dataType: 'JSON',
            success: function (data) {
                $.each(data, function(i, v) {
                    tambah_input_peminjaman_ruangan();
                    if (v.tipe_dokumen == 'ruangan') {
                        $('#label-ruangan' + i).val(v.label);
                        $('#filter-divisi-ruangan' + i).val(v.filter_divisi);

                        var id_divisi = v.id_divisi;
                        var id_users = v.id_users;
                        if (v.filter_divisi == 1) {
                            get_divisi(i, '#divisi-ruangan', '#label-name-divisi-ruangan', id_divisi);
                            get_users(i, '#users-ruangan', id_users);
                        } else {
                            get_kategori_divisi(i, '#divisi-ruangan', '#label-name-divisi-ruangan', id_divisi);
                            get_users(i, '#users-ruangan', id_users);
                        }
       
                        $('#kondisi-persetujuan-ruangan' + i).val(v.tipe_approval);
                    }
                });
            },
            error: function (e) {
                swalAlert('error', e.status, e.statusText);
            }
        });

        $('.validasi-input').keyup(function () {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

        $('.validasi-input').change(function () {
            if ($(this).val() !== '') {
                validation_remove(this);
            }
        });

    });

    function tambah_input_peminjaman_kendaraan() {
        var i = $('.baris-1').length;
        var html = `<div class="baris-1 row mb-4" id="setting-peminjaman-kendaraan">
                        <input type="hidden" name="document_type_kendaraan" value="kendaraan" id="document-type-kendaraan${i}">
                        <div class="col-lg-11">
                            <div class="form-group">
                                <label>Label (Optional)</label>
                                <input type="text" name="label_kendaraan[]" class="form-control label validasi-input" id="label-kendaraan${i}">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Filter Divisi</label>
                                <select class="form-control validasi-input" onchange="get_opsi(${i}, this.value, 'kendaraan')" id="filter-divisi-kendaraan${i}" name="filter_divisi_kendaraan[]">
                                    <option value="">- Semua -</option>
                                    <option value="1">Nama Divisi</option>
                                    <option value="2">Kategori Divisi</option>
                                </select>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label id="label-name-divisi-kendaraan${i}">Nama Divisi</label>
                                <select name="divisi_kendaraan[]" class="form-control validasi-input" id="divisi-kendaraan${i}">
                                    <option value="">- Semua -</option>
                                </select>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Nama User</label>
                                <select name="users_kendaraan[]" class="form-control validasi-input" id="users-kendaraan${i}">
                                    <option value="">- Semua -</option>
                                </select>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Kondisi Persetujuan</label>
                                <select class="form-control validasi-input" id="kondisi-persetujuan-kendaraan${i}" name="kondisi_persetujuan_kendaraan[]">
                                    <option value="">- Pilih -</option>
                                    <option value="wajib">Wajib</option>
                                    <option value="optional">Optional</option>
                                </select>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-1">`
                            if (i !== 0) {
                                html += `<button id="btn-hapus-setting-peminjaman-kendaraan" onclick="hapus_row_peminjaman_kendaraan(this)" class="btn btn-danger"><i class="fas fa-trash"></i></button>`
                            }
                        `</div>
                        <hr>
                    </div>`;
        $('#load-content-peminjaman-kendaraan').append(html);
    }

    function tambah_input_peminjaman_ruangan() {
        var i = $('.baris-2').length;
        var html = `<div class="baris-2 row mb-4" id="setting-peminjaman-ruangan">
                        <input type="hidden" name="document_type_ruangan" value="ruangan" id="document-type-ruangan${i}">
                        <div class="col-lg-11">
                            <div class="form-group">
                                <label>Label (Optional)</label>
                                <input type="text" name="label_ruangan[]" class="form-control label validasi-input" id="label-ruangan${i}">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group validasi-input">
                                <label>Filter Divisi</label>
                                <select class="form-control" onchange="get_opsi(${i}, this.value, 'ruangan')" id="filter-divisi-ruangan${i}" name="filter_divisi_ruangan[]">
                                    <option value="">- Semua -</option>
                                    <option value="1">Nama Divisi</option>
                                    <option value="2">Kategori Divisi</option>
                                </select>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label id="label-name-divisi-ruangan${i}">Nama Divisi</label>
                                <select name="divisi_ruangan[]" class="form-control validasi-input" id="divisi-ruangan${i}">
                                    <option value="">- Semua -</option>
                                </select>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Nama User</label>
                                <select name="users_ruangan[]" class="form-control validasi-input" id="users-ruangan${i}">
                                    <option value="">- Semua -</option>
                                </select>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Kondisi Persetujuan</label>
                                <select class="form-control validasi-input" id="kondisi-persetujuan-ruangan${i}" name="kondisi_persetujuan_ruangan[]">
                                    <option value="">- Pilih -</option>
                                    <option value="wajib">Wajib</option>
                                    <option value="optional">Optional</option>
                                </select>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="col-lg-1">`
                            if (i !== 0) {
                                html += `<button id="btn-hapus-setting-peminjaman-ruangan" onclick="hapus_row_peminjaman_ruangan(this)" class="btn btn-danger"><i class="fas fa-trash"></i></button>`
                            }
                        `</div>
                        <hr>
                    </div>`;
        $('#load-content-peminjaman-ruangan').append(html);
    }

    function get_opsi(n, value, el) {
        if (value === '1') {
            if (el === 'kendaraan') {
                get_divisi(n, '#divisi-kendaraan', '#label-name-divisi-kendaraan');
                get_users(n, '#users-kendaraan');
            } else if (el === 'ruangan') {
                get_divisi(n, '#divisi-ruangan', '#label-name-divisi-ruangan');
                get_users(n, '#users-ruangan');
            }
        }
        if (value === '2') {
            if (el === 'kendaraan') {
                get_kategori_divisi(n, '#divisi-kendaraan', '#label-name-divisi-kendaraan');
                get_users(n, '#users-kendaraan');
            } else if (el === 'ruangan') {
                get_kategori_divisi(n, '#divisi-ruangan', '#label-name-divisi-ruangan');
                get_users(n, '#users-ruangan');
            }
        }
    }

    function hapus_row_peminjaman_kendaraan(el) {
        var element = el.parentNode.parentNode;
        element.parentNode.removeChild(element);
        
        var i = 0;
        for (var n = 0; n < $('.baris-1').length; n++) {
            $('.baris-1:eq(' + i +')').children('div:eq(0)').children('div').children('input').attr('id','label-kendaraan' + n);
            $('.baris-1:eq(' + i +')').children('div:eq(1)').children('div').children('select').attr('id','filter-divisi-kendaraan' + n);
            $('.baris-1:eq(' + i +')').children('div:eq(1)').children('div').children('select').attr('onchange','get_opsi('+n+', this.value, kendaraan)');
            $('.baris-1:eq(' + i +')').children('div:eq(2)').children('div').children('select').attr('id','divisi-kendaraan' + n);
            $('.baris-1:eq(' + i +')').children('div:eq(3)').children('div').children('select').attr('id','users-kendaraan' + n);
            $('.baris-1:eq(' + i +')').children('div:eq(4)').children('div').children('select').attr('id','kondisi-persetujuan-kendaraan' + n);
            i++
        }
    }

    function hapus_row_peminjaman_ruangan(el) {
        var element = el.parentNode.parentNode;
        element.parentNode.removeChild(element);
        
        var i = 0;
        for (var n = 0; n < $('.baris-2').length; n++) {
            $('.baris-2:eq(' + i +')').children('div:eq(0)').children('div').children('input').attr('id','label-ruangan' + n);
            $('.baris-2:eq(' + i +')').children('div:eq(1)').children('div').children('select').attr('id','filter-divisi-ruangan' + n);
            $('.baris-2:eq(' + i +')').children('div:eq(1)').children('div').children('select').attr('onchange','get_opsi('+n+', this.value, ruangan)');
            $('.baris-2:eq(' + i +')').children('div:eq(2)').children('div').children('select').attr('id','divisi-ruangan' + n);
            $('.baris-2:eq(' + i +')').children('div:eq(3)').children('div').children('select').attr('id','users-ruangan' + n);
            $('.baris-2:eq(' + i +')').children('div:eq(4)').children('div').children('select').attr('id','kondisi-persetujuan-ruangan' + n);
            i++
        }
    }

    function get_divisi(n, el, lab, val) {
        $.ajax({
            url: baseUrl + '/get_data_select_divisi',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                let html = '';
                html += '<option value="">- Semua -</option>';
                $.each(data, function(i, v) {
                    html += '<option value="' + v.id + '">' + v.nama + '</option>';
                });

                $(lab + n).html('Nama Divisi');
                $(el + n).html(html);
                
                if (val) {
                    $(el + n).val(val);
                }
            },
            error: function(e) {
                swalAlert('error', e.status, e.statusText);
            }
        });
    }

    function get_kategori_divisi(n, el, lab, val) {
        $.ajax({
            url: baseUrl + '/get_data_select_kategori_divisi',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                let html = '';
                html += '<option value="">- Semua -</option>';
                $.each(data, function(i, v) {
                    html += '<option value="' + v.id + '">' + v.nama + '</option>';
                });

                $(lab + n).html('Kategori Divisi');
                $(el + n).html(html);

                if (val) {
                    $(el + n).val(val);
                }
            },
            error: function(e) {
                swalAlert('error', e.status, e.statusText);
            }
        });
    }

    function get_users(n, el, val) {
        $.ajax({
            url: baseUrl + '/get_data_select_users',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                let html = '';
                html += '<option value="">- Semua -</option>';
                $.each(data, function(i, v) {
                    html += '<option value="' + v.id + '">' + v.nama + ' - ' + v.divisi + '</option>';
                });

                $(el + n).html(html);
                
                if (val) {
                    $(el + n).val(val);
                }
            },
            error: function(e) {
                swalAlert('error', e.status, e.statusText);
            }
        });
    }

    function simpan_data()
    {
        if ($('#kondisi-persetujuan-kendaraan0').val() !== 'wajib') {
            swalCustom('error', 'Information Alert', 'Setiap Dokumen harus memiliki minimal 1 User dengan kondisi persetujuan Wajib.');
            return false;
        }

        if ($('#kondisi-persetujuan-ruangan0').val() !== 'wajib') {
            swalCustom('error', 'Information Alert', 'Setiap Dokumen harus memiliki minimal 1 User dengan kondisi persetujuan Wajib.');
            return false;
        }

        if ($('#label-kendaraan0').val() == '') {
            validation_live('#label-kendaraan0', 'Kolom label kendaraan harus diisi.');
            validation_live('#filter-divisi-kendaraan0', 'Kolom filter divisi kendaraan harus dipilih.');
            validation_live('#divisi-kendaraan0', 'Kolom divisi kendaraan harus dipilih.');
            validation_live('#users-kendaraan0', 'Kolom users kendaraan harus dipilih.');
            return false;
            
        }
        
        if ($('#label-ruangan0').val() == '') {
            validation_live('#label-ruangan0', 'Kolom label ruangan harus diisi.');
            validation_live('#filter-divisi-ruangan0', 'Kolom filter divisi ruangan harus dipilih.');
            validation_live('#divisi-ruangan0', 'Kolom divisi ruangan harus dipilih.');
            validation_live('#users-ruangan0', 'Kolom users ruangan harus dipilih.');
            return false;

        }

        Swal.fire({
            title: 'Simpan Data',
            text: "Apakah anda yakin ingin menyimpan data ini ?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: '<i class="fas fa-times-circle mr-2"></i>Batal',
            confirmButtonText: '<i class="fas fa-save mr-2"></i>Simpan'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: baseUrl + '/simpan_setting_persetujuan',
                    cache: false,
                    data: $('#form-setting-persetujuan').serialize(),
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status) {
                            swalAlert('success', 'Setting Persetujuan', data.message);
                        } else {
                            swalAlert('error', 'Setting Persetujuan', data.message);
                        }
                    },
                    error: function(e){
                        swalAlert('error', e.status, e.statusText);
                    }
                })
            }
        })
    }
</script>