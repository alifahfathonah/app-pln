<!-- Modal Form-->
<div class="modal fade" id="modal-form" data-backdrop="static" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=form-ceklis-kendaraan') ?>
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label>No. Plat</label>
                    <?= form_dropdown('no_plat', $kendaraan, array(), 'id=no-plat class="form-control select2 validasi-input"') ?>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <!-- <div class="form-group">
                    <label>Type Kendaraan</label>
                    <?= form_dropdown('type_kendaraan', $jenis_kendaraan, array(), 'id=type-kendaraan class="form-control select2 validasi-input"') ?>
                    <em class="help-block error invalid-feedback"></em>
                </div> -->
                <div class="form-group">
                    <label>Tanggal</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control validasi-input" name="tanggal" id="tanggal">
                        <em class="help-block error invalid-feedback"></em>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kondisi</label><br>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="kondisi" id="kondisi-terima" value="1" checked>
                        <label class="form-check-label" for="kondisi-terima">Terima</label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="kondisi" id="kondisi-pengembalian" value="2">
                        <label class="form-check-label" for="kondisi-pengembalian">Pengembalian</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <img src="<?= base_url('assets/images/komponen-mobil.png') ?>"
                            class="img-fluid mx-auto d-block">
                    </div>
                    <div class="col-lg-9">
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-striped table-hover">
                                <thead class="thead-darkblue">
                                    <tr class="text-center">
                                        <th>Baik</th>
                                        <th>Rusak</th>
                                        <th>Tidak Tersedia</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($komponen as $key => $list): ?>
                                    <tr class="text-center">
                                        <td><input type="radio" name="cek[<?= $key?>]" value="1" checked></td>
                                        <td><input type="radio" name="cek[<?= $key?>]" value="2"></td>
                                        <td><input type="radio" name="cek[<?= $key?>]" value="3"></td>
                                        <td align="left"><?= $list->nama ?></td>
                                        <input type="hidden" name="komponen[]" value="<?= $list->id ?>">
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea class="form-control validasi-input" name="catatan" id="catatan" rows="4"></textarea>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-window-close mr-2"></i>Keluar
                </button>
                <button type="button" onclick="konfirmasi_simpan()" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail-->
<div class="modal fade" id="modal-detail" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-detail-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>No. Plat</label>
                    <input type="text" class="form-control validasi-input" name="no_plat" id="no-plat-detail" disabled>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <!-- <div class="form-group">
                    <label>Type Kendaraan</label>
                    <input type="text" class="form-control validasi-input" name="type_kendaraan" id="type-kendaraan-detail" disabled>
                    <em class="help-block error invalid-feedback"></em>
                </div> -->
                <div class="form-group">
                    <label>Tanggal</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control validasi-input" name="tanggal" id="tanggal-detail" disabled>
                        <em class="help-block error invalid-feedback"></em>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kondisi</label><br>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="kondisi" id="kondisi-terima-detail" value="1">
                        <label class="form-check-label" for="kondisi-terima-detail">Terima</label>
                    </div>
                    <div class="form-check-inline">
                        <input class="form-check-input" type="radio" name="kondisi" id="kondisi-pengembalian-detail" value="2">
                        <label class="form-check-label" for="kondisi-pengembalian-detail">Pengembalian</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <img src="<?= base_url('assets/images/komponen-mobil.png') ?>"
                            class="img-fluid mx-auto d-block">
                    </div>
                    <div class="col-lg-9">
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-striped table-hover" id="table-komponen">
                                <thead class="thead-darkblue">
                                    <tr class="text-center">
                                        <th>Baik</th>
                                        <th>Rusak</th>
                                        <th>Tidak Tersedia</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($komponen as $key => $list): ?>
                                    <tr class="text-center">
                                        <td><span id="cek-baik-<?= $key?>"></span></td>
                                        <td><span id="cek-rusak-<?= $key?>"></span></td>
                                        <td><span id="cek-tidak-tersedia-<?= $key?>"></span></td>
                                        <td align="left"><?= $list->nama ?></td>
                                        <input type="hidden" name="komponen[]" value="<?= $list->id ?>">
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea class="form-control validasi-input" name="catatan" id="catatan-detail" rows="4" disabled></textarea>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-window-close mr-2"></i>Keluar
                </button>
            </div>
        </div>
    </div>
</div>