<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auto extends SM_Controller {

    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->limit = 20;
        $this->load->model('M_auto', 'm_auto');        
    }
    
    private function start($page)
    {
        return (($page - 1) * $this->limit);
    }

    function get_auto_divisi()
    {
        $q = $this->input->get('q', true);
        $start = $this->start($this->input->get('page', true));
        $data = $this->m_auto->get_auto_divisi($q, $start, $this->limit);
        if (($this->input->get('page', true) == 1) & ($q == '')) {
            $pilih[] = array('id' => '', 'nama' => ' ', 'kategori_divisi' => '');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        echo json_encode($data);
    }

    function get_auto_kendaraan()
    {
        $q = $this->input->get('q', true);
        $start = $this->start($this->input->get('page', true));
        $data = $this->m_auto->get_auto_kendaraan($q, $start, $this->limit);
        if (($this->input->get('page', true) == 1) & ($q == '')) {
            $pilih[] = array('id' => '', 'nopol' => ' ', 'nama' => '');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        echo json_encode($data);
    }

    function get_auto_driver()
    {
        $q = $this->input->get('q', true);
        $start = $this->start($this->input->get('page', true));
        $data = $this->m_auto->get_auto_driver($q, $start, $this->limit);
        if (($this->input->get('page', true) == 1) & ($q == '')) {
            $pilih[] = array('id' => '', 'nama' => ' ', 'divisi' => '');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        echo json_encode($data);
    }

    function get_auto_atasan()
    {
        $q = $this->input->get('q', true);
        $start = $this->start($this->input->get('page', true));
        $data = $this->m_auto->get_auto_atasan($q, $start, $this->limit);
        if (($this->input->get('page', true) == 1) & ($q == '')) {
            $pilih[] = array('id' => '', 'nama' => '', 'divisi' => '');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        echo json_encode($data);
    }

    function get_auto_snack()
    {
        $q = $this->input->get('q', true);
        $start = $this->start($this->input->get('page', true));
        $data = $this->m_auto->get_auto_snack($q, $start, $this->limit);
        if (($this->input->get('page', true) == 1) & ($q == '')) {
            $pilih[] = array('id' => '', 'nama' => '');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        echo json_encode($data);
    }

    function get_auto_makan_siang()
    {
        $q = $this->input->get('q', true);
        $start = $this->start($this->input->get('page', true));
        $data = $this->m_auto->get_auto_makan_siang($q, $start, $this->limit);
        if (($this->input->get('page', true) == 1) & ($q == '')) {
            $pilih[] = array('id' => '', 'nama' => '');
            $data['data'] = array_merge($pilih, $data['data']);
            $data['total'] += 1;
        }
        echo json_encode($data);
    }

    function get_barang() 
    {
        $data = $this->m_auto->get_barang();
        echo json_encode($data);
    }

    function get_barang_by_id() 
    {
        $id = $this->input->get('id', true);
        $data = $this->m_auto->get_barang_by_id($id);
        echo json_encode($data);
    }
}
