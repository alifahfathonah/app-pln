<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_tamu_model extends CI_Model {

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('bt.*,
                        coalesce(bt.tanggal_keluar, "-") as tanggal_keluar, 
                        us.nama as bertemu_dengan, 
                        coalesce(usr.nama, "-") as petugas_masuk, 
                        coalesce(usrr.nama, "-") as petugas_keluar');
        $this->db->from('buku_tamu as bt');
        $this->db->join('users as us', 'us.id = bt.id_atasan');
        $this->db->join('users as usr', 'usr.id = bt.id_petugas_masuk');
        $this->db->join('users as usrr', 'usrr.id = bt.id_petugas_keluar', 'left');

        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('bt.tanggal_kunjungan', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['nama']) $this->db->like('bt.nama', $filter['nama'], 'after');
        if (@$filter['unit']) $this->db->like('bt.unit', $filter['unit']);
    }

    function get_datatables($sort = null, $order = null)
    {
        $this->_get_datatables_query($sort, $order);

        if ($_POST['length'] != -1) :
            $this->db->limit($_POST['length'], $_POST['start']);
        endif;

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

    function get_data_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('buku_tamu')->row();
    }

    function simpan_data($data)
    {
        return $this->db->insert('buku_tamu', $data);
    }

    function update_data($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('buku_tamu', $data);
    }


}
