<div class="nav-bottom">
    <div class="container">
        <ul class="nav page-navigation">
            <li class="nav-item <?= ($active == 'beranda' ? 'active' : '') ?>">
                <a href="<?= base_url() ?>" class="nav-link">
                    <i class="link-icon icon-screen-desktop"></i>
                    <span class="menu-title">Home</span>
                </a>
            </li>
            <li class="nav-item <?= ($active == 'buku-tamu' ? 'active' : '') ?>">
                <a href="javascript:(0)" class="nav-link">
                    <i class="link-icon icon-people"></i>
                    <span class="menu-title">Buku Tamu</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('buku-tamu') ?>">Daftar Buku Tamu</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item <?= ($active == 'peminjaman-ruangan' ? 'active' : '') ?>">
                <a href="javascript:(0)" class="nav-link">
                    <i class="link-icon icon-key"></i>
                    <span class="menu-title">Peminjaman Ruangan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('booking/ruangan') ?>">Daftar Peminjaman Ruangan</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item <?= ($active == 'peminjaman-kendaraan' ? 'active' : '') ?>">
                <a href="javascript:(0)" class="nav-link">
                    <i class="link-icon icon-key"></i>
                    <span class="menu-title">Peminjaman Kendaraan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('booking/kendaraan') ?>">Daftar Peminjaman Kendaraan</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item <?= ($active == 'form-ceklis-kendaraan' ? 'active' : '') ?>">
                <a href="javascript:(0)" class="nav-link">
                    <i class="link-icon icon-check"></i>
                    <span class="menu-title">Form Ceklis Kendaraan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('form-ceklis-kendaraan') ?>">Daftar Ceklis Kendaraan</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item <?= ($active == 'report-atk' ? 'active' : '') ?>">
                <a href="javascript:(0)" class="nav-link">
                    <i class="link-icon icon-check"></i>
                    <span class="menu-title">ATK</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('atk') ?>">Daftar ATK</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('report-atk') ?>">Laporan ATK</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>