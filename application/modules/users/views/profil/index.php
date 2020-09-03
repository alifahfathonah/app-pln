<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4" style="margin: auto">
                        <?php if($this->session->userdata('foto')): ?>
                            <img src="<?= base_url('assets/upload/') ?><?= $this->session->userdata('foto') ?>" style="margin: auto" class="mx-auto d-block img-fluid img-thumbnail">
                        <?php else: ?>
                            <img src="<?= base_url('assets/images/avatar.png') ?>" style="margin: auto" class="mx-auto d-block img-fluid img-thumbnail">
                        <?php endif ?>
                        <button type="button" class="mx-auto d-block btn btn-light mt-2" onclick="ubah_data('<?= $users->id ?>')"><i class="fas fa-pencil-alt mr-2"></i>Edit Profil</button>
                    </div>
                    <div class="col-lg-8">
                        <h5><b>Information Profil</b></h5>
                        <table class="table table-striped table-sm table-hover">
                            <tr>
                                <td width="25%">Nama Lengkap</td>
                                <td width="1%">:</td>
                                <td><b><?= $users->nama ?></b></td>
                            </tr>
                            <tr>
                                <td>Divisi</td>
                                <td>:</td>
                                <td><b><?= $users->divisi ?></b></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><b><a href="mailto:<?= $users->email ?>" title="<?= $users->email ?>"><?= $users->email ?></a></b></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><b><?= ($users->kelamin == 'L') ? 'Laki - laki' : 'Perempuan'; ?></b></td>
                            </tr>
                            <tr>
                                <td>Tgl. Terdaftar</td>
                                <td>:</td>
                                <td><b><?= $users->created_date ?></b></td>
                            </tr>
                        </table>
                        <hr>
                        <h5><b>Information Kontak</b></h5>
                        <table class="table table-striped table-sm table-hover">
                            <tr>
                                <td width="25%">No. HP</td>
                                <td width="1%">:</td>
                                <td><b><a href="tel:<?= $users->telp_wa ?>" title="<?= $users->telp_wa ?>"><?= $users->telp_wa ?></a> (WA)</b></td>
                            </tr>
                            <tr>
                                <td>No. Telp</td>
                                <td>:</td>
                                <td><b><?= ($users->telp) ? $users->telp : '-'; ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('users/js') ?>