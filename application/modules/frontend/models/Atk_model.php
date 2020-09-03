<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Atk_model extends CI_Model {

    
    function __construct()
    {
        parent::__construct();
        
    }
    
    function simpan_data($data)
    {
        $this->db->insert('atk', $data);
        return $this->db->insert_id();
    }
    
    function save_batch_data_detail($request)
    {
        return $this->db->insert_batch('detail_atk', $request);
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('a.*,
                        us.nama as users'
        );
        $this->db->from('atk a');
        $this->db->join('users us', 'us.id = a.id_user', 'left');

        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('a.no_notadinas', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['no_notadinas']) $this->db->like('a.no_notadinas', $filter['no_notadinas'], 'after');
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
        $sql = 'select a.*, us.nama as users
                from atk a
                join users us on (us.id = a.id_user)
                where a.id = ' . $id;
        $sql_ = 'select b.nama as barang, b.satuan, da.qty_request, da.qty_approval
                from detail_atk da
                join barang b on (b.id = da.id_barang)
                where da.id_atk = ' . $id;
        $data['atk'] = $this->db->query($sql)->row();
        $data['komponen'] = $this->db->query($sql_)->result();
        return $data;
    }
}

/* End of file Atk_model.php */
