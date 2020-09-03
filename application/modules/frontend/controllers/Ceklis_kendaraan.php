<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ceklis_kendaraan extends SM_Controller {

    
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->load->model('auto/M_auto', 'auto');
        $this->load->model('Ceklis_kendaraan_model', 'ceklis');
        $this->template->set_layout('templates/frontend/index');
    }
    
    function index()
    {
        $this->template->add_title_segment( 'Form Ceklis Kendaraan');
        
        $data = array(
            'active'          => 'form-ceklis-kendaraan',
            'komponen'        => $this->ceklis->get_komponen_ceklis(), 
            'kendaraan'       => $this->auto->get_kendaraan_select(), 
            'jenis_kendaraan' => $this->auto->get_jenis_kendaraan() 
        );
        
        $this->template->render('ceklis_kendaraan/index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'no_plat';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->ceklis->get_datatables($sort, $order);
        foreach ($list as $l) :

            if ($l->kondisi === '1') :
                $kondisi = 'Terima';
            elseif ($l->kondisi === '2') :
                $kondisi = 'Pengembalian';
            endif;

            $no++;
            $l->no      = $no;
            $l->no_plat = $l->no_plat;
            $l->kondisi = $kondisi;
            $l->aksi = '<div class="right">
                    <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                    <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                </div>';

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->ceklis->count_all($sort, $order),
            "recordsFiltered"   => $this->ceklis->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data = $this->ceklis->get_data_by_id($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        $this->form_validation->set_rules('no_plat', 'no plat', 'required');
        // $this->form_validation->set_rules('type_kendaraan', 'type kendaraan', 'required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
      
       
        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        if (form_error('no_plat')) $error[] = 'no_plat';
        // if (form_error('type_kendaraan')) $error[] = 'type_kendaraan';
        if (form_error('tanggal')) $error[] = 'tanggal';

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
            'id_kendaraan'       => $this->input->post('no_plat', true),
            'id_jenis_kendaraan' => $this->input->post('type_kendaraan', true)?: NULL,
            'tanggal'            => date2mysql($this->input->post('tanggal', true)),
            'kondisi'            => $this->input->post('kondisi', true),
            'catatan'            => $this->input->post('catatan', true) ?: NULL,
        );

        $id_ceklis = $this->ceklis->simpan_data($data);

        $komponen = $this->input->post('komponen', true);
        $cek = $this->input->post('cek', true);
        $data_ceklis = array();
        
        $index = 0;
        foreach($komponen as $key => $datakomponen) :
            array_push($data_ceklis, array(
                'id_ceklis_kendaraan'     => $id_ceklis,
                'cek_value'               => $cek[$key],
                'id_list_komponen_ceklis' => $datakomponen,
            ));
            
            $index++;
        endforeach;

        $this->ceklis->simpan_data_batch($data_ceklis);
         
        if ($id_ceklis) :
            echo json_encode(array(
                'status' => true,
                'message' => 'Berhasil menyimpan data'
            ));
        else :
            echo json_encode(array(
                'status' => false,
                'message' => 'Gagal menyimpan data'
            ));
        endif;
    }

    function ajax_delete()
    {
        $id = $this->input->get('id', true);
        $data = $this->ceklis->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }

}