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
                <?= form_open('', 'class="form-horizontal" id="form-divisi"') ?>
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-lg-12">
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
                            <label class="col-md-3 col-form-label">Atasan <small>(Optional)</small></label>
                            <div class="col-md-9">
                                <?= form_dropdown('atasan', $atasan, array(), 'id=atasan class="custom-select reset-form"') ?>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group tight">
                            <label class="col-md-3 col-form-label">Kategori Divisi</label>
                            <div class="col-md-9">
                                <?= form_dropdown('kategori_divisi', $kategori_divisi, array(), 'id=kategori-divisi select2 class="custom-select reset-form"') ?>
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <br>
                        <div class="form-group tight">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="is_allow_login" id="is-allow-login">
                                <label class="form-check-label">Dapat Login ke dalam Aplikasi</label>
                            </div>
                        </div>
                        <div class="form-group tight">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="is_need_approval" id="is-need-approval">
                                <label class="form-check-label">Butuh persetujuan untuk setiap pengajuan</label>
                            </div>
                        </div>

                        <div class="post-input-info mt-5"><i class="fas fa-info-circle tada disinblock mr-5 mt-2"></i>
                            <div class="disinblock pl-3 ml-3">
                                <ul class="cgray2">
                                    <li>
                                        <p class="cgray2 mb-2">Jika tidak dicentang, setiap pengajuan yang dibuat akan langsung <strong>Disetujui</strong> tanpa menunggu persetujuan.</p>
                                    </li>
                                    <li>
                                        <p class="cgray2 mb-2">Untuk Divisi dengan kategori <strong>Administrator</strong>, setiap pengajuan yang dibuat akan langsung <strong>Disetujui</strong> tanpa menunggu persetujuan.</p>
                                    </li>
                                </ul>
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