<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class SM_Controller extends MX_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helpers(array('url', 'form', 'html', 'function', 'captcha'));
        $this->load->library(array('session', 'template'));
        $this->load->model('M_query');
    }
    
}
