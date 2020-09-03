<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-list mr-2"></i>Data Ceklis Kendaraan</h6>
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
                        <input type="text" class="form-control" name="filter_no_plat" id="filter-no-plat" placeholder="- Pencarian No Plat -">
                    </div>
                    <div class="col-md-4 col-lg mt-2">
                        <select name="filter_kondisi" id="filter-kondisi" class="form-control">
                            <option value="">- Semua -</option>
                            <option value="1">Terima</option>
                            <option value="2">Pengembalian</option>
                        </select>
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
                                        <th>No Plat</th>
                                        <th>Kondisi</th>
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

<?php $this->load->view('modal') ?>
<?php $this->load->view('js') ?>