<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    
    function __construct()
    {
        parent::__construct();
        $this->table = 'users as us';
    }
    
    function verifikasi_user($username)
    {
        return $this->db->select('us.*, 
                        d.id as id_divisi, d.nama as divisi,
                        d.id_atasan, a.nama as atasan,
                        d.id_kategori_divisi, kd.nama as kategori_divisi,
                        d.is_allow_login, d.is_need_approval', true)
                ->from($this->table)
                ->join('divisi as d', 'd.id = us.id_divisi')
                ->join('atasan as a', 'a.id = d.id_atasan', 'left')
                ->join('kategori_divisi as kd', 'kd.id = d.id_kategori_divisi', 'left')
                ->where('us.username', $username, true)
                ->or_where('us.email', $username, true)
                ->get()->row();
    }

}
