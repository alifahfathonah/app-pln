<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div>
                <?= $breadcrumb ?>
                <div class="page-title-subheading">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active"><?= $breadcrumb ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="page-title-actions">
            <button type="button" onclick="simpan_data()" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Simpan Data</button>
        </div>
    </div>
</div>

<!-- Content -->
<div class="post-input-info"><i class="fas fa-info-circle tada disinblock mr-5 mt-2"></i>
    <div class="disinblock pl-3 ml-3">
        <ul class="cgray2">
            <li>
                <p class="cgray2 mb-2">Setiap Dokumen harus memiliki minimal 1 User dengan kondisi persetujuan <strong>Wajib</strong></p>
            </li>
            <li>
                <p class="cgray2 mb-2">Jika User dengan kondisi <strong>Wajib</strong> melakukan persetujuan maka user dengan kondisi <strong>Optional</strong> akan otomatis mengikuti jawaban yang dipilih.</p>
            </li>
        </ul>
    </div>
</div>
<?= form_open('', 'id=form-setting-persetujuan class=form-horizontal') ?>
<div class="box mb-3">
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>DOKUMEN PEMINJAMAN KENDARAAN</strong>
                </div>
                <div class="card-body">
                    <div id="load-content-peminjaman-kendaraan"></div>
                    <button type="button" class="btn btn-success btn-block" id="btn-tambah-setting-peminjaman-kendaraan" rel="#setting-peminjaman-kendaraan" onclick="tambah_input_peminjaman_kendaraan()"><i class="fas fa-plus-circle mr-2"></i>Tambah</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>DOKUMEN PEMINJAMAN RUANGAN</strong>
                </div>
                <div class="card-body">
                    <div id="load-content-peminjaman-ruangan"></div>
                    <button type="button" class="btn btn-success btn-block" id="btn-tambah-setting-peminjaman-ruangan" rel="#setting-peminjaman-ruangan" onclick="tambah_input_peminjaman_ruangan()"><i class="fas fa-plus-circle mr-2"></i>Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close() ?> 


<?php $this->load->view('js') ?>