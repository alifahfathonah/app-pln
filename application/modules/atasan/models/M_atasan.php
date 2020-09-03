<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_atasan extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'atasan';
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('nama', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['nama']) $this->db->like('nama', $filter['nama']);
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
