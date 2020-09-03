<div class="nav-top flex-grow-1">
    <div class="container d-flex flex-row h-100">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top">
            <a class="navbar-brand brand-logo" href="<?= base_url() ?>">
                <img src="<?= base_url() ?>assets/images/logo-pln.png">
            </a>
            <a class="navbar-brand brand-logo-mini" href="<?= base_url() ?>">
                <img src="<?= base_url() ?>assets/images/logo-pln-mobile.png">
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav navbar-nav-right mr-0">
                <?php if($this->session->userdata('id')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/setting-persetujuan') ?>">
                        <i class="icon-equalizer"></i>
                    </a>
                </li>
                <li class="nav-item nav-profile">
                    <a class="nav-link" href="<?= base_url('admin') ?>">
                        <span class="nav-profile-text"><?= 'Hello, ' . $this->session->userdata('nama') ?></span>
                        <?php if($this->session->userdata('foto')): ?>
                            <img src="<?= base_url() ?>assets/upload/<?= $this->session->userdata('foto') ?>" class="rounded-circle" alt="profile">
                        <?php else: ?>
                            <img src="<?= base_url() ?>assets/images/avatar.png" class="rounded-circle" alt="profile">
                        <?php endif ?>
                    </a>
                <?php else: ?>
                    <a class="nav-link" href="<?= base_url('auth') ?>">
                        <span class="text-white">Login&nbsp;<i class="icon-login mx-0 mr-3"></i></span>
                    </a>
                <?php endif ?>
                </li>
            </ul>
            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu text-white"></span>
            </button>
        </div>
    </div>
</div>