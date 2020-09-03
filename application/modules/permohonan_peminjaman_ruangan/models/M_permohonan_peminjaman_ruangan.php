<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_permohonan_peminjaman_ruangan extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->users = $this->session->userdata('id');
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('pr.*, 
                        concat_ws(" - ", r.kode, r.nama) as ruangan, 
                        us.nama as diajukan_oleh, 
                        usr.nama as atasan');
        $this->db->from('peminjaman_ruangan as pr');
        $this->db->join('peminjaman_ruangan_persetujuan as prp', 'prp.id_peminjaman_ruangan = pr.id');
        $this->db->join('ruangan as r', 'r.id = pr.id_ruangan');
        $this->db->join('users as us', 'us.id = pr.id_users');
        $this->db->join('users as usr', 'usr.id = prp.id_users');

        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('pr.no_dokumen', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['no_dokumen']) $this->db->like('pr.no_dokumen', $filter['no_dokumen'], 'after');
        if (@$filter['nama_kegiatan']) $this->db->like('pr.nama_kegiatan', $filter['nama_kegiatan']);
        if (@$filter['status_dokumen']) $this->db->like('pr.status_dokumen', $filter['status_dokumen']);
    }

    function get_datatables($sort = null, $order = null)
    {
        $this->_get_datatables_query($sort, $order);
        $this->db->where('prp.id_users', $this->users, true);

        if ($_POST['length'] != -1) :
            $this->db->limit($_POST['length'], $_POST['start']);
        endif;

        // $this->db->get(); echo $this->db->last_query(); die;
        return $this->db->get()->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->get()->num_rows();
    }

    function count_all()
    {
        $this->_get_datatables_query();
        $db_results = $this->db->get();
        $results    = $db_results->result();
        $num_rows   = $db_results->num_rows();
        return $num_rows;
    }

    // get data by id
    function get_data_by_id($id)
    {
        $this->db->select('pr.*, 
                        concat_ws(" - ", r.kode, r.nama) as ruangan, 
                        us.nama as diajukan_oleh, 
                        usr.nama as atasan, 
                        prp.signature, 
                        prp.status_dokumen as status_dokumen_persetujuan,
                        prp.keterangan as keterangan_persetujuan');
        $this->db->from('peminjaman_ruangan as pr');
        $this->db->join('peminjaman_ruangan_persetujuan as prp', 'prp.id_peminjaman_ruangan = pr.id');
        $this->db->join('ruangan as r', 'r.id = pr.id_ruangan');
        $this->db->join('users as us', 'us.id = pr.id_users');
        $this->db->join('users as usr', 'usr.id = prp.id_users');
        // $this->db->join('makan_siang as mk', 'mk.id = pr.id_makan_siang');
        // $this->db->join('snack as sn', 'sn.id = pr.id_snack');
        $this->db->where('pr.id', $id);
        $this->db->where('prp.id_users', $this->session->userdata('id'));
        return $this->db->get()->row();
        // $this->db->get(); echo $this->db->last_query(); die;
    }


}
