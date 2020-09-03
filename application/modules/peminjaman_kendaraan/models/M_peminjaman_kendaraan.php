<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_peminjaman_kendaraan extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'peminjaman_kendaraan';
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('pk.*, k.nopol, k.nama as kendaraan, us.nama as diajukan_oleh, usr.nama as driver');
        $this->db->from($this->table . ' as pk');
        $this->db->join('kendaraan as k', 'k.id = pk.id_kendaraan', 'left');
        $this->db->join('users as us', 'us.id = pk.id_atasan', 'left');
        $this->db->join('users as usr', 'usr.id = pk.id_driver', 'left');
        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('k.nama', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['nama']) $this->db->like('k.nama', $filter['nama']);
        if (@$filter['status_dokumen']) $this->db->like('pk.dokumen_status', $filter['status_dokumen']);
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
        $this->db->select('pk.*, k.nopol, d.nama as divisi, usr.id_divisi, usr.nama, 
                            usr.telp_wa as telp, k.nama as kendaraan, 
                            us.nama as diajukan_oleh, usr.nama as driver,
                            k.foto as foto_kendaraan, jk.nama as jenis_kendaraan, k.kapasitas, 
                            k.created_date as tgl_dibuat_kendaraan, usrr.nama as dibuat_oleh_kendaraan');
        $this->db->from($this->table . ' as pk');
        $this->db->join('kendaraan as k', 'k.id = pk.id_kendaraan', 'left');
        $this->db->join('jenis_kendaraan as jk', 'jk.id = k.id_jenis_kendaraan', 'left');
        $this->db->join('users as us', 'us.id = pk.id_atasan', 'left');
        $this->db->join('users as usr', 'usr.id = pk.id_driver', 'left');
        $this->db->join('users as usrr', 'usrr.id = k.id_users', 'left');
        $this->db->join('divisi as d', 'd.id = usr.id_divisi', 'left');
        $this->db->where('pk.id', $id);
        return $this->db->get()->row();
        // $this->db->get(); echo $this->db->last_query(); die;
    }

    function get_data_personil($id_peminjaman_kendaraan)
    {
        $this->db->select('*')->from('peminjaman_kendaraan_personil')->where('id_peminjaman_kendaraan', $id_peminjaman_kendaraan);
        return $this->db->get()->result();
    }

    // simpan data
    function simpan_data_peminjaman_kendaraan($data_peminjaman_kendaraan)
    {
        $this->db->insert('peminjaman_kendaraan', $data_peminjaman_kendaraan, true);
        return $this->db->insert_id();
    }

    function save_batch_data_personil_peminjaman_kendaraan($request)
    {
        return $this->db->insert_batch('peminjaman_kendaraan_personil', $request);
    }

    function save_batch_data_persetujuan_peminjaman_kendaraan($request)
    {
        return $this->db->insert_batch('peminjaman_kendaraan_persetujuan', $request);
    }

    // update data
    function update_data_peminjaman_kendaraan($data_peminjaman_kendaraan, $id)
    {
        return $this->db->where('id', $id, true)->update('peminjaman_kendaraan', $data_peminjaman_kendaraan);
    }

    // hapus data
    function hapus_data($id)
    {
        return $this->db->where('id', $id, true)->delete($this->table);
    }
}
