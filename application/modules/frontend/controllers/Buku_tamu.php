<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_tamu extends SM_Controller {

    
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->datetime = date('Y-m-d H:i:s');
        $this->load->model('auto/M_auto', 'auto');
        $this->load->model('Buku_tamu_model', 'bukutamu');
        $this->template->set_layout('templates/frontend/index');
    }
    
    function index()
    {
        $this->template->add_title_segment( 'Buku Tamu');
        
        $data = array(
            'active'  => 'buku-tamu',
            'atasan'  => $this->auto->get_atasan_select(),
            'petugas' => $this->auto->get_petugas_select()
        );
        
        $this->template->render('buku_tamu/index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->bukutamu->get_datatables($sort, $order);
        foreach ($list as $l) :
            $no++;
            $l->no   = $no;
            $l->nama = $l->nama;
            $l->unit = $l->unit;
            if ($l->tanggal_keluar != '-') :
                $l->aksi = '';
            else :
                $l->aksi = '<div class="right">
                        <button type="button" onclick="status_keluar(' . $l->id . ')" title="End Kunjungan" class="btn btn-shadow btn-danger btn-xs"><i class="fas fa-sign-out-alt"></i></button>
                        <button type="button" onclick="edit_data(' . $l->id . ')" title="Edit Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-edit"></i></button>
                    </div>';
            endif;

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->bukutamu->count_all($sort, $order),
            "recordsFiltered"   => $this->bukutamu->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data = $this->bukutamu->get_data_by_id($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('keperluan', 'keperluan', 'required');
        $this->form_validation->set_rules('atasan', 'atasan', 'required');
        $this->form_validation->set_rules('petugas', 'petugas', 'required');
      
       
        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        if (form_error('nama')) $error[] = 'nama';
        if (form_error('keperluan')) $error[] = 'keperluan';
        if (form_error('atasan')) $error[] = 'atasan';
        if (form_error('petugas')) $error[] = 'petugas';

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

        $data = array(
            'nama'              => $this->input->post('nama', true),
            'unit'              => $this->input->post('unit', true),
            'no_identitas'      => $this->input->post('no_identitas', true) ?: NULL,
            'no_polisi'         => $this->input->post('no_polisi', true) ?: NULL,
            'id_atasan'         => $this->input->post('atasan', true),
            'keperluan'         => $this->input->post('keperluan', true),
            'id_petugas_masuk'  => $this->input->post('petugas', true),
            'term'              => 1,
            'tanggal_kunjungan' => $this->datetime
        );
        
        $telp_atasan = $this->db->select('telp_wa')
                                ->from('users')
                                ->where('id', $data['id_atasan'])
                                ->get()
                                ->row()
                                ->telp_wa;
        $pesan_wa = $data['nama'] . ' membuat janji ingin bertemu dengan anda';

        $data = $this->bukutamu->simpan_data($data);


        if ($data) :
            echo json_encode(array(
                'status'      => true,
                'telp_atasan' => $telp_atasan,
                'pesan_wa'    => $pesan_wa,
                'message'     => 'Berhasil menyimpan data'
            ));
        else :
            echo json_encode(array(
                'status'  => false,
                'message' => 'Gagal menyimpan data'
            ));
        endif;
    }

    function ajax_put()
    {
        $this->_validasi();

        $data = array(
            'id'                => $this->input->post('id', true),
            'nama'              => $this->input->post('nama', true),
            'unit'              => $this->input->post('unit', true),
            'no_identitas'      => $this->input->post('no_identitas', true) ?: NULL,
            'no_polisi'         => $this->input->post('no_polisi', true) ?: NULL,
            'id_atasan'         => $this->input->post('atasan', true),
            'keperluan'         => $this->input->post('keperluan', true),
            'id_petugas_masuk'  => $this->input->post('petugas', true),
        );

        $data = $this->bukutamu->update_data($data);

        if ($data) :
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

    function update_status_keluar()
    {
        $data = array(
            'id'                => $this->input->post('id', true),
            'id_petugas_keluar' => $this->input->post('petugas', true),
            'tanggal_keluar'    => $this->datetime,
        );

        $data = $this->bukutamu->update_data($data);
        if ($data) :
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