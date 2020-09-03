<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Permohonan_peminjaman_kendaraan extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_permohonan_peminjaman_kendaraan', 'm_ppk');
        $this->load->model('persetujuan/M_persetujuan', 'm_persetujuan');
        $this->load->model('auto/M_auto', 'm_auto');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function index()
    {
        $this->template->add_title_segment('Permohonan Peminjaman Kendaraan');
        $this->template->add_js(base_url() . 'assets/js/jq-signature.min.js');

        $dariDB = $this->m_auto->cek_no_dokumen();
        // contoh FM-SMK3-VHC-0001, angka 3 adalah awal pengambilan angka, dan 4 jumlah angka yang diambil
        $nourut = substr($dariDB, 12, 4);
        $no_dokumen_sekarang = $nourut + 1;

        $data = array(
            'active'         => 'permohonan-peminjaman-kendaraan',
            'breadcrumb'     => 'Permohonan Peminjaman Kendaraan',
            'modal'          => array('permohonan_peminjaman_kendaraan/modal'),
            'no_dokumen'     => $no_dokumen_sekarang,
            'persetujuan'    => $this->m_persetujuan->get_data_persetujuan_kendaraan(),
            'status_dokumen' => $this->m_auto->get_status_dokumen()
        );

        $this->template->render('index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->m_ppk->get_datatables($sort, $order);
        foreach ($list as $l) :

            if ($l->status_dokumen === 'Menunggu') :
                $status_dokumen = '<span class="badge badge-warning"><i class="fas fa-spinner fa-spin mr-2"></i>' . $l->status_dokumen . '</span>';
            elseif ($l->status_dokumen === 'Disetujui') :
                $status_dokumen = '<span class="badge badge-success"><i class="fas fa-thumbs-up mr-2"></i>' . $l->status_dokumen . '</span>';
            elseif ($l->status_dokumen === 'Ditolak') :
                $status_dokumen = '<span class="badge badge-danger"><i class="fas fa-ban mr-2"></i>' . $l->status_dokumen . '</span>';
            else : 
                $status_dokumen = '<span class="badge badge-info"><i class="fas fa-check-circle mr-2"></i>' . $l->status_dokumen . '</span>';

            endif;

            $no++;
            $l->no   = $no;
            $l->no_dokumen = $l->no_dokumen;
            $l->kendaraan = $l->nopol . " - " .$l->kendaraan;
            $l->tujuan = $l->tujuan;
            $l->diajukan_oleh = $l->diajukan_oleh;
            $l->created_date = $l->created_date;
            $l->status = $status_dokumen;
            
            if ($l->status_dokumen === 'Disetujui') :
                if ($this->session->userdata('id_divisi') === '26') :
                    $l->aksi = '<div class="right">
                            <button type="button" onclick="send_notif_to_traveladmin(' . $l->id_peminjaman_kendaraan . ')" title="Send Notifikasi To Travel Admin" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-car"></i></button>
                            <button type="button" onclick="send_notif_to_pemohon(' . $l->id_peminjaman_kendaraan . ')" title="Send Notifikasi To Pemohon" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-paper-plane"></i></button>
                            <button type="button" onclick="detail_data(' . $l->id_peminjaman_kendaraan . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                        </div>';
                else :             
                    $l->aksi = '<div class="right">
                            <button type="button" onclick="send_notif_to_bos(' . $l->id_peminjaman_kendaraan . ')" title="Send Notifikasi To Bos" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-user-secret"></i></button>
                            <button type="button" onclick="send_notif_to_driver(' . $l->id_peminjaman_kendaraan . ')" title="Send Notifikasi To Driver" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-id-card-alt"></i></button>
                            <button type="button" onclick="send_notif_to_pemohon(' . $l->id_peminjaman_kendaraan . ')" title="Send Notifikasi To Pemohon" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-paper-plane"></i></button>
                            <button type="button" onclick="detail_data(' . $l->id_peminjaman_kendaraan . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                        </div>';                
                endif;
            else :
                $l->aksi = '<div class="right">
                        <button type="button" onclick="detail_data(' . $l->id_peminjaman_kendaraan . ')" title="Detail Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-eye"></i></button>
                    </div>';                
            endif;

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->m_ppk->count_all($sort, $order),
            "recordsFiltered"   => $this->m_ppk->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data['peminjam'] = $this->m_ppk->get_data_by_id($id);
        $data['personil'] = $this->m_ppk->get_data_personil($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        if ($this->session->userdata('id_divisi') === '26') :
            $this->form_validation->set_rules('kendaraan', 'kendaraan', 'required');
            $this->form_validation->set_rules('driver', 'driver', 'required');
        endif;
        
        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;
        
        if (form_error('kendaraan')) $error[] = 'kendaraan';
        if (form_error('driver')) $error[] = 'driver';

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
        $this->_validasi();

        $persetujuan = $this->db->select('status_dokumen')
                                ->from('peminjaman_kendaraan_persetujuan')
                                ->where('id_peminjaman_kendaraan', $this->input->post('id', true))
                                ->where('status_dokumen', 'Disetujui')
                                ->limit(1)
                                ->get()
                                ->row();

        if ($persetujuan) :
            if ($persetujuan->status_dokumen === 'Disetujui') :
                $dokumen_status = 'Disetujui';
            elseif ($persetujuan->status_dokumen === 'Ditolak') :
                $dokumen_status = 'Ditolak';
            endif;
        else :
            $dokumen_status = 'Menunggu';
        endif;
        
        if ($this->session->userdata('id_divisi') === '26') :
            $data_permohonan_peminjaman_kendaraan = array(
                'id_kendaraan'         => $this->input->post('kendaraan', true)?: NULL,
                'is_use_driver'        => $this->input->post('is_use_driver', true),
                'id_driver'            => $this->input->post('driver', true)?: NULL,
                'voucher'              => $this->input->post('voucher', true)?: NULL,
                'dokumen_status'       => $dokumen_status,
                'modified_date'        => $this->datetime,  
            );
        else :
            $data_permohonan_peminjaman_kendaraan = array(
                'dokumen_status'       => $dokumen_status,
                'modified_date'        => $this->datetime,  
            );
        endif;

        // var_dump($data_permohonan_peminjaman_kendaraan); die;
        
        $id_permohonan_peminjaman_kendaraan = $this->m_ppk->update_data_permohonan_peminjaman_kendaraan($data_permohonan_peminjaman_kendaraan, $this->input->post('id', true));
          
        $id            = $this->input->post('id', true); 
        $nama          = $this->input->post('nama_personil', true); 
        $divisi        = $this->input->post('nama_divisi_personil', true); 
        $jabatan       = $this->input->post('nama_jabatan_personil', true); 
        $telp          = $this->input->post('no_telp_personil', true);
        $data_personil = array();

        $index = 0;
        foreach($nama as $datanama) :
            array_push($data_personil, array(
                'id_peminjaman_kendaraan' => $id,
                'nama'                    => $datanama,
                'divisi'                  => $divisi[$index],  
                'jabatan'                 => $jabatan[$index],
                'telp'                    => $telp[$index],
            ));
            
            $index++;
        endforeach;
        
        $data = $this->db->update_batch('peminjaman_kendaraan_personil', $data_personil, 'id_peminjaman_kendaraan');

        $atasan = $this->session->userdata('id');
        $status_persetujuan = $this->input->post('status_persetujuan');
        $signature = $this->input->post('signature', false);
        $keterangan = $this->input->post('keterangan_persetujuan');
        $data_persetujuan = array();

        $index = 0;
        foreach($signature as $datasignature) :
            array_push($data_persetujuan, array(
                'id_users'                => $atasan,
                'signature'               => $datasignature,
                'status_dokumen'          => $status_persetujuan[$index],
                'keterangan'              => $keterangan[$index],
                'modified_date'           => $this->datetime,
            ));
            
            $index++;
        endforeach;

        $data = $this->db->update_batch('peminjaman_kendaraan_persetujuan', $data_persetujuan, 'id_users');

        if ($this->session->userdata('id') === '26') :
            $traveladmin = $this->db->select('telp_wa')->from('users')->where('id', '394')->get()->row(); 
        else :
            $traveladmin = 0;
        endif;

        if ($id_permohonan_peminjaman_kendaraan) :
            echo json_encode(array(
                'status'      => true,
                'id'          => $id_permohonan_peminjaman_kendaraan,
                'traveladmin' => $traveladmin,
                'message'     => 'Berhasil mengubah data'
            ));
        else :
            echo json_encode(array(
                'status'  => false,
                'message' => 'Gagal mengubah data'
            ));
        endif;
    }

    function ajax_delete()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_ppk->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }

    function get_data_pemohon()
    {
        $data = $this->m_ppk->get_data_pemohon_by_id($this->input->get('id', true));
        echo json_encode($data);
    }

    function get_data_traveladmin()
    {
        $data = $this->m_ppk->get_data_traveladmin_by_id();
        echo json_encode($data);
    }

    function get_data_driver()
    {
        $data = $this->m_ppk->get_data_driver_by_id($this->input->get('id', true));
        echo json_encode($data);
    }
   
}
