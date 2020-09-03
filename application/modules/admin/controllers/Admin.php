<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends SM_Controller {

    
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
    }
    
    function index()
    {
        $this->template->add_title_segment( 'Dashboard');

        $data = array(
            'active' => 'Dashboard'
        );
        $this->template->render('index', $data);
    }

}

/* End of file Admin.php */
