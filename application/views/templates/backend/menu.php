<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
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
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">MAIN NAVIGATION</li>
                <li>
                    <a href="<?= base_url() ?>"><i class="metismenu-icon fas fa-home"></i>HOME</a>
                </li>
                
                <?php if($this->session->userdata('id_divisi') !== '35'): ?>
                    <!-- Menu Masterdata -->
                    <li>
                        <a href="#">
                            <i class="metismenu-icon fas fa-database"></i>MASTERDATA
                            <i class="metismenu-state-icon fa fa-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li class="<?php echo ($active == 'master-barang' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-barang') ?>" class="<?php echo ($active == 'master-barang' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Barang
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-atasan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-atasan') ?>" class="<?php echo ($active == 'master-atasan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Atasan
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-divisi' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-divisi') ?>" class="<?php echo ($active == 'master-divisi' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Divisi
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-kategori-divisi' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-kategori-divisi') ?>" class="<?php echo ($active == 'master-kategori-divisi' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Kategori Divisi
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-cabang' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-cabang') ?>" class="<?php echo ($active == 'master-cabang' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Cabang
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-jenis-kendaraan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-jenis-kendaraan') ?>" class="<?php echo ($active == 'master-jenis-kendaraan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Jenis Kendaraan
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-kendaraan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-kendaraan') ?>" class="<?php echo ($active == 'master-kendaraan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Kendaraan
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-makan-siang' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-makan-siang') ?>" class="<?php echo ($active == 'master-makan-siang' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Makan Siang
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-snack' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-snack') ?>" class="<?php echo ($active == 'master-snack' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Snack
                                </a>
                            </li>
                            <li class="<?php echo ($active == 'master-ruangan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/master-ruangan') ?>" class="<?php echo ($active == 'master-ruangan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Ruangan
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Menu Masterdata -->

                    <!-- Menu Kendaraan -->
                    <li>
                        <a href="#">
                            <i class="metismenu-icon fas fa-cog"></i>KENDARAAN
                            <i class="metismenu-state-icon fa fa-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <!-- <li class="<?php echo ($active == 'peminjaman-kendaraan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/peminjaman-kendaraan') ?>" class="<?php echo ($active == 'peminjaman-kendaraan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Peminjaman Kendaraan
                                </a>
                            </li> -->
                            <li class="<?php echo ($active == 'permohonan-peminjaman-kendaraan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/permohonan-peminjaman-kendaraan') ?>" class="<?php echo ($active == 'permohonan-peminjaman-kendaraan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Permohonan Kendaraan
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Menu Kendaraan -->

                    <!-- Menu Ruangan -->
                    <li>
                        <a href="#">
                            <i class="metismenu-icon fas fa-cog"></i>RUANGAN
                            <i class="metismenu-state-icon fa fa-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <!-- <li class="<?php echo ($active == 'peminjaman-ruangan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/peminjaman-ruangan') ?>" class="<?php echo ($active == 'peminjaman-ruangan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Peminjaman Ruangan
                                </a>
                            </li> -->
                            <li class="<?php echo ($active == 'permohonan-peminjaman-ruangan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/permohonan-peminjaman-ruangan') ?>" class="<?php echo ($active == 'permohonan-peminjaman-ruangan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Permohonan Ruangan
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Menu Ruangan -->

                    <!-- Menu Users -->
                    <li>
                        <a href="<?= base_url('admin/users') ?>" class="<?php echo ($active == 'users' ? 'mm-active' : '') ?>"><i class="metismenu-icon fas fa-users"></i>USERS</a>
                    </li>
                    <!-- End Menu Users -->

                    <!-- Menu Setting -->
                    <li>
                        <a href="#">
                            <i class="metismenu-icon fas fa-cog"></i>SETTING
                            <i class="metismenu-state-icon fa fa-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li class="<?php echo ($active == 'setting-persetujuan' ? 'mm-active' : '') ?>">
                                <a href="<?= base_url('admin/setting-persetujuan') ?>" class="<?php echo ($active == 'setting-persetujuan' ? 'mm-active' : '') ?>">
                                    <i class="metismenu-icon"></i>Persetujuan
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Menu Setting -->
                <?php endif ?>
                
            </ul>
        </div>
    </div>
</div>