<div class="modal-body">
    <div class="h5 modal-title text-center">
        <h4 class="mt-2">
            <div><img src="<?= base_url('assets/images/logo-pln.png') ?>" alt="Logo PLN" width="30%"></div>
            <span><strong>SILAHKAN LOGIN</strong></span>
        </h4>
    </div>
    <?= form_open('', 'id=form-login') ?>
    <div class="form-row">
        <div class="col-md-12">
            <div class="position-relative form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><b><i class="fas fa-user"></i></b></span>
                    </div>
                    <input name="account" id="account" type="email" class="form-control" placeholder="Email / Username" required>
                    <em class="help-block error invalid-feedback"></em>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="position-relative form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><b><i class="fas fa-key"></i></b></span>
                    </div>
                    <input name="password" id="password" placeholder="Password" type="password" class="form-control" required>
                    <em class="help-block error invalid-feedback"></em>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="position-relative form-group">
                <center><?= $captcha ?></center>
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><b><i class="fas fa-lock"></i></b></span>
                    </div>
                    <input name="captcha" id="captcha" autocomplete="off" placeholder="Captcha" type="text" class="form-control" required>
                    <em class="help-block error invalid-feedback"></em>
                </div>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>
<div class="modal-footer clearfix">
    <div class="float-right">
        <button class="btn btn-primary" onclick="login()"><i class="fas fa-sign-in-alt mr-2"></i>Login</button>
    </div>
</div>

<?php $this->load->view('js') ?>