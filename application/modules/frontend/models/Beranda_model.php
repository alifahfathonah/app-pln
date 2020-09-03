<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda_model extends CI_Model {

    function count_ceklis_kendaraan() 
    {
        return $this->db->count_all_results('ceklis_kendaraan');
    }    

    function count_buku_tamu() 
    {
        return $this->db->count_all_results('buku_tamu');
    }    

    function count_ruangan() 
    {
        $this->db->where('status_dokumen', 'Disetujui');
        return $this->db->count_all_results('peminjaman_ruangan');
    }    

    function count_kendaraan() 
    {
        $this->db->where('dokumen_status', 'Disetujui');
        return $this->db->count_all_results('peminjaman_kendaraan');
    }    

}
