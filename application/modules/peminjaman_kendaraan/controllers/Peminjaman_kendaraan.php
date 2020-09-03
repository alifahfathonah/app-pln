<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Peminjaman_kendaraan extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_peminjaman_kendaraan', 'm_peminjaman_kendaraan');
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
            'status_dokumen' => $this->m_auto->get_status_dokumen()
        );

        $this->template->render('index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->m_peminjaman_kendaraan->get_datatables($sort, $order);
        foreach ($list as $l) :

            if ($l->dokumen_status === 'Menunggu') :
                $dokumen_status = '<span class="badge badge-warning"><i class="fas fa-spinner fa-spin mr-2"></i>' . $l->dokumen_status . '</span>';
            elseif ($l->dokumen_status === 'Disetujui') :
                $dokumen_status = '<span class="badge badge-success"><i class="fas fa-thumbs-up mr-2"></i>' . $l->dokumen_status . '</span>';
            elseif ($l->dokumen_status === 'Ditolak') :
                $dokumen_status = '<span class="badge badge-danger"><i class="fas fa-ban mr-2"></i>' . $l->dokumen_status . '</span>';
            endif;

            $no++;
            $l->no            = $no;
            $l->no_dokumen    = $l->no_dokumen;
            $l->kendaraan     = $l->nopol . " - " .$l->kendaraan;
            $l->tujuan        = $l->tujuan;
            $l->diajukan_oleh = $l->diajukan_oleh;
            $l->created_date  = $l->created_date;
            $l->status        = $dokumen_status;
            $l->aksi = '<div class="right">
                    <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                    <button type="button" onclick="ubah_data(' . $l->id . ')" title="Ubah Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                </div>';

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->m_peminjaman_kendaraan->count_all($sort, $order),
            "recordsFiltered"   => $this->m_peminjaman_kendaraan->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data['peminjam'] = $this->m_peminjaman_kendaraan->get_data_by_id($id);
        $data['personil'] = $this->m_peminjaman_kendaraan->get_data_personil($id);
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
        
        $id_peminjaman_kendaraan = $this->m_peminjaman_kendaraan->simpan_data_peminjaman_kendaraan($data_peminjaman_kendaraan);

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

        $data = $this->m_peminjaman_kendaraan->save_batch_data_personil_peminjaman_kendaraan($data_personil);

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

        $data = $this->m_peminjaman_kendaraan->save_batch_data_persetujuan_peminjaman_kendaraan($data_persetujuan);

        if ($data) :
            echo json_encode(array(
                'status' => $data,
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
        
        $id_peminjaman_kendaraan = $this->m_peminjaman_kendaraan->update_data_peminjaman_kendaraan($data_peminjaman_kendaraan, $this->input->post('id', true));
          
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
        $data = $this->m_peminjaman_kendaraan->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }
}
