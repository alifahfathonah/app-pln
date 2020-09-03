<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_divisi extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'divisi as d';
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('d.*, kd.nama as kategori_divisi, a.nama as atasan');
        $this->db->from($this->table);
        $this->db->join('kategori_divisi as kd', 'kd.id = d.id_kategori_divisi');
        $this->db->join('atasan as a', 'a.id = d.id_atasan',' left');

        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('d.nama', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['nama']) $this->db->like('d.nama', $filter['nama']);
        if (@$filter['kategori_divisi']) $this->db->or_like('kd.id', $filter['kategori_divisi']);
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
        return $this->db->insert('divisi', $request);
    }

    // update data
    function update_data($request)
    {
        return $this->db->where('id', $request['id'], true)->update($this->table, $request);
    }

    // hapus data
    function hapus_data($id)
    {
        return $this->db->where('id', $id)->delete('divisi');
    }
}
