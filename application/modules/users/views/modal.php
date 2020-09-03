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
                <?= form_open('', 'class="form-horizontal" id="form-users"') ?>
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-lg-8">
                        <h6><b>Informasi Dasar</b></h6>
                        <hr>
                        <div class="row form-group tight">
                            <label class="col-md-4 col-form-label">NIK</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control reset-form" name="nik" id="nik">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-4 col-form-label">Nama</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control reset-form" name="nama" id="nama">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-4 col-form-label">Kelamin </small></label>
                            <div class="col-md-8">
                                <?= form_dropdown('kelamin', $kelamin, array(), 'id=kelamin class="form-control"') ?>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-4 col-form-label">Email</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control reset-form" name="email" id="email">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight username-hide">
                            <label class="col-md-4 col-form-label">Username</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control reset-form" name="username" id="username">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight password-hide">
                            <label class="col-md-4 col-form-label">Password</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control reset-form" name="password" id="password">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight konfirmasi-password-hide">
                            <label class="col-md-4 col-form-label">Konfirmasi Password</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control reset-form" name="re_password" id="re-password">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-4 col-form-label">Divisi</label>
                            <div class="col-md-8">
                                <input type="divisi" class="select2-input reset-form" name="divisi" id="divisi">
                                <!-- <em class="help-block error invalid-feedback"></em> -->
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-4 col-form-label">Telepon Atasan</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control reset-form" name="telpon_atasan" id="telpon-atasan" maxlength="13" onkeypress="return hanyaAngka(event)">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <br>
                        <h6><b>Informasi Kontak</b></h6>
                        <hr>
                        <div class="row form-group tight">
                            <label class="col-md-4 col-form-label">No. Handphone <small>(Whatssapp)</small></label>
                            <div class="col-md-8">
                                <input type="text" maxlength="13" onkeypress="return hanyaAngka(event)" class="form-control reset-form" name="telp_wa" id="telp-wa">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-4 col-form-label">No. Handphone <small>(Optional)</small></label>
                            <div class="col-md-8">
                                <input type="text" maxlength="13" onkeypress="return hanyaAngka(event)" class="form-control reset-form" name="telp" id="telp">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h6><b>Foto</b></h6>
                        <hr>
                        <div class="form-group tight">
                            <label>Upload Foto</label>

                            <img src="<?= base_url() ?>assets/images/image-upload.png" alt="Upload Foto" id="prev-foto" width="100px" class="rounded mx-auto d-block mb-2">

                            <input type="file" name="foto" onchange="upload_foto()" accept=".jpg, .jpeg, .png" class="form-control reset-form" id="foto">
                            <small id="foto" class="form-text text-muted"><em>Ukuran file minimal dibawah 1 mb.</em></small>
                            <input type="hidden" name="nama_foto" id="nama-foto" class="reset-form">
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
                <button type="button" class="btn btn-primary" id="btn-simpan" onclick="konfirmasi_simpan()"><i class="fas fa-save mr-2"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>