<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-list mr-2"></i>Data Peminjaman Ruangan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg-2 mt-2">
                        <button type="button" id="btn-tambah" class="btn btn-primary btn-block">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah
                        </button>
                    </div>
                    <div class="col-md-4 col-lg-2 mt-2">
                        <button type="button" id="btn-reload" class="btn btn-secondary btn-block">
                            <i class="fas fa-sync-alt mr-2"></i>Reload
                        </button>
                    </div>
                    <div class="col-md-4 col-lg mt-2">
                        <input type="text" class="form-control" name="filter_no_dokumen" id="filter-no-dokumen" placeholder="- Pencarian No Dokumen -">
                    </div>
                    <div class="col-md-4 col-lg mt-2">
                        <input type="text" class="form-control" name="filter_kegiatan" id="filter-kegiatan" placeholder="- Pencarian Kegiatan -">
                    </div>
                    <div class="col-md-4 col-lg mt-2">
                        <?= form_dropdown('status_dokumen', $status_dokumen, array(), 'id=filter-status-dokumen class="form-control"') ?>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover" id="table-data">
                                <thead class="thead-darkblue">
                                    <tr>
                                        <th></th>
                                        <th width="5%">No</th>
                                        <th>No Dokumen</th>
                                        <th>Ruangan</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($this->session->flashdata('pesan_absen_success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success Absensi Kehadiran',
            text: "<?= $this->session->flashdata('pesan_absen_success') ?>",
            showConfirmButton: true,
            // timer: 2000
        })
        
    </script>

    <?php $this->session->unset_userdata('url_absen'); ?>
<?php endif ?>
<?php if($this->session->flashdata('pesan_absen_error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Absensi Kehadiran',
            text: "<?= $this->session->flashdata('pesan_absen_error') ?>",
            showConfirmButton: true,
            // timer: 2000
        })
    </script>

    <?php $this->session->unset_userdata('url_absen'); ?>
<?php endif ?>

<?php $this->load->view('modal') ?>
<?php $this->load->view('js') ?>