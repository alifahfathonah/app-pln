<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Atk extends SM_Controller {

    
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->datetime = date('Y-m-d H:i:s');
        $this->load->model('auto/M_auto', 'auto');
        $this->load->model('Atk_model', 'atk');
        $this->template->set_layout('templates/frontend/index');
    }
    
    function index()
    {
        $this->template->add_title_segment('ATK');
        
        $data = array(
            'active'  => 'atk',
        );
        
        $this->template->render('atk/index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'no-notadinas';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->atk->get_datatables($sort, $order);
        foreach ($list as $l) :
            $no++;
            $l->no           = $no;
            $l->tanggal      = $l->tanggal;
            $l->no_notadinas = $l->no_notadinas;
            $l->users        = $l->users;
            $l->aksi = '<div class="right">
                    <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                </div>';
            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->atk->count_all($sort, $order),
            "recordsFiltered"   => $this->atk->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data = $this->atk->get_data_by_id($id);
        echo json_encode($data);
    }

    function ajax_post()
    {

        $data = array(
            'tanggal'      => datetime2mysql($this->input->post('tanggal', true)),
            'id_user'      => $this->input->post('id_users', true),
            'no_notadinas' => $this->input->post('no_notadinas', true),
        );
        
        $id = $this->atk->simpan_data($data);

        $barang   = $this->input->post('id_barang', true); 
        $qty_req  = $this->input->post('qty_req', true); 
        $qty_appv = $this->input->post('qty_appv', true); 
       
        $data_detail = array();

        $index = 0;
        foreach($barang as $databarang) :
            array_push($data_detail, array(
                'id_atk'       => $id,
                'id_barang'    => $databarang,
                'qty_request'  => $qty_req[$index],
                'qty_approval' => $qty_appv[$index],
            ));
            
            $index++;
        endforeach;

        $data = $this->atk->save_batch_data_detail($data_detail);

        if ($data) :
            echo json_encode(array(
                'status'      => true,
                'message'     => 'Berhasil menyimpan data'
            ));
        else :
            echo json_encode(array(
                'status'  => false,
                'message' => 'Gagal menyimpan data'
            ));
        endif;
    }

}