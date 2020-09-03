<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cabang extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_cabang', 'm_cabang');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function index()
    {
        $this->template->add_title_segment('Masterdata Cabang');

        $data = array(
            'active' => 'master-cabang',
            'breadcrumb' => 'Masterdata Cabang',
            'modal'      => array('cabang/modal'),
        );
        $this->template->render('index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->m_cabang->get_datatables($sort, $order);
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
            "recordsTotal"      => $this->m_cabang->count_all($sort, $order),
            "recordsFiltered"   => $this->m_cabang->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_cabang->get_data_by_id($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('telp', 'telp', 'numeric');
        $this->form_validation->set_rules('fax', 'fax', 'numeric');
        $this->form_validation->set_rules('email', 'email', 'valid_email');

        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        if (form_error('nama')) $error[] = 'nama';
        if (form_error('telp')) $error[] = 'telp';
        if (form_error('fax')) $error[] = 'fax';
        if (form_error('email')) $error[] = 'email';

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
            'nama'           => $this->input->post('nama', true),
            'telp'           => $this->input->post('telp', true),
            'fax'            => $this->input->post('fax', true),
            'email'          => $this->input->post('email', true),
            'alamat'         => $this->input->post('alamat', true),
            'keterangan'     => $this->input->post('keterangan', true),
            'is_head_office' => $this->input->post('head_office', true),
            'logo'           => $this->input->post('nama_logo', true),
            'status'         => $this->input->post('status', true),
            'created_by'     => $this->session->userdata('id'),
            'created_date'   => $this->datetime,
        );
        
        $data = $this->m_cabang->simpan_data($request);
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
            'id'             => $this->input->post('id', true),
            'nama'           => $this->input->post('nama', true),
            'telp'           => $this->input->post('telp', true),
            'fax'            => $this->input->post('fax', true),
            'email'          => $this->input->post('email', true),
            'alamat'         => $this->input->post('alamat', true),
            'keterangan'     => $this->input->post('keterangan', true),
            'is_head_office' => $this->input->post('head_office', true),
            'logo'           => $this->input->post('nama_logo', true),
            'status'         => $this->input->post('status', true),
            'modified_date'  => $this->datetime
        );

        $data = $this->m_cabang->update_data($request);
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
        $data = $this->m_cabang->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }

    function ajax_upload()
    {
        if (!empty($_FILES['logo']['name'])) :
            $config['upload_path']          = 'assets/upload/';
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 1024; //set max size allowed in Kilobyte
            $config['overwrite']            = TRUE;
            // $config['encrypt_name']         = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('logo')) :
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
