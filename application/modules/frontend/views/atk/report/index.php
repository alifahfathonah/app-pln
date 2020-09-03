<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-list mr-2"></i>Parameter Report</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <?= form_open('', 'class=form-horizontal id=form-report-atk') ?>
                        <div class="form-group">
                            <label>No. Nota Dinas</label>
                            <input type="text" name="no_notadinas" id="no-notadinas" class="form-control">
                        </div>     
                        <div class="form-group">
                            <label>Tanggal</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" name="tanggal_awal" id="tanggal-awal" class="form-control" value="<?= date('d/m/Y') ?>">
                                </div>
                                <div class="col-lg-1">
                                    <h6 class="mt-2">s/d</h6>
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" name="tanggal_akhir" id="tanggal-akhir" class="form-control" value="<?= date('d/m/Y') ?>">
                                </div>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label>Divisi</label>
                            <?= form_dropdown('divisi', $divisi, array(), 'class="form-control select2" id=divisi') ?>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="cetak_laporan()"><i class="fas fa-print mr-2"></i>Cetak</button>
                        <?= form_close() ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('js') ?>