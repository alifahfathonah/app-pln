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
            <!-- <button type="button" id="btn-tambah" class="btn btn-primary"><i class="fas fa-plus-circle mr-2"></i>Tambah Data</button> -->
            <button type="button" id="btn-reload" class="btn btn-light"><i class="fas fa-sync-alt mr-2"></i>Reload Data</button>
        </div>
    </div>
</div>

<!-- Content -->

<div class="row">
    <div class="col-md col-lg">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <table class="table-no-border" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input type="text" name="filter_nama" id="filter-nama" class="form-control reset-form" placeholder="Pencarian Data...">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <?= form_dropdown('status_dokumen', $status_dokumen, array(), 'id=status-dokumen class="form-control reset-form"') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover" id="table-data">
                                <thead class="thead-theme">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>No Dokumen</th>
                                        <th>Kendaraan</th>
                                        <th>Tujuan</th>
                                        <th>Diajukan Oleh</th>
                                        <th>Tgl. Dibuat</th>
                                        <th>Status Dokumen</th>
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

<?php $this->load->view('js') ?>