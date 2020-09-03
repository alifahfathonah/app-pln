<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen_hadir extends SM_Controller {

    function ruangan($id_peminjaman_ruangan)
    {
        if (empty($this->session->userdata('id'))) :
            $dataurl = array(
                    'url_absen'  => 'absen_hadir/ruangan/' . $id_peminjaman_ruangan,
            );
            $this->session->set_userdata($dataurl);
            redirect('auth');
        endif;

        $id_user = $this->session->userdata('id');
        $waktu = date('Y-d-m H:i:s');
        $status = 'Hadir';

        $this->load->model('Absen_hadir_model', 'absen_hadir');
        $cek = $this->absen_hadir->cek_absen_hadir_ruangan($id_peminjaman_ruangan, $id_user);

        if ($cek->jumlah > 0) :
            $this->session->set_flashdata('pesan_absen_error', 'Anda sudah melakukan absen kehadiran');
            redirect(base_url('booking/ruangan'));
        else :
            $data = array(
                'id_peminjaman_ruangan' => $id_peminjaman_ruangan,
                'id_users'              => $id_user,
                'waktu'                 => $waktu,
                'status'                => 'Hadir',
            );

            $data = $this->db->insert('daftar_hadir', $data);

            $this->session->set_flashdata('pesan_absen_success', 'Anda berhasil melakukan absen kehadiran');
            redirect(base_url('booking/ruangan'));
        endif;
    }

}
