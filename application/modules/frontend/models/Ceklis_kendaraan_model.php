<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ceklis_kendaraan_model extends CI_Model {

    
    function __construct()
    {
        parent::__construct();
        
    }

    function get_komponen_ceklis()
    {
        return $this->db->get('list_komponen_ceklis')->result();
    }

    function simpan_data($data)
    {
        $this->db->insert('ceklis_kendaraan', $data);
        return $this->db->insert_id();
    }

    function simpan_data_batch($data)
    {
        return $this->db->insert_batch('ceklis_kendaraan_detail', $data, true);
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('ck.*, concat_ws(" - ", k.nopol, k.nama) as no_plat, jk.nama as type_kendaraan');
        $this->db->from('ceklis_kendaraan as ck');
        $this->db->join('kendaraan as k', 'k.id = ck.id_kendaraan');
        $this->db->join('jenis_kendaraan as jk', 'jk.id = ck.id_jenis_kendaraan', 'left');

        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('ck.no_plat', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['no_plat']) $this->db->like('k.nopol', $filter['no_plat'], 'after');
        if (@$filter['kondisi']) $this->db->like('ck.kondisi', $filter['kondisi']);
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
        $sql = 'select ck.*, concat_ws(" - ", k.nopol, k.nama) as no_plat, jk.nama as type_kendaraan 
                from ceklis_kendaraan as ck
                join kendaraan as k on (k.id = ck.id_kendaraan)  
                left join jenis_kendaraan as jk on (jk.id = ck.id_jenis_kendaraan)  
                where ck.id = ' . $id;
        $sql_ = 'select ckd.cek_value as cek, lkc.nama as komponen
                from ceklis_kendaraan_detail as ckd
                join list_komponen_ceklis as lkc on (lkc.id = ckd.id_list_komponen_ceklis)
                where ckd.id_ceklis_kendaraan = ' . $id;
        $data['ceklis'] = $this->db->query($sql)->row();
        $data['komponen'] = $this->db->query($sql_)->result();
        return $data;
    }
    
    function hapus_data($id)
    {
        return $this->db->where('id', $id, true)->delete('ceklis_kendaraan');
    }

}
