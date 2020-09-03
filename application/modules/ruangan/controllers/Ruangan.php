<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ruangan extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_ruangan', 'm_ruangan');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function index()
    {
        $this->template->add_title_segment('Masterdata Ruangan');

        $data = array(
            'active' => 'master-ruangan',
            'breadcrumb' => 'Masterdata Ruangan',
            'modal'      => array('ruangan/modal'),
        );
        $this->template->render('index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->m_ruangan->get_datatables($sort, $order);
        foreach ($list as $l) :
            $no++;
            $l->no   = $no;
            $l->nama = $l->nama;
            $l->aksi = '<div class="right">
                    <button type="button" onclick="ubah_data(' . $l->id . ')" title="Ubah Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                </div>';

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->m_ruangan->count_all($sort, $order),
            "recordsFiltered"   => $this->m_ruangan->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_ruangan->get_data_by_id($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        $this->form_validation->set_rules('kode', 'kode', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('kapasitas', 'kapasitas', 'numeric');
        $this->form_validation->set_rules('panjang', 'panjang', 'numeric');
        $this->form_validation->set_rules('lebar', 'lebar', 'numeric');
        

        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        if (form_error('kode')) $error[] = 'kode';
        if (form_error('nama')) $error[] = 'nama';
        if (form_error('kapasitas')) $error[] = 'kapasitas';
        if (form_error('panjang')) $error[] = 'panjang';
        if (form_error('lebar')) $error[] = 'lebar';

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

        $request = array(
            'kode'         => $this->input->post('kode', true),
            'nama'         => $this->input->post('nama', true),
            'kapasitas'    => $this->input->post('kapasitas', true),
            'panjang'      => $this->input->post('panjang', true),
            'lebar'        => $this->input->post('lebar', true),
            'foto'         => $this->input->post('nama_foto', true),
            'status'       => $this->input->post('status', true),
            'created_date' => $this->datetime,
        );
        
        $data = $this->m_ruangan->simpan_data($request);
        if ($data) :
            echo json_encode(array(
                'status'  => $data,
                'message' => 'Berhasil menyimpan data'
            ));
        else :
            echo json_encode(array(
                'status'  => $data,
                'message' => 'Gagal menyimpan data'
            ));
        endif;
    }

    function ajax_put() 
    {
        $this->_validasi();

        $request = array(
            'id'            => $this->input->post('id', true),
            'kode'          => $this->input->post('kode', true),
            'nama'          => $this->input->post('nama', true),
            'kapasitas'     => $this->input->post('kapasitas', true),
            'panjang'       => $this->input->post('panjang', true),
            'lebar'         => $this->input->post('lebar', true),
            'foto'          => $this->input->post('nama_foto', true),
            'status'        => $this->input->post('status', true),
            'modified_date' => $this->datetime
        );

        $data = $this->m_ruangan->update_data($request);
        if ($data) :
            echo json_encode(array(
                'status'  => $data,
                'message' => 'Berhasil mengubah data'
            ));
        else :
            echo json_encode(array(
                'status'  => $data,
                'message' => 'Gagal mengubah data'
            ));
        endif;
    }

    function ajax_delete()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_ruangan->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }

    function ajax_upload()
    {
        if (!empty($_FILES['foto']['name'])) :
            $config['upload_path']          = 'assets/upload/';
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 1024; //set max size allowed in Kilobyte
            $config['overwrite']            = TRUE;
            // $config['encrypt_name']         = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('foto')) :
                $data['error'] = 'Terjadi Kesalahan | ' . $this->upload->display_errors();
                $data['status'] = false;

                die(json_encode($data));
            else :
                $data['status'] = true;
                $data['file_name'] = $this->upload->data('file_name');
                $data['success'] = 'Proses Upload Telah Berhasil';
                die(json_encode($data));
            endif;
        else :
            die(json_encode(['status' => false]));
        endif;
    }

    function ajax_delete_image_old()
    {
        if (($_POST['file_tmp'] !== NULL) && ($_POST['file_tmp'] !== "")) {
            $file = 'assets/upload/' . $_POST['file_tmp'];
            unlink($file);
            echo json_encode(array('status' => TRUE));
        } else {
            echo json_encode(array('status' => FALSE));
        }
    }
}
