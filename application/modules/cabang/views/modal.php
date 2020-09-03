<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'class="form-horizontal" id="form-cabang"') ?>
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-lg-8">
                        <h6><b>Informasi Dasar</b></h6>
                        <hr>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control reset-form" name="nama" id="nama">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Telp <small>(Optional)</small></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control reset-form" maxlength="14" name="telp" id="telp" onkeypress="return hanyaAngka(event)">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Fax <small>(Optional)</small></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control reset-form" maxlength="14" name="fax" id="fax" onkeypress="return hanyaAngka(event)">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Email <small>(Optional)</small></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control reset-form" name="email" id="email">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea name="alamat" id="alamat" class="form-control reset-form"></textarea>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Keterangan</label>
                            <div class="col-md-9">
                                <textarea name="keterangan" id="keterangan" class="form-control reset-form"></textarea>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h6><b>Logo</b></h6>
                        <hr>
                        <div class="form-group tight">
                            <label>Upload Logo</label>

                            <img src="<?= base_url() ?>assets/images/image-upload.png" alt="Upload Logo" id="prev-logo" width="100px" class="rounded mx-auto d-block mb-2">

                            <input type="file" name="logo" onchange="upload_logo()" accept=".jpg, .jpeg, .png" class="form-control reset-form" id="logo">
                            <small id="logo" class="form-text text-muted"><em>Ukuran file minimal dibawah 1 mb.</em></small>
                            <input type="hidden" name="nama_logo" id="nama-logo" class="reset-form">
                        </div>
                        <div class="form-group tight">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="head_office" id="head-office">
                                <label class="form-check-label">Head Office ?</label>
                            </div>
                        </div>
                        <div class="form-group tight">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" checked name="status" id="status">
                                <label class="form-check-label">Status Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times-circle mr-2"></i>Keluar</button>
                <button type="button" class="btn btn-primary" onclick="konfirmasi_simpan()"><i class="fas fa-save mr-2"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>