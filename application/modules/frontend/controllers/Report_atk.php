<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_atk extends SM_Controller {

    
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->datetime = date('Y-m-d H:i:s');
        $this->load->model('auto/M_auto', 'auto');
        $this->load->model('Report_atk_model', 'report_atk');
        $this->template->set_layout('templates/frontend/index');
    }
    
    function index()
    {
        $this->template->add_title_segment('Laporan ATK');
        
        $data = array(
            'active'  => 'report-atk',
            'divisi'  => $this->auto->get_divisi_select()
        );
        
        $this->template->render('atk/report/index', $data);
    }

    function print_pdf()
    {
        $search = array(
            'no_notadinas' => $this->input->get('no_notadinas', true),
            'tanggal_awal' => $this->input->get('tanggal_awal', true),
            'tanggal_akhir' => $this->input->get('tanggal_akhir', true),
            'divisi' => $this->input->get('divisi', true),
        );

        $dompdf = new Dompdf\Dompdf();
        $dompdf->set_option('isRemoteEnabled', TRUE);
        $data['atk'] = $this->report_atk->get_data_atk($search);
        // echo json_encode($data); die;
        
        $html = $this->load->view('atk/report/pdf', $data, true);
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');
        // Render the HTML as PDF
        $dompdf->render();
        
        // // Get the generated PDF file contents
        // $pdf = $dompdf->output();
        
        // Output the generated PDF to Browser
        $dompdf->stream("Data ATK.pdf", array('Attachment' => 0));
    }

}