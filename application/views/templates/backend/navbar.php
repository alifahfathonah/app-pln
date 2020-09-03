<div class="app-header header-shadow bg-dark header-text-light">
    <div class="app-header__logo">
        <a class="logo-src" href="<?= base_url() ?>"></a>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fas fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            <div id="jam" class="ml-3"></div>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <?php if ($this->session->userdata('foto')) : ?>
                                        <img width="42" class="rounded-circle" src="<?= base_url() ?>assets/upload/<?= $this->session->userdata('foto') ?>">
                                        <i class="fas fa-angle-down ml-2 opacity-8"></i>
                                    <?php else : ?>
                                        <img width="42" class="rounded-circle" src="<?= base_url() ?>assets/images/avatar.png">
                                        <i class="fas fa-angle-down ml-2 opacity-8"></i>
                                    <?php endif ?>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                    <a href="<?= base_url('admin/users/profil') ?>" class="dropdown-item"><i class="fas fa-user mr-2"></i>Profil</a>
                                    <a href="<?= base_url('admin/users/change-password') ?>" class="dropdown-item"><i class="fas fa-exchange-alt mr-2"></i>Ganti Password</a>
                                    <a href="<?= base_url('auth/logout') ?>" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                <?= $this->session->userdata('nama') ?>
                            </div>
                            <div class="widget-subheading">
                                <?= $this->session->userdata('divisi') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>