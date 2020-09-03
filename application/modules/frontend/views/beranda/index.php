<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card text-white border-0">
            <img class="card-img h-100 rounded-0" src="<?= base_url() ?>assets/images/background-pln-2.jpeg">
            <div class="card-img-overlay d-flex flex-column justify-content-between">
                <h4 class="font-weight-light">
                    <i class="icon-calendar mr-3"></i><br>
                    <span id="jam"></span>
                </h4>
                <div>
                    <h4 class="font-weight-light">Selamat datang di</h4>
                    <h3 class="mb-0">Dashboard - Daily Service UID Banten</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card bg-dark text-white border-0">
                    <div class="card-body">
                        <a href="<?= base_url('booking/ruangan') ?>" class="beranda">
                            <div class="d-flex align-items-center">
                                <i class="icon-home icon-lg"></i>
                                <div class="ml-4">
                                    <h4 class="font-weight-light">Peminjaman</h4>
                                    <h3 class="font-weight-light mb-3">Ruangan</h3>
                                    <p class="mb-0 font-weight-light"><?= $count_ruangan ?> Pengajuan Disetujui</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
                <div class="card bg-primary text-white border-0">
                    <div class="card-body">
                        <a href="<?= base_url('booking/kendaraan') ?>" class="beranda">
                            <div class="d-flex align-items-center">
                                <i class="icon-people icon-lg"></i>
                                <div class="ml-4">
                                    <h4 class="font-weight-light">Peminjaman</h4>
                                    <h3 class="font-weight-light mb-3">Kendaraan</h3>
                                    <p class="mb-0 font-weight-light"><?= $count_kendaraan ?> Pengajuan Disetujui</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 d-flex align-items-stretch">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card bg-danger text-white border-0">
                    <div class="card-body">
                        <a href="<?= base_url('buku-tamu') ?>" class="beranda">
                            <div class="d-flex align-items-center">
                                <i class="icon-people icon-lg"></i>
                                <div class="ml-4">
                                    <h4 class="font-weight-light">Buku</h4>
                                    <h3 class="font-weight-light mb-3">Tamu</h3>
                                    <p class="mb-0 font-weight-light"><?= $count_tamu ?> Kunjungan Tamu</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
                <div class="card bg-success text-white border-0">
                    <div class="card-body">
                        <a href="<?= base_url('form-ceklis-kendaraan') ?>" class="beranda">
                            <div class="d-flex align-items-center">
                                <i class="icon-check icon-lg"></i>
                                <div class="ml-4">
                                    <h4 class="font-weight-light">Ceklis</h4>
                                    <h3 class="font-weight-light mb-3">Kendaraan</h3>
                                    <p class="mb-0 font-weight-light"><?= $count_ceklis ?> Record Ceklis Kendaraan</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
                <div class="card bg-warning text-white border-0">
                    <div class="card-body">
                        <a href="<?= base_url('atk') ?>" class="beranda">
                            <div class="d-flex align-items-center">
                                <i class="icon-check icon-lg"></i>
                                <div class="ml-4">
                                    <h4 class="font-weight-light">Data</h4>
                                    <h3 class="font-weight-light mb-3">ATK</h3>
                                    <p class="mb-0 font-weight-light"> Record ATK</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('js') ?>