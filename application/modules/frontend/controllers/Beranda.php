<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends SM_Controller {

    
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->load->model('Beranda_model', 'beranda');
        $this->template->set_layout('templates/frontend/index');
    }
    
    function index()
    {
        $this->template->add_title_segment( 'Beranda');
        
        $data = array(
            'active'          => 'beranda', 
            'count_ceklis'    => $this->beranda->count_ceklis_kendaraan(),
            'count_tamu'      => $this->beranda->count_buku_tamu(),
            'count_ruangan'   => $this->beranda->count_ruangan(),
            'count_kendaraan' => $this->beranda->count_kendaraan()
        );
        $this->template->render('beranda/index', $data);
    }

}