<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Persetujuan extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;

        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_persetujuan', 'm_persetujuan');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function index()
    {
        $this->template->add_title_segment('Setting Persetujuan');

        $data = array(
            'active'          => 'setting-persetujuan',
            'breadcrumb'      => 'Setting Persetujuan',
        );

        $this->template->render('index', $data);
    }
    
    function get_data_select_divisi()
    {
        $data = $this->m_persetujuan->get_data_divisi();
        echo json_encode($data);
    }

    function get_data_select_kategori_divisi()
    {
        $data = $this->m_persetujuan->get_data_kategori_divisi();
        echo json_encode($data);
    }

    function get_data_select_users()
    {
        $data = $this->m_persetujuan->get_data_users();
        echo json_encode($data);
    }

    function simpan_setting_persetujuan()
    {  
        $this->db->truncate('setting_persetujuan');

        // dokumen pminjaman kendaraan
        $document_type_kendaraan       = $this->input->post('document_type_kendaraan', true);
        $label_kendaraan               = $this->input->post('label_kendaraan', true);
        $filter_divisi_kendaraan       = $this->input->post('filter_divisi_kendaraan', true);
        $divisi_kendaraan              = $this->input->post('divisi_kendaraan', true);
        $users_kendaraan               = $this->input->post('users_kendaraan', true);
        $kondisi_persetujuan_kendaraan = $this->input->post('kondisi_persetujuan_kendaraan', true);
        
        $data1 = array();
        $index1 = 0;
        foreach ($label_kendaraan as $data_label_kendaraan) :
            array_push($data1, array(
                'tipe_dokumen'  => $document_type_kendaraan,
                'label'         => $data_label_kendaraan,
                'filter_divisi' => $filter_divisi_kendaraan[$index1],
                'tipe_approval' => $kondisi_persetujuan_kendaraan[$index1],
                'id_divisi'     => $divisi_kendaraan[$index1],
                'id_users'      => $users_kendaraan[$index1],
                'order'         => $index1 + 1,
                'status'        => 1,
                'created_by'    => $this->session->userdata('id'),
                'created_date'  => date('Y-m-d H:i:s'),
            ));

            $index1++;
        endforeach;

        $result = $this->m_persetujuan->simpan_data_batch($data1);
        // end dokumen peminjaman kendaraan

        // dokumen peminjaman ruangan
        $document_type_ruangan       = $this->input->post('document_type_ruangan', true);
        $label_ruangan               = $this->input->post('label_ruangan', true);
        $filter_divisi_ruangan       = $this->input->post('filter_divisi_ruangan', true);
        $divisi_ruangan              = $this->input->post('divisi_ruangan', true);
        $users_ruangan               = $this->input->post('users_ruangan', true);
        $kondisi_persetujuan_ruangan = $this->input->post('kondisi_persetujuan_ruangan', true);
        
        $data2 = array();
        $index2 = 0;
        foreach ($label_ruangan as $data_label_ruangan) :
            array_push($data2, array(
                'tipe_dokumen'  => $document_type_ruangan,
                'label'         => $data_label_ruangan,
                'filter_divisi' => $filter_divisi_ruangan[$index2],
                'tipe_approval' => $kondisi_persetujuan_ruangan[$index2],
                'id_divisi'     => $divisi_ruangan[$index2],
                'id_users'      => $users_ruangan[$index2],
                'order'         => $index2 + 1,
                'status'        => 1,
                'created_by'    => $this->session->userdata('id'),
                'created_date'  => date('Y-m-d H:i:s'),
            ));

            $index2++;
        endforeach;

        $result = $this->m_persetujuan->simpan_data_batch($data2);
        // end dokumen peminjaman ruangan
        
        if ($result) :
            $data = array(
                'status' => true,
                'message' => 'Berhasil menyimpan data'
            );

            echo json_encode($data);
        else :
            $data = array(
                'status' => false,
                'message' => 'Gagal menyimpan data'
            );

            echo json_encode($data);
        endif;
        
    }

    function get_list_data_persetujuan_kendaraan()
    {
        $data = $this->m_persetujuan->get_data_persetujuan_kendaraan();
        echo json_encode($data);
    }

    function get_list_data_persetujuan_ruangan()
    {
        $data = $this->m_persetujuan->get_data_persetujuan_ruangan();
        echo json_encode($data);
    }
}
