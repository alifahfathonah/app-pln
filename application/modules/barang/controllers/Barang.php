<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Barang extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_barang', 'm_barang');
    }

    function index()
    {
        $this->template->add_title_segment('Masterdata Barang');

        $data = array(
            'active'     => 'master-barang',
            'breadcrumb' => 'Masterdata Barang',
            'modal'      => array('barang/modal'),
        );
        $this->template->render('index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->m_barang->get_datatables($sort, $order);
        foreach ($list as $l) :
            $no++;
            $l->no   = $no;
            $l->nama = $l->nama;
            $l->satuan = $l->satuan;
            $l->aksi = '<div class="right">
                    <button type="button" onclick="ubah_data(' . $l->id . ')" title="Ubah Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                </div>';

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->m_barang->count_all($sort, $order),
            "recordsFiltered"   => $this->m_barang->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_barang->get_data_by_id($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        $this->form_validation->set_rules('nama', 'nama', 'required');

        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        if (form_error('nama')) $error[] = 'nama';

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
            'nama'   => $this->input->post('nama', true),
            'satuan' => $this->input->post('satuan', true)
        );
        
        $data = $this->m_barang->simpan_data($request);
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

        $request = array(
            'id'     => $this->input->post('id', true),
            'nama'   => $this->input->post('nama', true),
            'satuan' => $this->input->post('satuan', true)
        );

        $data = $this->m_barang->update_data($request);
        if ($data) :
            echo json_encode(array(
                'status' => $data,
                'message' => 'Berhasil mengubah data'
            ));
        else :
            echo json_encode(array(
                'status' => $data,
                'message' => 'Gagal mengubah data'
            ));
        endif;
    }

    function ajax_delete()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_barang->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }
}
