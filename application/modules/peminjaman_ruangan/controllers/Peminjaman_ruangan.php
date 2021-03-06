<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Peminjaman_ruangan extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_peminjaman_ruangan', 'm_peminjaman_ruangan');
        $this->load->model('persetujuan/M_persetujuan', 'm_persetujuan');
        $this->load->model('auto/M_auto', 'm_auto');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function index()
    {
        $this->template->add_title_segment('Peminjaman Ruangan');

        $dariDB = $this->m_auto->cek_no_dokumen_ruangan();
        // contoh FM-SMK3-VHC-0001, angka 3 adalah awal pengambilan angka, dan 4 jumlah angka yang diambil
        $nourut = substr($dariDB, 12, 4);
        $no_dokumen_sekarang = $nourut + 1;

        $data = array(
            'active'         => 'peminjaman-ruangan',
            'breadcrumb'     => 'Peminjaman ruangan',
            'modal'          => array('peminjaman_ruangan/modal'),
            'no_dokumen'     => $no_dokumen_sekarang,
            'persetujuan'    => $this->m_persetujuan->get_data_persetujuan_ruangan(),
            'status_dokumen' => $this->m_auto->get_status_dokumen(),
            'ruangan'        => $this->m_auto->get_ruangan()
        );

        $this->template->render('index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'no_dokumen';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->m_peminjaman_ruangan->get_datatables($sort, $order);
        foreach ($list as $l) :

            if ($l->status_dokumen === 'Menunggu') :
                $status_dokumen = '<span class="badge badge-warning"><i class="fas fa-spinner fa-spin mr-2"></i>' . $l->status_dokumen . '</span>';
            elseif ($l->status_dokumen === 'Disetujui') :
                $status_dokumen = '<span class="badge badge-success"><i class="fas fa-thumbs-up mr-2"></i>' . $l->status_dokumen . '</span>';
            elseif ($l->status_dokumen === 'Ditolak') :
                $status_dokumen = '<span class="badge badge-danger"><i class="fas fa-ban mr-2"></i>' . $l->status_dokumen . '</span>';
            endif;

            $no++;
            $l->no            = $no;
            $l->no_dokumen    = $l->no_dokumen;
            $l->ruangan       = $l->ruangan;
            $l->nama_kegiatan = $l->nama_kegiatan;
            $l->status        = $status_dokumen;
            $l->aksi = '<div class="right">
                    <button type="button" onclick="ubah_data(' . $l->id . ')" title="Ubah Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                </div>';

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->m_peminjaman_ruangan->count_all($sort, $order),
            "recordsFiltered"   => $this->m_peminjaman_ruangan->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data['peminjam'] = $this->m_peminjaman_ruangan->get_data_by_id($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        $this->form_validation->set_rules('ruangan', 'ruangan', 'required');
        $this->form_validation->set_rules('nama_kegiatan', 'nama kegiatan', 'required');
        $this->form_validation->set_rules('makan_siang', 'makan siang', 'required');
        $this->form_validation->set_rules('snack', 'snack', 'required');
        $this->form_validation->set_rules('users', 'diajukan oleh', 'required');
       
        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        if (form_error('ruangan')) $error[] = 'ruangan';
        if (form_error('nama_kegiatan')) $error[] = 'nama_kegiatan';
        if (form_error('makan_siang')) $error[] = 'makan_siang';
        if (form_error('snack')) $error[] = 'snack';
        if (form_error('users')) $error[] = 'users';


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

        // echo json_encode($this->input->post()); die;
        
        $data_peminjaman_ruangan = array(
            'no_dokumen'           => $this->input->post('no_dokumen'),
            'id_ruangan'           => $this->input->post('ruangan', true)?: NULL,
            'nama_kegiatan'        => $this->input->post('nama_kegiatan', true),
            'jumlah_orang'         => $this->input->post('jumlah_orang', true),
            'id_makan_siang'       => $this->input->post('makan_siang', true)?: NULL,
            'id_snack'             => $this->input->post('snack', true)?: NULL,
            'keterangan'           => $this->input->post('keterangan', true),
            'tgl_start'            => datetime2mysql($this->input->post('tgl_start', true)) . ":00",
            'tgl_end'              => datetime2mysql($this->input->post('tgl_end', true)) . ":00",
            'id_users'             => $this->input->post('users', true),
            'created_by'           => $this->session->userdata('id'),
            'created_date'         => $this->datetime,  
        );
        
        $id_peminjaman_ruangan = $this->m_peminjaman_ruangan->simpan_data_peminjaman_ruangan($data_peminjaman_ruangan);

        $atasan          = $this->input->post('atasan', true);
        $data_persetujuan = array();

        $index = 0;
        foreach($atasan as $dataatasan) :
            array_push($data_persetujuan, array(
                'id_peminjaman_ruangan'   => $id_peminjaman_ruangan,
                'id_users'                => $dataatasan,
                'created_date'            => $this->datetime,
            ));
            
            $index++;
        endforeach;

        $data = $this->m_peminjaman_ruangan->save_batch_data_persetujuan_peminjaman_ruangan($data_persetujuan);

        $telp_spv = $this->db->select('telp_wa')
                                ->from('users')
                                ->where('id', $atasan[0])
                                ->get()
                                ->row()
                                ->telp_wa;

        $pesan_wa = $this->session->userdata('nama') . ' mengajukan peminjaman ruangan pada tanggal :  ' . $this->input->post('tgl_start', true) . ":00" . ' s/d '. $this->input->post('tgl_end', true) . ":00";
        if ($data) :
            echo json_encode(array(
                'status' => $data,
                'telp_spv' => $telp_spv,
                'pesan_wa' => $pesan_wa,
                'message' => 'Berhasil menyimpan data'
            ));
        else :
            echo json_encode(array(
                'status' => $data,
                'message' => 'Gagal menyimpan data'
            ));
        endif;
    }

    function ajax_delete()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_peminjaman_ruangan->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }

    function ajax_put()
    {
        $this->_validasi();

        $data_peminjaman_ruangan = array(
            'id'                   => $this->input->post('id', true),
            'id_ruangan'           => $this->input->post('ruangan', true)?: NULL,
            'nama_kegiatan'        => $this->input->post('nama_kegiatan', true),
            'jumlah_orang'         => $this->input->post('jumlah_orang', true),
            'id_makan_siang'       => $this->input->post('makan_siang', true)?: NULL,
            'id_snack'             => $this->input->post('snack', true)?: NULL,
            'keterangan'           => $this->input->post('keterangan', true),
            'tgl_start'            => datetime2mysql($this->input->post('tgl_start', true)) . ":00",
            'tgl_end'              => datetime2mysql($this->input->post('tgl_end', true)) . ":00",
            'id_users'             => $this->input->post('users', true),
            'modified_date'        => $this->datetime,  
        );
        
        $id_peminjaman_ruangan = $this->m_peminjaman_ruangan->update_data_peminjaman_ruangan($data_peminjaman_ruangan, $this->input->post('id', true));

        if ($id_peminjaman_ruangan) :
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
}