<!-- Modal Form-->
<div class="modal fade" id="modal-form" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=form-atk') ?>
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label>No. Nota Dinas</label>
                    <input type="text" class="form-control validasi-input" name="no_notadinas" id="no-notadinas">
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" class="form-control" name="tanggal" id="tanggal">
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Users</label>
                    <input type="text" class="form-control" id="users" value="<?= $this->session->userdata('nama'); ?>" readonly>
                    <input type="hidden" name="id_users" id="id-users" value="<?= $this->session->userdata('id'); ?>">
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Barang</label>
                            <select name="barang" id="barang" onchange="get_barang(this.value)" class="form-control select2 validasi-input">
             
                            </select>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Request QTY</label>
                            <input type="text" name="qty_request" id="qty-request" onkeypress="return hanyaAngka(event)" class="form-control validasi-input">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" id="satuan-request" class="form-control validasi-input" readonly>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Approval QTY</label>
                            <input type="text" name="qty_approval" id="qty-approval" onkeypress="return hanyaAngka(event)" class="form-control validasi-input">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" id="satuan-approval" class="form-control validasi-input" readonly>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="add_barang()"><i class="fas fa-plus-circle"></i>Tambah</button>
                
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover" id="table-atk">
                                <thead class="thead-darkblue">
                                    <tr>
                                        <th width="5%"></th>
                                        <th width="50%">Nama Barang</th>
                                        <th class="center">Request QTY</th>
                                        <th class="center">Satuan</th>
                                        <th class="center">Approval QTY</th>
                                        <th class="center">Satuan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-window-close mr-2"></i>Keluar
                </button>
                <button type="button" onclick="konfirmasi_simpan()" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail-->
<div class="modal fade" id="modal-detail" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-detail-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=form-detail') ?>
                <input type="hidden" name="id" id="id-detail">
                <div class="form-group">
                    <label>No. Nota Dinas</label>
                    <input type="text" class="form-control validasi-input" name="no_notadinas" id="no-notadinas-detail" readonly>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" class="form-control" name="tanggal" id="tanggal-detail" readonly>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Users</label>
                    <input type="text" class="form-control" id="users-detail" readonly>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover" id="table-atk-detail">
                                <thead class="thead-darkblue">
                                    <tr>
                                        <th width="5%"></th>
                                        <th width="50%">Nama Barang</th>
                                        <th class="center">Request QTY</th>
                                        <th class="center">Satuan</th>
                                        <th class="center">Approval QTY</th>
                                        <th class="center">Satuan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-window-close mr-2"></i>Keluar
                </button>
            </div>
        </div>
    </div>
</div>

