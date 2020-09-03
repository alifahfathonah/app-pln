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
                <?= form_open('', 'class="form-horizontal" id="form-ruangan"') ?>
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-lg-8">
                        <h6><b>Informasi Dasar</b></h6>
                        <hr>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Nopol</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control reset-form" name="nopol" id="nopol">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Nama</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control reset-form" name="nama" id="nama">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Jenis Kendaraan</label>
                            <div class="col-md-9">
                                <?= form_dropdown('jenis_kendaraan', $jenis_kendaraan, array(), 'id=jenis-kendaraan class="form-control reset-form"') ?>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Kapasitas</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control reset-form" name="kapasitas" id="kapasitas">
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