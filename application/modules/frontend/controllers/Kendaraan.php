<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kendaraan extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/frontend/index');
        $this->load->model('Kendaraan_model', 'kendaraan');
        $this->load->model('persetujuan/M_persetujuan', 'm_persetujuan');
        $this->load->model('auto/M_auto', 'm_auto');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function index()
    {
        $this->template->add_title_segment('Peminjaman Kendaraan');

        $dariDB = $this->m_auto->cek_no_dokumen();
        // contoh FM-SMK3-VHC-0001, angka 3 adalah awal pengambilan angka, dan 4 jumlah angka yang diambil
        $nourut = substr($dariDB, 12, 4);
        $no_dokumen_sekarang = $nourut + 1;

        $data = array(
            'active'         => 'peminjaman-kendaraan',
            'breadcrumb'     => 'Peminjaman Kendaraan',
            'modal'          => array('peminjaman_kendaraan/modal'),
            'no_dokumen'     => $no_dokumen_sekarang,
            'persetujuan'    => $this->m_persetujuan->get_data_persetujuan_kendaraan(),
            'status_dokumen' => $this->m_auto->get_status_dokumen(),
            'driver'         => $this->m_auto->get_driver_select(),
            'diajukan_oleh'  => $this->m_auto->get_atasan_select()
        );

        $this->template->render('kendaraan/index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->kendaraan->get_datatables($sort, $order);
        foreach ($list as $l) :

            if ($l->dokumen_status === 'Menunggu') :
                $dokumen_status = '<span class="badge badge-warning"><i class="fas fa-spinner fa-spin mr-2"></i>' . $l->dokumen_status . '</span>';
            elseif ($l->dokumen_status === 'Disetujui') :
                $dokumen_status = '<span class="badge badge-success"><i class="fas fa-thumbs-up mr-2"></i>' . $l->dokumen_status . '</span>';
            elseif ($l->dokumen_status === 'Ditolak') :
                $dokumen_status = '<span class="badge badge-danger"><i class="fas fa-ban mr-2"></i>' . $l->dokumen_status . '</span>';
            else :
                $dokumen_status = '<span class="badge badge-info"><i class="fas fa-check-circle mr-2"></i>' . $l->dokumen_status . '</span>';
            endif;

            $no++;
            $l->no            = $no;
            $l->no_dokumen    = $l->no_dokumen;
            $l->kendaraan     = $l->nopol . " - " .$l->kendaraan;
            $l->tujuan        = $l->tujuan;
            $l->diajukan_oleh = $l->diajukan_oleh;
            $l->created_date  = $l->created_date;
            $l->status        = $dokumen_status;

            if ($l->dokumen_status === 'Disetujui') :
                if ($l->id_driver === $this->session->userdata('id')) :
                    $l->aksi = '<div class="right">
                            <button type="button" onclick="input_driver_km_awal(' . $l->id . ')" title="Driver Data Input KM Awal" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-clipboard-list"></i></button>
                            <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                            <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                        </div>';
                else :
                    $l->aksi = '<div class="right">
                            <button type="button" onclick="ubah_status(' . $l->id . ', `' . $l->dokumen_status . '`)" title="Tutup Status Kendaraan" class="btn btn-shadow btn-danger btn-xs"><i class="fas fa-times-circle"></i></button>
                            <button type="button" onclick="input_driver_km_akhir(' . $l->id . ')" title="Driver Data Input KM Akhir" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-clipboard-list"></i></button>
                            <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                            <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                        </div>';
                endif;
            elseif ($l->dokumen_status === 'Selesai') :
                if ($l->id_driver === $this->session->userdata('id')) :
                    $l->aksi = '<div class="right">
                            <button type="button" onclick="input_driver_km_akhir(' . $l->id . ')" title="Driver Data Input KM Akhir" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-clipboard-list"></i></button>
                            <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                            <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                        </div>';
                else :
                    $l->aksi = '<div class="right">
                            <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                        </div>';
                endif;
            else :
                $l->aksi = '<div class="right">
                        <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                        <button type="button" onclick="ubah_data(' . $l->id . ')" title="Ubah Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-edit"></i></button>
                        <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                    </div>';
            endif;

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->kendaraan->count_all($sort, $order),
            "recordsFiltered"   => $this->kendaraan->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data['peminjam'] = $this->kendaraan->get_data_by_id($id);
        $data['personil'] = $this->kendaraan->get_data_personil($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        // $this->form_validation->set_rules('kendaraan', 'kendaraan', 'required');
        $this->form_validation->set_rules('tujuan', 'tujuan', 'required');
        // $this->form_validation->set_rules('driver', 'driver', 'required');
        $this->form_validation->set_rules('users', 'users', 'required');
        if (!empty($_POST['nama_personil'])) {
            $this->form_validation->set_rules('nama_personil[]', 'nama personil', 'required');
            $this->form_validation->set_rules('nama_divisi_personil[]', 'divisi personil', 'required');
            $this->form_validation->set_rules('nama_jabatan_personil[]', 'jabatan personil', 'required');
            $this->form_validation->set_rules('no_telp_personil[]', 'no telp personil', 'required|is_numeric');
        }

        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        // if (form_error('kendaraan')) $error[] = 'kendaraan';
        if (form_error('tujuan')) $error[] = 'tujuan';
        // if (form_error('driver')) $error[] = 'driver';
        if (form_error('users')) $error[] = 'users';
        if (form_error('nama_personil[]')) $error[] = 'nama_personil[]';
        if (form_error('nama_divisi_personil[]')) $error[] = 'nama_divisi_personil[]';
        if (form_error('nama_jabatan_personil[]')) $error[] = 'nama_jabatan_personil[]';
        if (form_error('no_telp_personil[]')) $error[] = 'no_telp_personil[]';

        if ($error) :
            foreach ($error as $row) :
                $data['error_class'][$row]  = 'is-invalid';
                $data['error_string'][$row] = form_error($row);
            endforeach;

            $data['validasi'] = FALSE;
            echo json_encode($data);
            exit();
        endif;
    }

    function ajax_post() 
    {
        $this->_validasi();
        
        $data_peminjaman_kendaraan = array(
            'id_kendaraan'         => $this->input->post('kendaraan', true)?: NULL,
            'voucher'              => $this->input->post('voucher', true)?: NULL,
            'is_use_driver'        => $this->input->post('is_use_driver', true),
            'id_driver'            => $this->input->post('driver', true)?: NULL,
            'tujuan'               => $this->input->post('tujuan', true),
            'keterangan'           => $this->input->post('keterangan', true),
            'tgl_start_peminjaman' => datetime2mysql($this->input->post('tgl_start', true)) . ":00",
            'tgl_end_peminjaman'   => datetime2mysql($this->input->post('tgl_end', true)) . ":00",
            'no_dokumen'           => $this->input->post('no_dokumen'),
            'id_atasan'            => $this->input->post('users', true),
            'id_users'             => $this->session->userdata('id'),
            'created_date'         => $this->datetime,  
        );
        
        $id_peminjaman_kendaraan = $this->kendaraan->simpan_data_peminjaman_kendaraan($data_peminjaman_kendaraan);

        $nama          = $this->input->post('nama_personil', true); 
        $divisi        = $this->input->post('nama_divisi_personil', true); 
        $jabatan       = $this->input->post('nama_jabatan_personil', true); 
        $telp          = $this->input->post('no_telp_personil', true);
        $data_personil = array();

        $index = 0;
        foreach($nama as $datanama) :
            array_push($data_personil, array(
                'id_peminjaman_kendaraan' => $id_peminjaman_kendaraan,
                'nama'                    => $datanama,
                'divisi'                  => $divisi[$index],  
                'jabatan'                 => $jabatan[$index],
                'telp'                    => $telp[$index],
            ));
            
            $index++;
        endforeach;

        $data = $this->kendaraan->save_batch_data_personil_peminjaman_kendaraan($data_personil);

        $atasan          = $this->input->post('atasan', true);
        $data_persetujuan = array();

        $index = 0;
        foreach($atasan as $dataatasan) :
            array_push($data_persetujuan, array(
                'id_peminjaman_kendaraan' => $id_peminjaman_kendaraan,
                'id_users'                => $dataatasan,
                'created_date'            => $this->datetime,
            ));
            
            $index++;
        endforeach;

        $data = $this->kendaraan->save_batch_data_persetujuan_peminjaman_kendaraan($data_persetujuan);

        $data_koordriver = $this->db->select('telp_wa, nama')->from('users')->where('id', '395')->get()->row();
        if ($data) :
            echo json_encode(array(
                'status' => $data,
                'koordriver'  => $data_koordriver,
                'message' => 'Berhasil menyimpan data'
            ));
        else :
            echo json_encode(array(
                'status' => $data,
                'message' => 'Gagal menyimpan data'
            ));
        endif;
    }

    function ajax_put()
    {
        $this->_validasi();

        $data_peminjaman_kendaraan = array(
            'id_kendaraan'         => $this->input->post('kendaraan', true)?: NULL,
            'voucher'              => $this->input->post('voucher', true)?: NULL,
            'is_use_driver'        => $this->input->post('is_use_driver', true),
            'id_driver'            => $this->input->post('driver', true)?: NULL,
            'tujuan'               => $this->input->post('tujuan', true),
            'keterangan'           => $this->input->post('keterangan', true),
            'tgl_start_peminjaman' => datetime2mysql($this->input->post('tgl_start', true)) . ":00",
            'tgl_end_peminjaman'   => datetime2mysql($this->input->post('tgl_end', true)) . ":00",
            'id_atasan'            => (int)$this->input->post('users', true),
            'id_users'             => (int)$this->session->userdata('id'),
            'modified_date'        => $this->datetime,  
        );
        
        $id_peminjaman_kendaraan = $this->kendaraan->update_data_peminjaman_kendaraan($data_peminjaman_kendaraan, $this->input->post('id', true));
          
        $id            = $this->input->post('id', true); 
        $nama          = $this->input->post('nama_personil', true); 
        $divisi        = $this->input->post('nama_divisi_personil', true); 
        $jabatan       = $this->input->post('nama_jabatan_personil', true); 
        $telp          = $this->input->post('no_telp_personil', true);
        $data_personil = array();

        $index = 0;
        foreach($nama as $datanama) :
            array_push($data_personil, array(
                'id_peminjaman_kendaraan' => $id,
                'nama'                    => $datanama,
                'divisi'                  => $divisi[$index],  
                'jabatan'                 => $jabatan[$index],
                'telp'                    => $telp[$index],
            ));
            
            $index++;
        endforeach;
        
        $data = $this->db->update_batch('peminjaman_kendaraan_personil', $data_personil, 'id_peminjaman_kendaraan');

        if ($id_peminjaman_kendaraan) :
            echo json_encode(array(
                'status' => true,
                'message' => 'Berhasil mengubah data'
            ));
        else :
            echo json_encode(array(
                'status' => false,
                'message' => 'Gagal mengubah data'
            ));
        endif;
    }

    function ajax_delete()
    {
        $id = $this->input->get('id', true);
        $data = $this->kendaraan->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }

    function update_km_awal_kendaraan()
    {
        $id = $this->input->post('id');
        $km_awal = $this->input->post('km_awal');

        $data = [
            'km_awal' => $km_awal,
            'tgl_input_km_awal' => $this->datetime,
        ];

        $result = $this->db->update('peminjaman_kendaraan', $data, ['id' => $id]);

        if ($result) :
            echo json_encode(array(
                'status' => true,
                'message' => 'Berhasil mengubah data'
            ));
        else :
            echo json_encode(array(
                'status' => false,
                'message' => 'Gagal mengubah data'
            ));
        endif;
    }

    function update_km_akhir_kendaraan()
    {
        $id = $this->input->post('id');
        $km_akhir = $this->input->post('km_akhir');

        $data = [
            'km_akhir' => $km_akhir,
            'tgl_input_km_akhir' => $this->datetime,
        ];

        $result = $this->db->update('peminjaman_kendaraan', $data, ['id' => $id]);

        $datadriver = $this->kendaraan->datadriver($id);

        if ($result) :
            echo json_encode(array(
                'status' => true,
                'datadriver' => $datadriver,
                'message' => 'Berhasil mengubah data'
            ));
        else :
            echo json_encode(array(
                'status' => false,
                'message' => 'Gagal mengubah data'
            ));
        endif;
    }

    function ubah_status() 
    {
        $id = $this->input->post('id', true);
        $status = $this->input->post('status', true);

        $status_ = '';
        if ($status === 'Disetujui') :
            $status_ = 'Selesai';
        endif;
        
        $data = array(
            'id' => $id,
            'status_dokumen' => $status_
        );

        $data_ = $this->kendaraan->ubah_status_kendaraan($data);
        $datadriver = $this->kendaraan->datadriver($id);
        if ($data_) :
            echo json_encode(array(
                'status' => true,
                'datadriver' => $datadriver['driver'],
                'message' => 'Berhasil mengubah status peminjaman kendaraan'
            ));
        else :
            echo json_encode(array(
                'status' => false,
                'message' => 'Gagal mengubah status peminjaman kendaraan'
            ));
        endif;
    }
}
