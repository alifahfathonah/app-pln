<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen_hadir_model extends CI_Model {

    function cek_absen_hadir_ruangan($id_peminjaman_ruangan, $id_users)
    {
        $sql = "
            select count(dh.id_users) as jumlah 
            from daftar_hadir as dh 
            join peminjaman_ruangan as pr on pr.id = dh.id_peminjaman_ruangan 
            where dh.id_peminjaman_ruangan = ".$id_peminjaman_ruangan." 
            and dh.id_users = ".$id_users." 
            or dh.waktu between pr.tgl_start and pr.tgl_end
        ";

        return $this->db->query($sql)->row();
    }    

}
