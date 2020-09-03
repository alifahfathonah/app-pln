<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kendaraan extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'kendaraan';
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('k.*, jk.nama as jenis_kendaraan');
        $this->db->from($this->table . ' as k');
        $this->db->join('jenis_kendaraan as jk', 'jk.id = k.id');
        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('k.nama', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['nama']) $this->db->like('k.nama', $filter['nama']);
        if (@$filter['nopol']) $this->db->or_like('k.nopol', $filter['nopol']);
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

    // get data by id
    function get_data_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // simpan data
    function simpan_data($request)
    {
        return $this->db->insert($this->table, $request);
    }

    // update data
    function update_data($request)
    {
        return $this->db->where('id', $request['id'], true)->update($this->table, $request);
    }

    // hapus data
    function hapus_data($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
