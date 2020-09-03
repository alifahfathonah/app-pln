<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-info-circle mr-2"></span><span id="message"></span></h6>
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-left">
                    <div class="col-lg center">

                        <?= form_open('', 'id=form-change-password role=form class=form-horizontal') ?>
                        <input name="id" type="hidden" id="id" value="<?= $this->session->userdata('id') ?>" />
                        <div class="row form-group">
                            <label class="col-md-4 col-form-label">Old Password</label>
                            <div class="col-md-8">
                                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Your Old Password">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 col-form-label">New Password</label>
                            <div class="col-md-8">
                                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Your New Password">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 col-form-label">Confirmation Password</label>
                            <div class="col-md-8">
                                <input type="password" name="password_konf" class="form-control" id="password_konf" placeholder="Confirmation New Password">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-7">
                                <button type="button" class="btn btn-primary" id="btnChange"><i class="fas fa-check"></i> Change Password</button>
                                <button type="button" class="btn btn-secondary" onclick="reset()"><i class="fas fa-history"></i> Reset</button>
                            </div>
                        </div>
                        <?= form_close() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('change_password/js'); ?>