<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Permohonan_peminjaman_ruangan extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_permohonan_peminjaman_ruangan', 'm_ppr');
        $this->load->model('persetujuan/M_persetujuan', 'm_persetujuan');
        $this->load->model('auto/M_auto', 'm_auto');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function index()
    {
        $this->template->add_title_segment('Permohonan Peminjaman Ruangan');
        $this->template->add_js(base_url() . 'assets/js/jq-signature.min.js');

        $data = array(
            'active'         => 'permohonan-peminjaman-ruangan',
            'breadcrumb'     => 'Permohonan Peminjaman ruangan',
            'modal'          => array('permohonan_peminjaman_ruangan/modal'),
            'persetujuan'    => $this->m_persetujuan->get_data_persetujuan_ruangan(),
            'status_dokumen' => $this->m_auto->get_status_dokumen(),
            'ruangan'        => $this->m_auto->get_ruangan()
        );

        $this->template->render('index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'no_dokumen';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->m_ppr->get_datatables($sort, $order);
        foreach ($list as $l) :

            if ($l->status_dokumen === 'Menunggu') :
                $status_dokumen = '<span class="badge badge-warning"><i class="fas fa-spinner fa-spin mr-2"></i>' . $l->status_dokumen . '</span>';
            elseif ($l->status_dokumen === 'Disetujui') :
                $status_dokumen = '<span class="badge badge-success"><i class="fas fa-thumbs-up mr-2"></i>' . $l->status_dokumen . '</span>';
            elseif ($l->status_dokumen === 'Ditolak') :
                $status_dokumen = '<span class="badge badge-danger"><i class="fas fa-ban mr-2"></i>' . $l->status_dokumen . '</span>';
            endif;

            $no++;
            $l->no            = $no;
            $l->no_dokumen    = $l->no_dokumen;
            $l->ruangan       = $l->ruangan;
            $l->nama_kegiatan = $l->nama_kegiatan;
            $l->status        = $status_dokumen;
            $l->atasan        = $l->atasan;

            if ($l->status_dokumen === 'Disetujui') :
                $l->aksi = '<div class="right">
                            <button type="button" onclick="send_notif_to_bos(' . $l->id_users . ')" title="Kirim Notifikasi Ke Atasan Pembuat" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-paper-plane"></i></button>
                            <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                        </div>';
            else :
                $l->aksi = '<div class="right">
                            <button type="button" onclick="detail_data(' . $l->id . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                        </div>';
            endif;

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->m_ppr->count_all($sort, $order),
            "recordsFiltered"   => $this->m_ppr->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data['peminjam'] = $this->m_ppr->get_data_by_id($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        $this->form_validation->set_rules('signature', 'signature', 'required');
        
        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        if (form_error('signature')) $error[] = 'signature';

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


    function ajax_put()
    {
        // $this->_validasi();

        $id_peminjaman_ruangan = $this->input->post('id');
        $atasan = $this->session->userdata('id');
        $status_persetujuan = $this->input->post('status_persetujuan');
        $signature = $this->input->post('signature', false);
        $keterangan = $this->input->post('keterangan_persetujuan');
        $data_persetujuan = array();

        $index = 0;
        foreach($signature as $datasignature) :
            array_push($data_persetujuan, array(
                'id_peminjaman_ruangan'   => $id_peminjaman_ruangan,
                'id_users'                => $atasan,
                'signature'               => $datasignature,
                'status_dokumen'          => $status_persetujuan[$index],
                'keterangan'              => $keterangan[$index],
                'modified_date'           => $this->datetime,
            ));
            
            $index++;
        endforeach;

        $data = $this->db->update_batch('peminjaman_ruangan_persetujuan', $data_persetujuan, 'id_peminjaman_ruangan');

        $persetujuan = $this->db->select('status_dokumen')
                                ->from('peminjaman_ruangan_persetujuan')
                                ->where('id_peminjaman_ruangan', $this->input->post('id', true))
                                ->where('status_dokumen', 'Disetujui')
                                ->limit(1)
                                ->get()
                                ->row();
        
        if ($persetujuan) :
            if ($persetujuan->status_dokumen == 'Disetujui') :
                $status_dokumen = 'Disetujui';
            elseif ($persetujuan->status_dokumen == 'Ditolak') :
                $status_dokumen = 'Ditolak';
            endif;
        else :
            $status_dokumen = 'Menunggu';
        endif;

        $data_peminjaman_ruangan = array(
            'status_dokumen'       => $status_dokumen,
            'modified_date'        => $this->datetime,  
        );
        
        $this->db->where('id', $this->input->post('id'));
        $id_peminjaman_ruangan = $this->db->update('peminjaman_ruangan', $data_peminjaman_ruangan);

        $id_pembuat = $this->db->select('created_by')->from('peminjaman_ruangan')->where('id', $this->input->post('id'))->get()->row();
        $telp_pembuat = $this->db->select('telp_wa')->from('users')->where('id', $id_pembuat->created_by)->get()->row();
        
        if ($data) :
            echo json_encode(array(
                'status' => true,
                'telp_pembuat' => $telp_pembuat->telp_wa,
                'status_dokumen' => $status_dokumen,
                'message' => 'Berhasil mengubah data'
            ));
        else :
            echo json_encode(array(
                'status' => false,
                'message' => 'Gagal mengubah data'
            ));
        endif;
    }

    function get_no_telp_atasan() 
    {
        $id = $this->input->get('id', true);
        $data = $this->db->select('nama, telp_atasan')->from('users')->where('id', $id)->get()->row();
        echo json_encode($data);
    }
}