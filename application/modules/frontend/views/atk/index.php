<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-list mr-2"></i>Data ATK</h6>
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
                        <input type="text" class="form-control" name="filter_no_notadinas" id="filter-no-notadinas" placeholder="- Pencarian Nomor Nota Dinas -">
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
                                        <th>Tanggal</th>
                                        <th>No. Nota Dinas</th>
                                        <th>Created By</th>
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

<?php $this->load->view('modal') ?>
<?php $this->load->view('js') ?>