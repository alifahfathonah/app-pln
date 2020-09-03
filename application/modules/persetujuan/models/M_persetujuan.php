<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_persetujuan extends CI_Model {

    
    function __construct()
    {
        parent::__construct();
        $this->table = 'setting_persetujuan as sp';    
    }

    function get_data_divisi() 
    {
        return $this->db->select('id, nama')->get('divisi')->result();
    }

    function get_data_kategori_divisi() 
    {
        return $this->db->select('id, nama')->get('kategori_divisi')->result();
    }
    
    function get_data_users() 
    {
        return $this->db->select('us.id, us.nama, d.nama as divisi')
                ->from('users as us')
                ->join('divisi as d', 'd.id = us.id_divisi')
                ->get()->result();
    }
    
    function simpan_data_batch($data)
    {
        return $this->db->insert_batch('setting_persetujuan', $data);
    }

    function get_data_persetujuan_kendaraan()
    {
        return $this->db->select('sp.*, us.nama as users, d.nama as divisi')
                ->from($this->table)
                ->join('users as us', 'us.id = sp.id_users')
                ->join('divisi as d', 'd.id = sp.id_divisi')
                ->where('tipe_dokumen', 'kendaraan', true)
                ->get()
                ->result();
    }

    function get_data_persetujuan_ruangan()
    {
        return $this->db->select('sp.*, us.nama as users, d.nama as divisi')
                ->from($this->table)
                ->join('users as us', 'us.id = sp.id_users')
                ->join('divisi as d', 'd.id = sp.id_divisi')
                ->where('tipe_dokumen', 'ruangan', true)
                ->get()
                ->result();
    }

}
